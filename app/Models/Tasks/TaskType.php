<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'name',
        'color',
        'text_color',
	];
}
