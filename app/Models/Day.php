<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function slots()
    {
        return $this->hasMany(Slot::class, 'day_id', 'id');
    }
}
