<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function slot_orders()
    {
        return $this->belongsToMany(Slot::class, 'slot_order', 'order_id', 'slot_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class,'payment_intent','payment_intent');
    }
}
