<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TDocument extends Model
{
    use HasFactory;

    protected $table = 't_documents';
    protected $fillable = ['type_document', 'intitule_document', 'document'];
}
