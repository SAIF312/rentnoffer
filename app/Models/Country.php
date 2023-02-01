<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function users()
    {
        return $this->hasMany(User::class, 'country_id', 'id');
    }
    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }
}
