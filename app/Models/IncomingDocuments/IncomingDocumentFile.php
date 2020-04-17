<?php

namespace App\Models\IncomingDocuments;

use App\Models\Activity\Activity;

class IncomingDocumentFile extends Activity
{
    protected static $logName = __CLASS__;

    protected static $forcedOldAttributes = ['outgoing_document_id'];

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'file_path',
	];
	
    public function incomingDocument()
    {
        return $this->belongsTo(IncomingDocument::class);
    }
}
