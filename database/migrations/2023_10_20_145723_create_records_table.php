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
        Schema::create('records', function (Blueprint $table) {
            $table->id()->comment('เก็บประวัติการแก้ไขเวลาเข้า-ออก');
            $table->integer('ref_id')->nullable()->comment('อ้างอิง id ลา');
            $table->integer('type')->comment('1=เข้างาน,2=ออกงาน,3=เพิ่ม');
            $table->string('created_by')->comment('ยื่นโดย');
            $table->string('uid');
            $table->string('pic')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('local')->nullable();
            $table->date('dat');
            $table->string('d');
            $table->string('m');
            $table->string('y');
            $table->string('timeold')->nullable();
            $table->string('timenew');
            $table->string('other')->nullable();
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
