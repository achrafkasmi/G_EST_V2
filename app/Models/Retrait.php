<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retrait extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 't_retrait';

    // Define the fillable properties
    protected $fillable = [
        'id_etu',
        'type_retrait',
        'motif_retrait',
        'dossier_retrait'
    ];


    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id');
    }
}
