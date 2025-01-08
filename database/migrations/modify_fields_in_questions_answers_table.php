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
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('program_id')->nullable()->change();
            $table->string('program_type', 100)->nullable()->change();
            $table->integer('user_id')->nullable()->change();
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->integer('program_id')->nullable()->change();
            $table->string('program_type', 100)->nullable()->change();
            $table->integer('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('program_id')->nullable(false)->change(); // Revert to not nullable
            $table->string('program_type', 100)->nullable(false)->change();
            $table->integer('user_id')->nullable(false)->change(); // Revert to not nullable
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->integer('program_id')->nullable(false)->change(); // Revert to not nullable
            $table->string('program_type', 100)->nullable(false)->change();
            $table->integer('user_id')->nullable(false)->change(); // Revert to not nullable
        });
    }
};
