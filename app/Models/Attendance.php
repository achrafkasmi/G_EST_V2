<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 't_attendance';

    protected $fillable = [
        'id_etu',
        'id_local',
        'id_personnel',
        'id_element_pedago',
        'Annee',
        'FILIERE',
        'type_seance',
        'période_seance',
        'annee_uni',
        'is_absent',
        'created_at',
        'updated_at'
    ];

    // Define relationships if any
    public function student()
    {
        return $this->belongsTo(Etudiant::class, 'id_etu');
    }

    public function local()
    {
        return $this->belongsTo(Local::class, 'id_local');
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'id_personnel');
    }

    public function elementPedago()
    {
        return $this->belongsTo(ElementPedagogique::class, 'id_element_pedago');
    }
}
