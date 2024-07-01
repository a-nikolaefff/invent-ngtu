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

    public function scopeGetByParams(Builder $query, array $queryParams): void
    {
        $filter = app()->make(
            BuildingFilter::class,
            ['queryParams' => $queryParams]
        );

        $query->select('buildings.*')
            ->leftjoin(
                'building_types',
                'buildings.building_type_id',
                '=',
                'building_types.id'
            )
            ->with(
                'type',
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
                if ($sortColumn === 'building_type_name') {
                    return $query->orderBy('building_types.name', $sortDirection);
                }
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
