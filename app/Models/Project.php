<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid',
        'project_name',
        'admin_id',
        'is_active',
        'is_deployed',
        'created_at',
        'updated_at',
        'project_description',
        'start_date',
        'end_date',
    ];

    protected $table = 'projects';

    public function admin(){
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }

    public function project_assigned(){
        return $this->hasMany(ProjectAssigned::class, 'project_id', 'id');
    }



}
