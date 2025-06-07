<?php

use App\Models\Core\BanqueAggregate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banque_aggregate_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_id');
            $table->string('name');
            $table->string('balance');
            $table->string('instante');
            $table->string('account_type');
            $table->string('account_iban')->nullable();
            $table->foreignIdFor(BanqueAggregate::class)->constrained('banque_aggregates');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banque_aggregate_accounts');
    }
};
