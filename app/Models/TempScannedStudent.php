<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempScannedStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_etu',
        'id_local',
        'id_personnel',
        'id_element_pedago',
        'annee_uni',
        'période_seance',
    ];
}
