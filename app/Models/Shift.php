<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'date',
        'start',//nullable
        'end',//nullable
        'subscription_required',
        'subscription_max',//nullable
        'subscription_fee',//nullable
        'subscription_start',//nullable
        'subscription_end',//nullable
        'subscription_param',//nullable
        'location' //nullable
    ];

    public function event(): BelongsTo{
        return $this->belongsTo(Event::class);
    }

    public function subscriptions(): HasMany{
        return $this->hasMany(Subscription::class);
    }
}
