<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Etudiant extends Model
{
    protected $table = 't_etudiant';

    protected $fillable = [
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'id_etu');
    }
    public function stage(): HasOne
    {
        return $this->hasOne(Stage::class, 'id_etu');
    }

    public function diplome(): BelongsTo
    {
        return $this->belongsTo(Diplome::class, 'id_etape');
    }
    public function etapes()
    {
        return $this->belongsToMany(Etudiant::class, 't_etudiant_etape', 'id_etu', 'id_etape');
    }
    public function stages()
    {
        return $this->hasMany(Stage::class, 'id_etu');
    }
    public function retraits()
    {
        return $this->hasMany(Retrait::class, 'id_etu');
    }
}
