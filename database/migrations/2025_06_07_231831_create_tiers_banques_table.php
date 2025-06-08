<?php

use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tiers_banques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('banque');
            $table->string('code_banque');
            $table->string('code_guichet');
            $table->string('num_compte');
            $table->string('cle');
            $table->string('iban');
            $table->string('bic');
            $table->foreignIdFor(Tiers::class)->constrained('tiers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers_banques');
    }
};
