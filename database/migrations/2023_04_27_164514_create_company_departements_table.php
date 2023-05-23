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
        Schema::create('company_departements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json("floors")->nullable();
            $table->foreignId("company_site_id")->constrained();
            $table->integer('reception_user_id');
            $table->integer('responsible_user_id')->nullable();
            $table->integer('departement_parent');
            $table->boolean("active")->default(true);
            $table->foreign('reception_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('responsible_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('departement_parent')->references('id')->on('company_departements')->nullable()->onDelete('cascade');
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
        Schema::dropIfExists('company_departements');
    }
};
