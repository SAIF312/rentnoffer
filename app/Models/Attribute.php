<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id','id');
    }
    public function type()
    {
        return $this->belongsTo(AttributeType::class, 'attribute_type_id','id');
    }
}
