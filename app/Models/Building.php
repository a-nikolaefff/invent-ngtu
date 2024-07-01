<?php

namespace App\Models;

use App\Filters\BuildingFilter;
use App\Models\Interfaces\GetByParams;
use App\Models\Traits\Filterable;
use App\Models\Traits\StoreMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Building extends Model implements HasMedia, GetByParams
{
    use Filterable, InteractsWithMedia, StoreMedia;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'buildings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'name',
            'address',
            'floor_amount',
            'building_type_id',
        ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['type'];

    /**
     * Get the type of the building
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(BuildingType::class, 'building_type_id');
    }

    /**
     * Get the rooms located in the building.
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'building_id');
    }

    /**
     * Get building list by parameters
     *
     * @param Builder $query Database query builder
     * @param array $params Filter parameters
     */
    public function scopeGetByParams(Builder $query, array $params): void
    {
        $query->select('buildings.*')
            ->leftjoin(
                'building_types',
                'buildings.building_type_id',
                '=',
                'building_types.id'
            )
            ->with('type')
            ->filter(new BuildingFilter($params))
            ->sort($params);
    }

    /**
     * Apply sort
     *
     * @param Builder $query Database query builder
     * @param array $params Sort parameters
     * @param string $defaultSortColumn Default sort column
     * @param string $defaultSortDirection Default sort direction
     */
    public function scopeSort(
        Builder $query,
        array   $params,
        string  $defaultSortColumn = '',
        string  $defaultSortDirection = 'asc'
    ): void {
        $sortColumn = $params['sort'] ?? $defaultSortColumn;
        $sortDirection = $params['direction'] ?? $defaultSortDirection;
        $query->when(
            !empty($sortColumn),
            function ($query) use ($sortColumn, $sortDirection) {
                if ($sortColumn === 'building_type_name') {
                    return $query->orderBy('building_types.name', $sortDirection);
                }
                return $query->orderBy($sortColumn, $sortDirection);
            }
        );
    }

    /**
     * Register media conversions for image files
     *
     * @param Media|null $media
     * @return void
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 200)
            ->nonQueued();
    }
}
