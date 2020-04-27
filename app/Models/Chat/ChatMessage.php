<?php

namespace App\Models\Chat;

use App\Models\BaseModel;
use Carbon\Carbon;

class ChatMessage extends BaseModel
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'text',
		'to_user_id',
		'structural_unit_id',
	];
	
	/**
     * Получим отправителя сообщения
     */
    public function senderUser()
    {
        return $this->belongsTo(\App\User::class)->withDefault([
			'full_name' => '',
			'surname' => '',
			'name' => '',
		]);
    }
	
	/**
     * Получим группу структурные подразделения сообщения
     */
    public function structuralUnit()
    {
        return $this->belongsTo(\App\Models\References\StructuralUnit::class)->withDefault([
			'name' => '',
		]);
    }
	
	/**
     * Преобразуем дату создания.
     */
	public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i');
    }
	
	/**
     * Получим отметки о прочитанных сообщениях
     */
    public function viewed()
    {
        return $this->belongsToMany(\App\User::class, 'chat_message_user')->withTimestamps();
    }
}
