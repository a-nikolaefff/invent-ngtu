<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Building extends Model implements HasMedia
{
    use Filterable, InteractsWithMedia;

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
