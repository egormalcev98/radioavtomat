<?php

namespace App\Models\IncomingDocuments;

use App\Models\BaseModel;
use Carbon\Carbon;

class IncomingDocument extends BaseModel
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'name',
	];
	
	/**
     * Преобразуем дату исходящего письма.
     */
	public function getDateLetterServerAtAttribute()
    {
        return Carbon::parse($this->date_letter_at)->format('Y-m-d');
    }
	
	/**
     * Преобразуем дату доставки документа.
     */
	public function getDateDeliveryServerAtAttribute()
    {
        return Carbon::parse($this->date_delivery_at)->format('Y-m-d');
    }
	
}
