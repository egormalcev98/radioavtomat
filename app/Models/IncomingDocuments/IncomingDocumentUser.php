<?php

namespace App\Models\IncomingDocuments;

use App\Models\BaseModel;

class IncomingDocumentUser extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'incoming_document_users';
	
	/**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
		'sign_up',
		'signed_at',
		'reject_at',
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
		'type',
		'sign_up',
		'signed_at',
		'reject_at',
		'comment',
		'employee_task_id',
		'user_id',
	];
	
	public function getSomeSignUpAttribute()
	{
		return $this->sign_up->format('d.m.Y H:i');
	}
	
	public function getDateSignUpAttribute()
	{
		return $this->sign_up->format('Y-m-d');
	}
	
	public function getTimeSignUpAttribute()
	{
		return $this->sign_up->format('H:i');
	}
	
	
	public function getSomeSignedAtAttribute()
	{
		return $this->signed_at->format('d.m.Y H:i');
	}
	
	public function getDateSignedAtAttribute()
	{
		return $this->signed_at->format('Y-m-d');
	}
	
	public function getTimeSignedAtAttribute()
	{
		return $this->signed_at->format('H:i');
	}
	
	
	public function getSomeRejectAtAttribute()
	{
		return $this->reject_at->format('d.m.Y H:i');
	}
	
	public function getDateRejectAtAttribute()
	{
		return $this->reject_at->format('Y-m-d');
	}
	
	public function getTimeRejectAtAttribute()
	{
		return $this->reject_at->format('H:i');
	}
	/**
     * Получим конкретного пользователя
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class)->withDefault([
			'name' => '',
		]);
    }
	
	/**
     * Получим задачу
     */
    public function employeeTask()
    {
        return $this->belongsTo(\App\Models\References\EmployeeTask::class)->withDefault([
			'name' => '',
		]);
    }
	
	/**
     * Получить записи ответственных или распределенных для подписей
     */
	public function scopeAuthElements($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}
