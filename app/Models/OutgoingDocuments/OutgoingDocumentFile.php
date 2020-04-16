<?php

namespace App\Models\OutgoingDocuments;

use App\Models\Activity\Activity;

class OutgoingDocumentFile extends Activity
{
    protected static $logName = __CLASS__;

    protected static $forcedOldAttributes = ['outgoing_document_id'];

    protected $fillable = [
		'name',
		'file_path',
	];

    public function outgoingDocument()
    {
        return $this->belongsTo(\App\Models\OutgoingDocuments\OutgoingDocument::class);
    }

}
