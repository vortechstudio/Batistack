<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('condition_reglements', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('libelle');
            $table->string('libelle_document');
            $table->integer('nb_jours');
            $table->boolean('fin_de_mois');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condition_reglements');
    }
};
