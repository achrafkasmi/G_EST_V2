<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 't_sessions';

    protected $fillable = [
        'session_name',
        'session_type',
        'start_time',
        'end_time',
        'id_local',
        'id_personnel',
        'id_element_pedago',
    ];
}
