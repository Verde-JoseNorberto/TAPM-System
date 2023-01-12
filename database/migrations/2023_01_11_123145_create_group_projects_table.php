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
        Schema::create('group_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_title');
            $table->string('project_category');
            $table->string('project_phase');
            $table->string('year_term');
            $table->string('section');
            $table->date('due_date');
            $table->string('team');
            $table->string('advisor');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_projects');
    }
};
