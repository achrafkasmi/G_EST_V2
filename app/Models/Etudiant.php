<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Etudiant extends Model
{
    protected $table='t_etudiant';

    public function user() : HasOne
    {
        return $this->hasOne(User::class,'user_id');
    }

   public function stage() : HasOne
   {
     return $this->hasOne(Stage::class,'id_etu');
   }
}