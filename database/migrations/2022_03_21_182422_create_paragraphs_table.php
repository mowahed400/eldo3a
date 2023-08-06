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
        Schema::create('paragraphs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->json('text')->nullable();
            $table->json('start_from')->nullable();
            $table->json('end_at')->nullable();
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
        Schema::table('paragraphs', static function (Blueprint $table) {
            $table->dropForeign('paragraphs_content_id_foreign');

        });
        Schema::dropIfExists('paragraphs');
    }
};
