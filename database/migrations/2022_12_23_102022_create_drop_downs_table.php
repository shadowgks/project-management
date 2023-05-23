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
        Schema::create('drop_downs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('select_table', 200)->nullable();
            $table->char('select_field', 200);
            $table->char('select_id', 200);
            $table->text('select_value');
            $table->foreignId('app_module_id')->constrained();
            // $table->json('app_module_id');
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
        Schema::dropIfExists('drop_downs');
    }
};
