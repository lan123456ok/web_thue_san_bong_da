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
        Schema::table('campaigns', static function (Blueprint $table) {
            if (Schema::hasColumn('campaigns', 'date')){
                $table->date('date')->nullable()->change();
            }
            if (Schema::hasColumn('campaigns', 'start_time')){
                $table->time('start_time')->nullable()->change();
            }
            if (Schema::hasColumn('campaigns', 'end_time')){
                $table->time('end_time')->nullable()->change();
            }
            if (Schema::hasColumn('campaigns', 'isNight')){
                $table->boolean('isNight')->nullable()->change();
            }
            if (Schema::hasColumn('campaigns', 'total_price')){
                $table->string('total_price')->nullable()->change();
            }
        });

        Schema::table('pitches', static function (Blueprint $table) {
            if (Schema::hasColumn('pitches', 'address')) {
                $table->string('address')->nullable()->change();
            }
            if (Schema::hasColumn('pitches', 'address2')) {
                $table->string('address2')->nullable()->change();
            }
            if (Schema::hasColumn('pitches', 'district')) {
                $table->string('district')->nullable()->change();
            }
            if (Schema::hasColumn('pitches', 'zipcode')) {
                $table->string('zipcode')->nullable()->change();
            }
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
