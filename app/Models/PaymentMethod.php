<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class,'payment_method_id','payment_method');
    }
}
