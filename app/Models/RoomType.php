<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use Sortable;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'room_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
}
