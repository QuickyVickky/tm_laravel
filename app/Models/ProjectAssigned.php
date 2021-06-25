<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssigned extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid',
        'project_id',
        'admin_id',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $table = 'project_assigned';


    public function admin(){
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }

    public function project(){
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

}
