<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapeDiplome extends Model
{
    
    //protected $table = 't_etudiant_etape';
    protected $table = 't_etape_diplome';


    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 't_etudiant_etape', 'id_etu', 'id_etape');
    }
    
}
