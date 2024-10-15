<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baccalaureate extends Model
{
    use HasFactory;
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 't_baccalaureates';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'pdf_path',
        'id_etu',
        'CNE',
        'status',
        'last_request_at',
        'timestamps',
        // Add other fields here if necessary
    ];

}
