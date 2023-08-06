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
        Schema::create('content_margins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('margin_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('content_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->json('name');
            $table->json('description')->nullable();
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
        Schema::table('content_margins', function (Blueprint $table) {
            $table->dropForeign('content_margins_margin_id_foreign');
            $table->dropForeign('content_margins_content_id_foreign');
        });
        Schema::dropIfExists('content_margins');
    }
};
