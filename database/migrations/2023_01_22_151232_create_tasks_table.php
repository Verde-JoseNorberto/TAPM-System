<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('group_project_id')->unsigned();
            $table->integer('assign_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('content');
            $table->date('start_date');
            $table->date('due_date');
            $table->string('status');
            $table->string('priority');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('group_project_id')
                ->references('id')
                ->on('group_projects')
                ->onDelete('cascade');

            $table->foreign('assign_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};