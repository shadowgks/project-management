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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 250);
            $table->string('full_name', 250);
            $table->string('original_name', 250);
            $table->string('path', 250)->nullable();
            $table->double('file_size')->nullable();
            $table->string('extension', 20)->nullable();
            $table->string('type', 20)->nullable();
            $table->string('subject_type', 250)->nullable();
            $table->integer('subject_id')->nullable();
            $table->json('properties')->nullable();
            $table->boolean('visible')->default(true);
            $table->foreignId('app_module_id')->nullable()->constrained();
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
        Schema::dropIfExists('uploads');
    }
};
