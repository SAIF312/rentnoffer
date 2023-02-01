<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Time()
    {
        return $this->belongsTo(Time::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }


    public function slot_orders()
    {
        return $this->belongsToMany(Order::class, 'slot_order', 'slot_id', 'order_id');
    }
}
