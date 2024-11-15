<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'operation',
        'model',
        'details',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper function to format arrays as strings
    private function formatArray($array)
    {
        return implode(', ', array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    $v = json_encode($v); // Encode nested arrays as JSON strings
                }
                return sprintf("%s='%s'", $k, $v);
            },
            $array,
            array_keys($array)
        ));
    }

    // Format log details into a readable sentence
    public function getFormattedDetailsAttribute()
    {
        $details = json_decode($this->details, true);
        $formattedDetails = "";

        if ($this->operation === 'create') {
            $formattedDetails = "created a new record with details: " . $this->formatArray($details);
        } elseif ($this->operation === 'update') {
            $formattedDetails = "updated the record with changes: " . $this->formatArray($details);
        } elseif ($this->operation === 'delete') {
            $formattedDetails = "deleted the record with id: " . $details['id'];
        } elseif ($this->operation === 'read') {
            if (isset($details['action'])) {
                $formattedDetails = "{$details['action']} for user: {$details['user_name']} ({$details['user_id']}) and student: {$details['etudiant_name']} ({$details['etudiant_id']})";
            } else {
                $formattedDetails = "read records with query: " . $this->formatArray($details['query']);
            }
        }

        return $formattedDetails;
    }
}
