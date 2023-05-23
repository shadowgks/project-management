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
        Schema::create('reminders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rel_id');
            $table->foreignId('app_module_id')->constrained();
            $table->text('description');
            $table->date('date');
            $table->boolean('is_notified')->default(0);
            $table->integer("user_to_notify");
            // $table->foreign("user_to_notify")->references("id")->on("users")->onDelete("cascade");
            $table->boolean('notify_by_mail')->default(0);
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
        Schema::dropIfExists('reminders');
    }
};
