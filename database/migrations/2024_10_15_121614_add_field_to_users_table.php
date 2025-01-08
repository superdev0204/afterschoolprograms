<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('program_id')->nullable()->after('login');
            $table->string('program_type', 100)->nullable()->after('program_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('program_id'); // Rollback the addition of the field
            $table->dropColumn('program_type');
        });
    }
};