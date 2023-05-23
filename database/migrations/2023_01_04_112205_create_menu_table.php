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
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->enum('category', ['simple', 'separator', 'sub_element', 'dropdown']);
            $table->char('icon', 250)->nullable();
            $table->char('name', 250);
            $table->char('path', 250)->nullable();
            $table->char('source', 250)->nullable();
            $table->integer('item_order');
            $table->foreignId('permission_id')->constrained()->nullable();
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
        Schema::dropIfExists('menu');
    }
};
