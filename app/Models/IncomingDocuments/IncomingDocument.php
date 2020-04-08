<?php

namespace App\Models\IncomingDocuments;

use App\Models\BaseModel;
use Carbon\Carbon;

class IncomingDocument extends BaseModel
{
	/**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
		'date_letter_at',
		'date_delivery_at',
		'created_at',
		'updated_at',
		'deleted_at',
	];
	
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'title',
		'urgent',
		'counterparty',
		'number',
		'date_letter_at',
		'from',
		'date_delivery_at',
		'original_received',
		'register',
		'number_pages',
		'recipient_id',
		'note',
		'incoming_doc_status_id',
		'document_type_id',
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
	
	/**
     * Получить сканы файлов
     */
    public function files()
    {
		return $this->hasMany(IncomingDocumentFile::class);
    }
	
}
