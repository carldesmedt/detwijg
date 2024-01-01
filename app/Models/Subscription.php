<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'name',
        'email',
        'address',
        'phone',
        'referenced_contact',
        'class',
        'team',
        'status',
        'reference',
        'fee'
    ];

    public function shift():BelongsTo{
        return $this->belongsTo(Shift::class);
    }
        
    
}
