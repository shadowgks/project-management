<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_informations', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->text("description")->nullable();
            $table->enum("type", ["private", "public"]);
            $table->datetime("start_date")->nullable();
            $table->datetime("finish_date")->nullable();
            $table->boolean("on_update")->default(false);
            $table->integer("on_update_user_id")->nullable();
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
        Schema::dropIfExists('general_informations');
    }
};
