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
        Schema::create('hospital_analytes', function (Blueprint $table) {
           $table->id();
            $table->string('group');
            $table->string('totexa1');
            $table->string('idcodigo');
            $table->string('descrip');
            $table->string('totexa');
            $table->string('sede');
            $table->string('convenio');
            $table->string('totexa2');
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
        Schema::dropIfExists('hospital_analytes');
    }
};
