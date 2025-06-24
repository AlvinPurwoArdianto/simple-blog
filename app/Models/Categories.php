<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    public function post()
    {
        return $this->hasMany(Categories::class, 'category_id');
    }
}
