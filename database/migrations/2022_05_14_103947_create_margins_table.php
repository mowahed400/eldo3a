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
        Schema::create('margins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->json('name');
            $table->integer('state')->nullable()->default(1);
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

        Schema::table('margins', function (Blueprint $table) {
            $table->dropForeign('margins_section_id_foreign');

        });
        Schema::dropIfExists('margins');
    }
};
