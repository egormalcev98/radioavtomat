<?php

namespace App\Models\OutgoingDocuments;

use App\Models\BaseModel;
use Carbon\Carbon;

class OutgoingDocument extends BaseModel
{

    protected $fillable = [
        'number',
        'date',
        'counterparty',
        'document_type_id',
        'from_user_id',
        'note',
        'outgoing_doc_status_id',
        'letter_form_id',
        'title',
        'number_pages',
        'incoming_letter_number',
    ];

    public function getDateAttribute($data)
    {
        if($data) {
            return Carbon::parse($data)->format('d.m.Y');
        } else {
            return $data;
        }
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::parse($date);
    }

    public function documentType()
    {
        return $this->belongsTo(\App\Models\References\DocumentType::class)->withDefault(['name' => '',]);
    }

    public function outgoingDocStatus()
    {
        return $this->belongsTo(\App\Models\References\OutgoingDocStatus::class)->withDefault(['name' => '',]);
    }

    public function fromUser()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Получить сканы файлов
     */
    public function files()
    {
        return $this->hasMany(OutgoingDocumentFile::class);
    }
}
