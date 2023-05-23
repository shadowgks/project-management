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
        Schema::create('numbering_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number');
            $table->integer('day');
            $table->integer('week');
            $table->integer('month');
            $table->integer('year');
            $table->foreignId('numbering_setting_id')->constrained();
            $table->foreignId("user_id")->constrained();
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
        Schema::dropIfExists('numbering_trackings');
    }
};
