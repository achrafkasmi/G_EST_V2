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
        'created_at',
        'updated_at',
        'id_personnel', 
        'periode_seance',
        'annee_uni',
        'type_seance',
    ];

    public function elementPedago() {
        return $this->belongsTo(ElementPedagogique::class, 'id_element_pedago');
    }

    public function personnel() {
        return $this->belongsTo(Personnel::class, 'id_personnel');
    }
}
