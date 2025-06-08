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
            $table->string('libelle')->nullable();
            $table->string('banque')->nullable();
            $table->string('code_banque')->nullable();
            $table->string('code_guichet')->nullable();
            $table->string('num_compte')->nullable();
            $table->string('cle')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->foreignIdFor(Tiers::class)->constrained('tiers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers_banques');
    }
};
