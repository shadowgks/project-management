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
        Schema::create('numbering_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('app_module_id')->constrained();
            $table->boolean('use_barcode');
            $table->boolean('use_numbering');
            $table->foreignId("user_id")->constrained();
            $table->timestamps();

        });

        // numbering_settings
        // numbering_assignment
        // barcode_assignment
        // numbering_tracking
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('numbering_settings');
    }
};
