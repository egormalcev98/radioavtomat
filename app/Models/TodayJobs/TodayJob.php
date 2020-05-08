<?php

namespace App\Models\TodayJobs;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\User;

class TodayJob extends Model
{

    protected $fillable = [
        'user_id',
        'allowed_routes',
        'created_at',
    ];

    public function getCreatedAtAttribute($data)
    {
        if($data) {
            return Carbon::parse($data)->format('d.m.Y H:i');
        } else {
            return $data;
        }
    }

}
