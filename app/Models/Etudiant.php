<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Etudiant extends Model
{
    protected $table='t_etudiant';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifications(): HasMany
{
    return $this->hasMany(Notification::class, 'id_etu');
}
   public function stage() : HasOne
   {
     return $this->hasOne(Stage::class,'id_etu');
   }

   public function diplome() : BelongsTo
   {
     return $this->belongsTo(Diplome::class,'id_dip');
   }
}
