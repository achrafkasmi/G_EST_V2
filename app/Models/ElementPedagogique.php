<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ElementPedagogique extends Model
{
    use HasFactory;

    protected $table = 't_modules_etape';

    protected $fillable = [
        'code_etape',
        'id_etape',
        'type_etape_element',
        'intitule_element',
        'nbr_heures_cours',
        'nbr_heures_td',
        'nbr_heures_tp',
        'nbr_heures_ap',
        'nbr_heures_evaluation',
        'decription_module',
        'coefficient',
    ];

   
    public function etapeDiplome() {
        return $this->belongsTo(EtapeDiplome::class, 'id_etape');
    }
}
