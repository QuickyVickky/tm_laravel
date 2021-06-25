<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_assigned', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('uuid',50);
            $table->integer('project_id')->default(0)->comment('project_id');
            $table->integer('admin_id')->default(0)->comment('employee id');
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_assigned');
    }
}
