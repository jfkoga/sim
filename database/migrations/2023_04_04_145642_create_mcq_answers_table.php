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
        Schema::create('mcq_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('idQuestion')
                ->references('id')
                ->on('mcqs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('idSession')
                ->references('id')
                ->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->char('answer', 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcq_answers');
    }
};
