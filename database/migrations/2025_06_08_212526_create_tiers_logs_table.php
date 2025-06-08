<?php

use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tiers_logs', function (Blueprint $table) {
            $table->id();
            $table->text('libelle');
            $table->foreignIdFor(User::class)->constrained('users');
            $table->foreignIdFor(Tiers::class)->constrained('tiers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers_logs');
    }
};
