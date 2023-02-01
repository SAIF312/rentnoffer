<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'type_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(Product::class, 'type_id', 'id')->where('type_id',1);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'type', 'id');
    }
}
