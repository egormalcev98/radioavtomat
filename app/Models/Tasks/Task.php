<?php

namespace App\Models\Tasks;

use App\Models\BaseModel;
use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\References\EventType;
use App\Models\References\TaskStatus;
use App\User;
use App\Events\Tasks\TaskNotifications;

class Task extends BaseModel
{
	/**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        // 'created' => TaskNotifications::class,
        // 'updated' => TaskNotifications::class,
        'deleted' => TaskNotifications::class,
    ];

    protected $fillable = [
        'text',
        'start',
		'end',
		'incoming_document_id',
		'file_path',
        'task_status_id',
		'event_type_id',
		'remember_time',
		'creator_id'
    ];


	public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('completed');
    }

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function taskType()
    {
        return $this->belongsTo(TaskType::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function incomingDocument()
    {
        return $this->belongsTo(IncomingDocument::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

}
