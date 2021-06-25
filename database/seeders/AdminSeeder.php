<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin;
date_default_timezone_set('Asia/Kolkata');

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Admin::updateOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'password'    => bcrypt('admin@123'),
            'uuid'   => uuid(),
            'fullname'   => 'Admin',
            'mobile'   => NULL,
            'is_active' => constants('is_active.active'),
            'role' => constants('adminrole.A.key'),
            'active_session'   => NULL,
            'ipaddress'   => NULL,
            'about'   => 'Admin Description Here',
            'joining_date'   => date('Y-m-d'),
            'designation'   => 'SuperAdmin',
        ]);




    }




}
