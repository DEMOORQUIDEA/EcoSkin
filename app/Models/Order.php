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
        "user_id",
        "total",
        "payment_method",
        "status",
        "subtotal",
        "tax",
        "shipping_cost",
        "shipping_name",
        "shipping_email",
        "shipping_phone",
        "shipping_address",
        "shipping_reference",
        "payment_status",
        "shipping_status"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
