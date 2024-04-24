<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const PAYMENT_METHODS = ['Google Pay', 'Pay Pal', 'Pri doručení'];
    const DELIVERY_METHODS = ['SPS', 'DHL'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'owner_id', 'status', 'total_price', 'payment_method', 'delivery_method', 'first_name', 'last_name', 'street_address', 'street_number', 'postal_code', 'city', 'phone_number', 'email',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
