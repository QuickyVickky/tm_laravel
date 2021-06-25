<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid',
        'category_title',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $table = 'tags_category';



}
