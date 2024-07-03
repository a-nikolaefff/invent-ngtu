<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use App\Filters\RepairFilter;
use App\Models\Traits\Filterable;
use App\Models\Traits\StoreMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Repair extends Model implements HasMedia
{
    use HasFactory, Filterable, InteractsWithMedia, StoreMedia;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'repairs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'short_description',
            'full_description',
            'start_date',
            'end_date',
            'equipment_id',
            'repair_type_id',
            'repair_status_id',
        ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts
        = [
            'start_date' => 'date',
            'end_date' => 'date',
        ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(RepairType::class, 'repair_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(RepairStatus::class, 'repair_status_id');
    }

    public function scopeGetByParams(
        Builder $query,
        array $params
    ): void {
        $query->select('repairs.*')
            ->leftJoin(
                'equipment',
                'repairs.equipment_id',
                '=',
                'equipment.id'
            )
            ->leftJoin('rooms', 'equipment.room_id', '=', 'rooms.id')
            ->leftJoin(
                'repair_types',
                'repairs.repair_type_id',
                '=',
                'repair_types.id'
            )
            ->with(
                'type',
                'status',
                'equipment',
            )
            ->when(
                Auth::user()->hasRole(UserRoleEnum::Employee),
                function ($query) {
                    return $query->whereIn(
                        'rooms.department_id',
                        Auth::user()->department->getSelfAndDescendants()->pluck('id')->toArray()
                    );
                }
            )
            ->filter(new RepairFilter($params))
            ->sort($params);
    }

    public function scopeGetByParamsAndEquipment(
        Builder $query,
        array $params,
        Equipment $equipment
    ): void {
        $query->where('repairs.equipment_id', $equipment->id)
            ->select('repairs.*')
            ->leftjoin(
                'repair_types',
                'repairs.repair_type_id',
                '=',
                'repair_types.id'
            )
            ->with('type', 'status')
            ->filter(new RepairFilter($params))
            ->sort($params);
    }

    public function scopeSort(
        Builder $query,
        array $queryParams,
        string $defaultSortColumn = '',
        string $defaultSortDirection = 'asc'
    ): void {
        $sortColumn = $queryParams['sort'] ?? $defaultSortColumn;
        $sortDirection = $queryParams['direction'] ?? $defaultSortDirection;
        $query->when(
            ! empty($sortColumn),
            function ($query) use ($sortColumn, $sortDirection) {
                $sortColumn = match ($sortColumn) {
                    'equipment_name' => 'equipment.name',
                    'repair_type_name' => 'repair_types.name',
                    default => 'repairs.'.$sortColumn,
                };

                return $query->orderBy($sortColumn, $sortDirection);
            }
        );
    }

    public function registerMediaConversions(
        Media $media = null
    ): void {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 200);
    }
}
