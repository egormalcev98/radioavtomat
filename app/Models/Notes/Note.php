<?php

namespace App\Models\Notes;
use App\Models\BaseModel;
use App\Models\References\CategoryNote;
use App\Models\References\StatusNote;
use App\User;
use Carbon\Carbon;
use App\Events\Notes\NoteNotifications;

class Note extends BaseModel
{
	/**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NoteNotifications::class,
        'deleted' => NoteNotifications::class,
    ];
	
    protected $fillable = [
        'number',
        'title',
        'category_note_id',
        'status_note_id',
        'pages',
        'user_id',
        'creator_id',
        'text',
        'created_at'
    ];

    public function getCreatedAtAttribute($data)
    {
        if($data) {
            return Carbon::parse($data)->format('d.m.Y H:i');
        } else {
            return $data;
        }
    }


    /**
     * Получить пользователя кому направлено
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить создателя
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить категорию
     */
    public function categoryNote()
    {
        return $this->belongsTo(CategoryNote::class);
    }

    /**
     * Получить статус
     */
    public function statusNote()
    {
        return $this->belongsTo(StatusNote::class);
    }

    /**
     * Получить сканы файлов
     */
    public function files()
    {
        return $this->hasMany(NoteFile::class);
    }
}
