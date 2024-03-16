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
}
