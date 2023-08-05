<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RepairApplication extends Model implements HasMedia
{
    use HasFactory, Filterable, InteractsWithMedia;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'repair_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'short_description',
            'full_description',
            'response',
            'application_date',
            'response_date',
            'equipment_id',
            'repair_application_status_id',
            'user_id',
        ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts
        = [
            'application_date' => 'date',
            'response_date' => 'date',
        ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(
            RepairApplicationStatus::class,
            'repair_application_status_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
                    'equipment_name' => 'equipment.name',
                    'user_name' => 'users.name',
                    default => 'repair_applications.' . $sortColumn,
                };

                return $query->orderBy($sortColumn, $sortDirection);
            }
        );
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 200);
    }
}
