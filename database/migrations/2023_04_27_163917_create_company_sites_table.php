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
        Schema::create('company_sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name")->unique();
            $table->integer("number_of_floors");
            $table->text("address");
            $table->string("post_code");
            $table->string("phone_number");
            $table->string("email");
            $table->foreignId("country_id")->constrained();
            $table->foreignId("city_id")->constrained()->nullable();
            $table->foreignId("area_id")->constrained()->nullable();
            $table->enum("type",['stock','administration','production']);
            $table->boolean("basic_address")->default(false);
            $table->boolean("shipping_address")->default(false);
            $table->boolean("pos_address")->default(false);
            $table->boolean("active")->default(true);
            $table->foreignId("company_id")->constrained();
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
        Schema::dropIfExists('company_sites');
    }
};
