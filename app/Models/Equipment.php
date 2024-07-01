<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use App\Filters\EquipmentFilter;
use App\Filters\RepairFilter;
use App\Models\Interfaces\GetByParams;
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

class Equipment extends Model implements HasMedia, GetByParams
{
    use HasFactory, Filterable, InteractsWithMedia, StoreMedia;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'equipment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'name',
            'number',
            'description',
            'acquisition_date',
            'not_in_operation',
            'decommissioned',
            'decommissioning_date',
            'decommissioning_reason',
            'room_id',
            'equipment_type_id',
        ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts
        = [
            'not_in_operation' => 'boolean',
            'decommissioned' => 'boolean',
            'acquisition_date' => 'date',
            'decommissioning_date' => 'date',
        ];

    public function setNotInOperationAttribute($value)
    {
        $this->attributes['not_in_operation'] = (boolean) $value;
    }

    public function setDecommissionedAttribute($value)
    {
        $this->attributes['decommissioned'] = (boolean) $value;
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function scopeGetByParams(Builder $query, array $queryParams): void
    {
        $filter = app()->make(
            EquipmentFilter::class,
            ['queryParams' => $queryParams]
        );

        $query->select('equipment.*')
            ->leftjoin(
                'equipment_types',
                'equipment.equipment_type_id',
                '=',
                'equipment_types.id'
            )
            ->leftjoin(
                'rooms',
                'equipment.room_id',
                '=',
                'rooms.id'
            )
            ->leftjoin(
                'buildings',
                'rooms.building_id',
                '=',
                'buildings.id'
            )
            ->leftjoin(
                'departments',
                'rooms.department_id',
                '=',
                'departments.id'
            )
            ->with(
                'type',
                'room',
                'room.building',
                'room.department',
            )
            ->when(
                Auth::user()->cannot('viewAll', Equipment::class),
                function ($query) {
                    return $query->whereIn(
                        'rooms.department_id',
                        Auth::user()->department->getSelfAndDescendants()
                            ->pluck('id')->toArray()
                    );
                }
            )
            ->filter($filter)
            ->sort($queryParams);
    }

    public function scopeGetByParamsAndRoom(
        Builder $query,
        array $queryParams,
        Room $room
    ): void {
        $filter = app()->make(
            EquipmentFilter::class,
            ['queryParams' => $queryParams]
        );

        $query->where('room_id', $room->id)
            ->select('equipment.*')
            ->leftjoin(
                'equipment_types',
                'equipment.equipment_type_id',
                '=',
                'equipment_types.id'
            )
            ->leftjoin(
                'rooms',
                'equipment.room_id',
                '=',
                'rooms.id'
            )
            ->leftjoin(
                'buildings',
                'rooms.building_id',
                '=',
                'buildings.id'
            )
            ->leftjoin(
                'departments',
                'rooms.department_id',
                '=',
                'departments.id'
            )
            ->with(
                'type',
                'room',
                'room.building',
                'room.department',
            )
            ->filter($filter)
            ->sort($queryParams);
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
            !empty($sortColumn),
            function ($query) use ($sortColumn, $sortDirection) {
                $sortColumn = match ($sortColumn) {
                    'equipment_type_name' => 'equipment_types.name',
                    'department_name' => 'departments.name',
                    'location' => 'buildings.name',
                    default => 'equipment.' . $sortColumn,
                };
                if ($sortColumn !== 'buildings.name') {
                    return $query->orderBy($sortColumn, $sortDirection);
                } else {
                    return $query->orderBy($sortColumn, $sortDirection)
                        ->orderBy('rooms.number',$sortDirection);
                }
            }
        );
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 200)
            ->nonQueued();
    }
}
