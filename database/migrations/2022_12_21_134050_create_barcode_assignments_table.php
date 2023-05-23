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
        Schema::create('barcode_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('random')->default;
            $table->char('barcode_type', 150);
            $table->boolean('use_today_date')->default(0);
            $table->char('date_field', 250);
            $table->integer('number_length');
            $table->json('elements');
            $table->json('numbering_per_periode');
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
        Schema::dropIfExists('barcode_assignments');
    }
};
