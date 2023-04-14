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
        Schema::create('henning_algorithm_data', function (Blueprint $table) {
            $table->id();

            $table->integer('question_sequence');
            $table->foreignId('session_id')
                ->references('id')
                ->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('difficulty_high_high');
            $table->integer('difficulty_high_low');
            $table->integer('difficulty_low_high');
            $table->integer('difficulty_low_low');
            $table->integer('current_difficulty');
            $table->integer('next_difficulty');
            $table->integer('sum_difficulty');
            $table->integer('length');
            $table->integer('num_right');
            $table->float('width');
            $table->float('proportion');
            $table->float('A');
            $table->float('B');
            $table->float('C');
            $table->float('ability');
            $table->float('error');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('henning_algorithm_data');
    }
};
