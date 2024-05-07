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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('pic')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('local')->nullable();
            $table->date('dat');
            $table->string('d');
            $table->string('m');
            $table->string('y');
            $table->string('timeout');
            $table->string('otherout')->nullable();
            $table->string('created')->nullable()->comment('กรณี admin เพิ่มข้อมูลเข้าระบบ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
