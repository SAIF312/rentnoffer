<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function favourite_by()
    {
        return $this->belongsToMany(User::class, 'favourites', 'product_id', 'user_id');
    }

    public function wished_by()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'product_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class, 'product_id', 'id')->with('day','time');
    }

    public function experience_attributes()
    {
        return $this->hasMany(ExperienceAttribute::class, 'product_id', 'id');
    }


    public function images()
    {
        return $this->hasMany(Media::class, 'product_id', 'id')->where('type', 'img');
    }
    public function video()
    {
        return $this->hasOne(Media::class, 'product_id', 'id')->where('type', 'video');
    }
    public function address()
    {
        return $this->hasOne(Address::class, 'product_id', 'id');
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
