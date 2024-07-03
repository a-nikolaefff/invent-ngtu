<?php

namespace App\Models;

use App\Filters\RepairApplicationFilter;
use App\Models\Traits\Filterable;
use App\Models\Traits\StoreMedia;
use App\Observers\RepairApplicationObserver;
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

class RepairApplication extends Model implements HasMedia
{
    use HasFactory, Filterable, InteractsWithMedia, StoreMedia;

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

    /**
     * Get the equipment in repair application
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    /**
     * Get the status of repair application
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(
            RepairApplicationStatus::class,
            'repair_application_status_id'
        );
    }

    /**
     * Get the user who sent repair application
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get repair application list by parameters
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Filter parameters
     *
     * @throws BindingResolutionException
     */
    public function scopeGetByParams(Builder $query, array $params): void
    {
        $query->select('repair_applications.*')
            ->leftjoin(
                'equipment',
                'repair_applications.equipment_id',
                '=',
                'equipment.id'
            )
            ->leftjoin(
                'users',
                'repair_applications.user_id',
                '=',
                'users.id'
            )
            ->with('status', 'equipment', 'user')
            ->when(
                Auth::user()->cannot('viewAll', RepairApplication::class),
                function ($query) {
                    return $query->where(
                        'repair_applications.user_id',
                        Auth::user()->id
                    );
                }
            )
            ->filter(new RepairApplicationFilter($params))
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
                    'equipment_name' => 'equipment.name',
                    'user_name' => 'users.name',
                    default => 'repair_applications.'.$sortColumn,
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
            ->fit(Manipulations::FIT_CROP, 300, 200);
    }
}
