<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banque_aggregates', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->string('banque_name')->nullable();
            $table->string('banque_logo_url')->nullable();
            $table->string('banque_id')->nullable();
            $table->timestamp('last_refreshed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banque_aggregates');
    }
};
