<?php

namespace App\Models;

use App\Filters\EquipmentFilter;
use App\Filters\RoomFilter;
use App\Models\Interfaces\GetByParams;
use App\Models\Traits\Filterable;
use App\Models\Traits\StoreMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Room extends Model implements HasMedia, GetByParams
{
    use HasFactory, Filterable, InteractsWithMedia, StoreMedia;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'name',
            'number',
            'room_type_id',
            'building_id',
            'floor',
            'department_id',
        ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the equipment located in the room.
     *
     * @return HasMany
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'room_id');
    }

    public function scopeGetByParams(Builder $query, array $queryParams): void
    {
        $filter = app()->make(
            RoomFilter::class,
            ['queryParams' => $queryParams]
        );

        $query->select('rooms.*')
            ->leftjoin(
                'room_types',
                'rooms.room_type_id',
                '=',
                'room_types.id'
            )
            ->leftjoin(
                'departments',
                'rooms.department_id',
                '=',
                'departments.id'
            )
            ->leftjoin(
                'buildings',
                'rooms.building_id',
                '=',
                'buildings.id'
            )
            ->with(
                'type',
                'department',
                'building',
            )
            ->filter($filter)
            ->sort($queryParams);
    }

    public function scopeGetByParamsAndBuilding(
        Builder $query,
        array $queryParams,
        Building $building
    ): void {
        $filter = app()->make(
            RoomFilter::class,
            ['queryParams' => $queryParams]
        );

        $query->where('building_id', $building->id)
            ->select('rooms.*')
            ->leftjoin(
                'room_types',
                'rooms.room_type_id',
                '=',
                'room_types.id'
            )
            ->leftjoin(
                'departments',
                'rooms.department_id',
                '=',
                'departments.id'
            )
            ->with('type', 'department')
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
                    'room_type_name' => 'room_types.name',
                    'building_name' => 'buildings.name',
                    'department_name' => 'departments.name',
                    default => $sortColumn,
                };
                return $query->orderBy($sortColumn, $sortDirection);
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
