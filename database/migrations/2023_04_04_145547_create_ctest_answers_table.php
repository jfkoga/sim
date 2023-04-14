<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ctest_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idQuestion')
                ->references('id')
                ->on('ctests')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('session_id')
                ->references('id')
                ->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('position');
            $table->longText('answers')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ctest_answers');
    }
};
