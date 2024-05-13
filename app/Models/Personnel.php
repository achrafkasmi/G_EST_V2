<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Personnel extends Model
{
    protected $table = 't_personnel';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*public function diplomes()
    {
        return $this->belongsToMany(Diplome::class, 't_personnel_for_diplome', 't_personnel_id', 't_diplome_id');
    }*/

    public function diplomes()
    {

        return $this->hasMany(Diplome::class, 'id_personnel');
    }
}
