<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->default('settings');
            $table->date('creacio_tallers_data_inicial')->nullable();
            $table->date('creacio_tallers_data_final')->nullable();
            $table->date('eleccio_tallers_data_inicial')->nullable();
            $table->date('eleccio_tallers_data_final')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert(
            array(
                'nom' => 'settings'
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
