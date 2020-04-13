<?php

namespace App\Models\IncomingDocuments;

use Illuminate\Database\Eloquent\Builder;

class IncomingDocumentResponsible extends IncomingDocumentUser
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 2);
        });
    }
}
