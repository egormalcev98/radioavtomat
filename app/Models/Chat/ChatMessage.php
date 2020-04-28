<?php

namespace App\Models\Chat;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ChatMessage extends BaseModel
{
    /**
     * "Загружающий" метод модели.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
		
		$authUser = auth()->user();
		
        static::addGlobalScope('relevant', function (Builder $builder) use($authUser) {
            $builder->where('chat_messages.created_at', '>=', Carbon::parse($authUser->created_at));
        });
    }

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
