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
        Schema::create('pdf_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('title', 200)->unique();
            $table->text('template');
            $table->foreignId('app_module_id')->constrained();
            $table->foreignId('pdf_header_id')->constrained();
            $table->foreignId('pdf_footer_id')->constrained();
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
        Schema::dropIfExists('pdf_templates');
    }
};
