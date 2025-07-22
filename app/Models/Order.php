<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'address',
        'payment_intent_id',
        'paid_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Vérifier si la commande est payée
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid' && $this->paid_at !== null;
    }

    /**
     * Vérifier si la commande peut être payée
     */
    public function canBePaid(): bool
    {
        return in_array($this->status, ['pending', 'payment_failed']);
    }
}
