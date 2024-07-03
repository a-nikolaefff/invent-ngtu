<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairApplicationStatus extends Model
{
    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'repair_application_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
}
