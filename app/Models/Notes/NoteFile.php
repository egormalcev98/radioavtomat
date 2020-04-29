<?php

namespace App\Models\Notes;

use App\Models\BaseModel;

class NoteFile extends BaseModel
{
    protected $fillable = [
		'name',
		'file_path',
	];

    public function note()
    {
        return $this->belongsTo(\App\Models\Notes\Note::class);
    }

}
