<?php

namespace App\Models\Activity;

use App\Models\BaseModel;
use App\Models\OutgoingDocuments\OutgoingDocument;
use App\Models\OutgoingDocuments\OutgoingDocumentFile;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityLog extends BaseModel
{

    protected $table = 'activity_log';

    protected $dates = ['created_at'];

    public function getCreatedAtAttribute($data)
    {
        if($data) {
            return Carbon::parse($data)->format('d.m.Y H:i');
        } else {
            return $data;
        }
    }

    public function getDescriptionSpanAttribute()
    {
        switch ($this->description) {
            case 'created':
                return 'Создан';
                break;
            case 'updated':
                return 'Изменен';
                break;
            case 'deleted':
                return 'Удален';
                break;
            default:
                echo "неопределено";
        }
    }

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public function outgoingDocument()
    {
        return $this->belongsTo(OutgoingDocument::class,  'subject_id')
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    public function outgoingDocumentFile()
    {
        return $this->belongsTo(OutgoingDocumentFile::class,  'subject_id' )
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

}

