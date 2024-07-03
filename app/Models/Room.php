<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\RoomFilter;
use App\Models\Traits\Filterable;
use App\Models\Traits\StoreMedia;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Room extends Model implements HasMedia
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

    /**
     * Get the room type
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    /**
     * Get the building where the room placed
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * Get the room department
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the equipment located in the room.
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'room_id');
    }

    /**
     * Get room list by parameters
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Filter parameters
     *
     * @throws BindingResolutionException
     */
    public function scopeGetByParams(Builder $query, array $params): void
    {
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
            ->filter(new RoomFilter($params))
            ->sort($params);
    }

    /**
     * Get room list by parameters and building
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Filter parameters
     * @param  Building  $building Target building
     *
     * @throws BindingResolutionException
     */
    public function scopeGetByParamsAndBuilding(
        Builder $query,
        array $params,
        Building $building
    ): void {
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
            ->filter(new RoomFilter($params))
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
                    'room_type_name' => 'room_types.name',
                    'building_name' => 'buildings.name',
                    'department_name' => 'departments.name',
                    default => $sortColumn,
                };

                return $query->orderBy($sortColumn, $sortDirection);
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
