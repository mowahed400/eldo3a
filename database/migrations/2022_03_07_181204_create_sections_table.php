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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('description',1000)->nullable();
            $table->string('image',1000)->nullable();
            $table->integer('sorting_index')->default(0);
            $table->tinyInteger('state')->default(1); // 1: inactive 2: active
            $table->string('color')->nullable();
            $table->longText('settings')->nullable();
            $table->integer('type')->default(1);
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
        Schema::dropIfExists('sections');
    }
};
