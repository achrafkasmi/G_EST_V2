<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Diplome extends Model
{
    protected $table='t_diplome';

    public function etudiants(){

        return $this->hasMany(Etudiant::class,'id_dip');
    }
    
    public function personnels()
    {
        return $this->belongsToMany(Personnel::class, 't_personnel_for_diplome', 't_diplome_id', 't_personnel_id');
    }

    
}
