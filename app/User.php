<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;

    /**
     * "Загружающий" метод модели.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('users.user_status_id', 1);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'middle_name',
        'personal_phone_number',
        'work_phone_number',
        'additional',
        'birthday_at',
        'user_status_id',
        'structural_unit_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'surnameWithInitials',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Преобразуем пароль перед записью.
     */
    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    /**
     * Преобразуем дату рождения перед записью.
     */
    public function setBirthdayAtAttribute($birthdayAt)
    {
        $this->attributes['birthday_at'] = Carbon::parse($birthdayAt);
    }

    /**
     * Преобразуем время создания для вывода.
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    /**
     * Преобразуем дату рождения для вывода.
     */
    public function getBirthdayAtAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    /**
     * Получим админа
     */
    public function scopeAdmin($query)
    {
        return $query->whereRoleIs('admin')->first();
    }

    /**
     * Получим всех, кроме админа
     */
    public function scopeWithoutAdmin($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->withoutAdmin();
        });
    }

    /**
     * Склеим ФИО и добавим в коллекцию элемента.
     */
    public function getFullNameAttribute()
    {
        return $this->surname . ' ' . $this->name . ' ' . $this->middle_name;
    }

    /**
     * Берем фамилию и инициалы.
     */

    public function getSurnameWithInitialsAttribute()
    {
        $result = $this->surname;

        if ($this->name and $this->name != '') {
            $result .= ' ' . Str::limit($this->name, 1, '.');
            if ($this->middle_name and $this->middle_name != '') {
                $result .= ' ' . Str::limit($this->middle_name, 1, '.');
            }
        }

        return $result;
    }

    /**
     * Получим структурное подразделение для конкретного пользователя
     */
    public function structuralUnit()
    {
        return $this->belongsTo(Models\References\StructuralUnit::class)->withDefault([
            'name' => '',
        ]);
    }

    /**
     * Получим статус конкретного пользователя
     */
    public function status()
    {
        return $this->belongsTo(Models\References\UserStatus::class, 'user_status_id')->withDefault([
            'name' => '',
        ]);
    }

    public function scopeWithRoles($query, $name) {
        return $query->whereHas('roles', function ($q) use($name) {
            return $q->where('name', $name);
        });
    }
	
	/**
     * Получить отправленные пользователем сообщения
     */
    public function sentChatMessages()
    {
		return $this->hasMany(Models\Chat\ChatMessage::class, 'sender_user_id');
    }
	
}
