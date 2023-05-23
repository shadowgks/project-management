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
        Schema::create('validation_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->foreignId("status_id")->constrained();
            $table->integer('step_order');
            // $table->foreignId('validation_id')->constrained();
            $table->integer('validation_id');
            $table->foreignId("user_id")->constrained();
            $table->foreignId("permission_id")->constrained();
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
        Schema::dropIfExists('validation_steps');
    }
};
