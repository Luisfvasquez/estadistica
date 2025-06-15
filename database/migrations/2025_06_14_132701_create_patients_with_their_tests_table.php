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
        Schema::create('patients_with_their_tests', function (Blueprint $table) {
            $table->id();
            $table->string('cedula');
            $table->string('name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('section1');
            $table->string('code');
            $table->string('idfacture');
            $table->string('sede');
            $table->date('date_start');
            $table->date('date_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients_with_their_tests');
    }
};
