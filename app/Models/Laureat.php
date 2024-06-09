<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laureat extends Model
{
    use HasFactory;

    protected $table = 't_laureat';

    protected $fillable = [
        'diplome',
        'id_etu',
        'path_dossier_lautreat',
        'annee_uni',
    ];

    public function diplome()
    {
        return $this->belongsTo(Diplome::class, 'diplome');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etu');
    }
}
