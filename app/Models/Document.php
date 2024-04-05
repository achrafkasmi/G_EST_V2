<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Document extends Model
{
    use HasFactory,HasRoles;
    protected $table = 't_documents'; // Specify the table name

    protected $fillable = [
        'id_etu',
        'id_perso',
        'intitule_document',
        'type_document',
        'document'
    ];
}
