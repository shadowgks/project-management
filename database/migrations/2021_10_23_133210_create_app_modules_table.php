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
        Schema::create('app_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 250);
            $table->char('pseudo_name', 250);
            $table->text('description')->nullable();
            $table->boolean('empty_when_reinitializating');
            $table->boolean('emailing');
            $table->boolean('notifications');
            $table->boolean('pdf');
            $table->boolean('contain_validator');
            $table->boolean('activate_importation');
            $table->boolean('activate_file_upload');
            $table->boolean('activate_comments');
            $table->boolean('activate_reminders');
            $table->boolean('activate_duplicate');
            $table->text('namespace');
            $table->foreignId('gate_id')->constrained();
            $table->foreignId('app_id')->constrained();
            $table->boolean('active');
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
        Schema::dropIfExists('app_modules');
    }
};
