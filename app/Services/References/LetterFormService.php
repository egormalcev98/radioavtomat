<?php

namespace App\Services\References;

use App\Models\References\LetterForm;
use DataTables;

class LetterFormService extends ReferenceService
{	
	public $routeName = 'letter_forms';
	
	public $translation = 'references.letter_forms.';
	
	public function __construct()
    {
        parent::__construct(LetterForm::query());
    }
}