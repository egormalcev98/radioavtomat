<?php

namespace App\Models\OutgoingDocuments;

use App\Models\BaseModel;
use Carbon\Carbon;

class OutgoingDocument extends BaseModel
{

    public function getDateAttribute($data)
    {
        if($data) {
            return Carbon::parse($data)->format('d.m.Y');
        } else {
            return $data;
        }
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


}
