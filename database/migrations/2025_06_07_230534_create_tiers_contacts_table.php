<?php

use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tiers_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('titre');
            $table->string('poste')->nullable();
            $table->string('phone')->nullable();
            $table->string('portable')->nullable();
            $table->string('email')->nullable();
            $table->foreignIdFor(Tiers::class)->constrained('tiers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers_contacts');
    }
};
