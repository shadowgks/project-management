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
        Schema::create('tasks', function (Blueprint $table) {
$table->bigIncrements("id");
$table->string("title");
$table->text("description")->nullable();
$table->datetime("start_date")->nullable();
$table->datetime("end_date")->nullable();
$table->foreignId("priority_id")->constrained("drop_downs")
;
$table->boolean("on_update")->default(false);$table->integer("on_update_user_id")->nullable();$table->foreignId("user_id")->constrained();
$table->foreignId("status_id")->constrained();

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
        Schema::dropIfExists('tasks');
    }
};
