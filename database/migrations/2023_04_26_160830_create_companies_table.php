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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->bigInteger('activity');
            $table->double('capital');
            $table->string("vat")->unique();
            $table->integer("common_identifier")->unique();
            $table->integer("commercial_register")->unique();
            $table->integer("social_security")->unique();
            $table->foreignId("company_parent")->references('id')->on('companies');
            $table->boolean("active")->default(true);
            $table->foreign('activity')->references('id')->on('drop_downs')->onDelete('cascade');
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
        Schema::dropIfExists('companies');
    }
};
