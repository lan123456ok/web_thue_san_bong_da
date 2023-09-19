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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users','password')) {
                $table->string('password')->nullable()->change();
            }
            // if (Schema::hasColumn('users','pitch_id')) {
            //     $table->unsignedBigInteger('pitch_id')->nullable()->change;
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
