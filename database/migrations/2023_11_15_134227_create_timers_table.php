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
        Schema::create('timers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('checkin')->nullable();
            $table->timestamp('checkout')->nullable();
            $table->string('timein')->nullable();
            $table->string('timeout')->nullable();
            $table->string('created_by')->nullable()->comment('คนแก้ไขล่าสุด');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timers');
    }
};
