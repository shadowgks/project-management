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
        Schema::create('validation_recordings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('app_module_id')->constrained();
            $table->integer('rel_id');
            $table->string('comment')->nullable();
            //id validation_steps
            $table->integer('validation_step_id');
            // $table->foreignId('validation_id')->constrained();
            // $table->foreign('validation_id')->references('id')->on('validations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('validation_recordings');
    }
};
