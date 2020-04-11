<?php

namespace App\Models\Activity;

use App\Models\BaseModel;

class ActivityLog extends BaseModel
{

    protected $table = 'activity_log';

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

}

