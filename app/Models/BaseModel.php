<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;
	
	/**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	
	/**
     * Получим список элементов отсортированных по умолчанию.
     */
    public function scopeOrderedGet($query)
	{
		return $query->orderBy('id', 'asc')->get();
	}
}
