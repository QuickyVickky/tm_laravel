<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('uuid',50);
            $table->string('project_name',150);
            $table->text('project_description')->nullable()->default(NULL)->comment('optional');
            $table->integer('admin_id')->default(0)->comment('ecreated_by');
            $table->tinyInteger('is_deployed')->default(0)->comment('0-no, 1-yes');
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->date('start_date')->nullable()->default(NULL);
            $table->date('end_date')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
