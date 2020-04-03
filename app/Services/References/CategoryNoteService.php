<?php

namespace App\Services\References;

use App\Models\References\CategoryNote;
use DataTables;

class CategoryNoteService extends ReferenceService
{	
	public $routeName = 'category_notes';
	
	public $translation = 'references.category_notes.';
	
	public function __construct()
    {
        parent::__construct(CategoryNote::query());
    }
}