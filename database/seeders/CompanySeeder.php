<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Company;
date_default_timezone_set('Asia/Kolkata');

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Company::updateOrCreate([
            'id' => constants('company_configurations_id'),
        ], [
            'id' => constants('company_configurations_id'),
            'company_name'    => "Company Name",
            'email'   => "youremail@company.mail",
            'country'   => 'India',
            'mobile'   => NULL,
            'invoice_logo'   => 'logo.png',
        ]);




    }




}
