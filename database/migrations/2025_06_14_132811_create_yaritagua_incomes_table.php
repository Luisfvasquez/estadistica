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
       Schema::create('yaritagua_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->decimal('cost', 10, 2);
            $table->string('idcode');
            $table->string('descrip');
            $table->decimal('cost1', 10, 2);
            $table->string('sede');
            $table->string('convenio');
            $table->decimal('cost2', 10, 2);
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
        Schema::dropIfExists('yaritagua_incomes');
    }
};
