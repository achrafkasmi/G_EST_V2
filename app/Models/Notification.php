<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table='t_notification';
    
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    
}
