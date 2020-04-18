<?php

namespace App\Models\Tasks;

use App\Models\BaseModel;
use App\Models\IncomingDocuments\IncomingDocument;
use App\Models\References\EventType;
use App\Models\References\TaskStatus;
use App\User;

class Task extends BaseModel
{
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
        return $this->belongsToMany(User::class);
    }

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class);
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
