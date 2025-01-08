<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('page_url', 250)->nullable()->after('program_type');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->string('page_url', 250)->nullable()->after('program_type');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('page_url');
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('page_url');
        });
    }
};