<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'status_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'status_id', 'id');
    }
    public function categories()
    {
        return $this->hasMany(Category::class, 'status_id', 'id');
    }
    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'status_id', 'id');
    }
}
