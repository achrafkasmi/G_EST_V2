<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelElementPedagoguique extends Model
{
    use HasFactory;

    protected $table = 't_personnel_element_pedago';

    protected $fillable = [
        'personnel_id',
        'id_element_pedago',
    ];
}
