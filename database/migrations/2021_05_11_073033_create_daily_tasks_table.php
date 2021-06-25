<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->date('dailytask_date')->comment('Required');
            $table->text('task_description')->comment('Required');
            $table->integer('admin_id')->default(0)->comment('employee id');
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->mediumInteger('dailytask_minutes')->default(0);
            $table->mediumInteger('overtime_minutes')->default(0);
            $table->integer('project_id')->default(0)->comment('project_id');
            $table->integer('project_category_id')->default(0)->comment('project_category_id');
            $table->string('any_notes',255)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_tasks');
    }
}
