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
     * Преобразуем дату создания документа.
     */
	public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i');
    }
	
	/**
     * Преобразуем исходящую дату документа.
     */
	public function getDateLetterAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y');
    }
	
	/**
     * Получить сканы файлов
     */
    public function files()
    {
		return $this->hasMany(IncomingDocumentFile::class);
    }
	
	/**
     * Получить распределенных пользователей
     */
    public function distributed()
    {
		return $this->hasMany(IncomingDocumentDistributed::class);
    }
	
	/**
     * Получить ответственных пользователей
     */
    public function responsibles()
    {
		return $this->hasMany(IncomingDocumentResponsible::class);
    }
	
	/**
     * Получить всех пользователей, чтобы знать кому надо подписать и т.д. (аккуратнее)
     */
    public function users()
    {
		return $this->hasMany(IncomingDocumentUser::class);
    }
	
	/**
     * Получим вид документа
     */
    public function documentType()
    {
        return $this->belongsTo(\App\Models\References\DocumentType::class)->withDefault([
			'name' => '',
		]);
    }
	
	/**
     * Получим статус документа
     */
    public function status()
    {
        return $this->belongsTo(\App\Models\References\IncomingDocStatus::class, 'incoming_doc_status_id')->withDefault([
			'name' => '',
		]);
    }
}
