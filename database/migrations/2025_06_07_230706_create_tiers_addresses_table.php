<?php

use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tiers_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('cp');
            $table->string('ville');
            $table->string('pays');
            $table->foreignIdFor(Tiers::class)->constrained('tiers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers_addresses');
    }
};
