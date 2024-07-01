<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use Sortable;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'equipment_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];
}
