<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\EquipmentFilter;
use App\Models\Traits\Filterable;
use App\Models\Traits\StoreMedia;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Equipment extends Model implements HasMedia
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

    /**
     * Set not in operation attribute
     */
    public function setNotInOperationAttribute($value): void
    {
        $this->attributes['not_in_operation'] = (bool) $value;
    }

    /**
     * Set decommissioned attribute
     */
    public function setDecommissionedAttribute($value): void
    {
        $this->attributes['decommissioned'] = (bool) $value;
    }

    /**
     * Get room type
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }

    /**
     * Get the room where equipment placed
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Get equipment list by parameters
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Filter parameters
     *
     * @throws BindingResolutionException
     */
    public function scopeGetByParams(Builder $query, array $params): void
    {
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
            ->filter(new EquipmentFilter($params))
            ->sort($params);
    }

    /**
     * Get equipment list by parameters and room
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Filter parameters
     * @param  Room  $room Target room
     *
     * @throws BindingResolutionException
     */
    public function scopeGetByParamsAndRoom(
        Builder $query,
        array $params,
        Room $room
    ): void {
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
            ->filter(new EquipmentFilter($params))
            ->sort($params);
    }

    /**
     * Apply sort
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Sort parameters
     * @param  string  $defaultSortColumn Default sort column
     * @param  string  $defaultSortDirection Default sort direction
     */
    public function scopeSort(
        Builder $query,
        array $params,
        string $defaultSortColumn = '',
        string $defaultSortDirection = 'asc'
    ): void {
        $sortColumn = $params['sort'] ?? $defaultSortColumn;
        $sortDirection = $params['direction'] ?? $defaultSortDirection;
        $query->when(
            ! empty($sortColumn),
            function ($query) use ($sortColumn, $sortDirection) {
                $sortColumn = match ($sortColumn) {
                    'equipment_type_name' => 'equipment_types.name',
                    'department_name' => 'departments.name',
                    'location' => 'buildings.name',
                    default => 'equipment.'.$sortColumn,
                };
                if ($sortColumn !== 'buildings.name') {
                    return $query->orderBy($sortColumn, $sortDirection);
                } else {
                    return $query->orderBy($sortColumn, $sortDirection)
                        ->orderBy('rooms.number', $sortDirection);
                }
            }
        );
    }

    /**
     * Register media conversions for image files
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 200)
            ->nonQueued();
    }
}
