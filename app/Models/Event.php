<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'date_start',
        'date_end',//nullable
        'date_online',
        'date_offline',//nullable
        
    ];
    
    public function shifts(): HasMany{
        return $this->hasMany(Shift::class);
    }
}
