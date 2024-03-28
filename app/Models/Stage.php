<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stage extends Model
{
    protected $table = 't_dossier_stage';

    public function etudiant() : BelongsTo {
        
        return $this->belongsTo(Etudiant::class, "id_etu");
    }

    protected $fillable = [
        'id_etu',
        'type_dossier',
        'dossier_stage',
        'annee_universitaire',
        'rapport',
        'validation_prof',
        'observation_prof',
        'validation_admin',
        'observation_admin',
        'is_recommended',
    ];
}
