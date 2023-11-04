<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'remember_token')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('remember_token')->nullable()->after('pitch_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'remember_token')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('remember_token');
            });
        }
    }
};
