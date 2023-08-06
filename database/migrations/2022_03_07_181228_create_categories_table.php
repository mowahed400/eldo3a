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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description');
            $table->integer('state')->default(1); // 1: inactive 2: active
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->integer('type')->default(1);

            $table->foreignIdFor(\App\Models\Section::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('parent_id')->nullable()->references('id')
                ->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('categories');
    }
};
