<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class,'payment_intent','payment_intent')->with('product');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'customer','stripe_id');
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id','payment_method');
    }
}
