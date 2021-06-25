<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid',
        'project_id',
        'category_title',
        'category_description',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $table = 'project_category';


    public function project(){
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

}
