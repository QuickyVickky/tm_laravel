<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'dailytask_date',
        'task_description',
        'admin_id',
        'is_active',
        'created_at',
        'updated_at',
        'dailytask_minutes',
        'overtime_minutes',
        'project_id',
        'project_category_id',
        'any_notes',
    ];

    protected $table = 'daily_tasks';


    public function admin(){
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }

    public function project(){
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function project_category(){
        return $this->hasOne(ProjectCategory::class, 'id', 'project_category_id');
    }

    

}
