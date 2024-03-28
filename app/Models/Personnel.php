<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $table = 't_personnel';

    public function user(){
    
        return $this->belongsTo(User::class,'user_id');

    }

    public function diplomes(){
    
        return $this->hasMany(Diplome::class,'id_personnel');

    }




}
