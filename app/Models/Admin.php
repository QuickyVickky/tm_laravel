<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid',
        'fullname',
        'email',
        'mobile',
        'is_active',
        'role',
        'about',
        'active_session',
        'joining_date',
        'designation',
        'ipaddress',
        'password',
        'created_at',
        'updated_at',
    ];

    protected $table = 'admins';

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'active_session',
        'is_active',
    ];


    public function project_assigned(){
        return $this->hasMany(ProjectAssigned::class, 'admin_id', 'id')->where('is_active', constants('is_active.active'));
    }


}
