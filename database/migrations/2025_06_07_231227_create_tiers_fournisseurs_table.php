<?php

use App\Models\Core\PlanComptable;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tiers_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('code_comptable_fournisseur')->nullable();
            $table->string('condition_rglt')->nullable();
            $table->string('mode_rglt')->nullable();
            $table->string('rem_relative')->nullable();
            $table->string('rem_fixe')->nullable();
            $table->foreignIdFor(Tiers::class)->constrained('tiers');
            $table->foreignIdFor(PlanComptable::class, 'code_comptabilite_gen')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers_fournisseurs');
    }
};
