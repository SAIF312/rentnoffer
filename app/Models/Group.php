<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function experience_attributes()
    {
        return $this->hasMany(ExperienceAttribute::class, 'group_id', 'id');
    }
}
