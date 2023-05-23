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
        Schema::create('variable_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('variable', 250);
            $table->text('templates_slug');
            $table->text('app_module_ids');
            $table->char('group', 250);
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
        Schema::dropIfExists('variable_templates');
    }
};
