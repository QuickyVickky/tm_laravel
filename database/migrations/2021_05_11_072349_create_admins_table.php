<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('uuid',50);
            $table->string('fullname',100);
            $table->string('email',111)->comment('email');
            $table->string('mobile',15)->nullable()->default(NULL);
            $table->string('password',255)->nullable()->default(NULL);
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->string('role',3)->default('E')->comment('A-SuperAdmin, E- Employee');
            $table->string('active_session',255)->nullable()->default(NULL);
            $table->string('ipaddress',255)->nullable()->default(NULL);
            $table->text('about')->nullable()->default(NULL);
            $table->date('joining_date')->nullable()->default(NULL);
            $table->string('designation',255)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
