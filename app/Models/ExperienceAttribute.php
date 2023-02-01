<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceAttribute extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function type()
    {
        return $this->belongsTo(AttributeType::class);
    }
}
