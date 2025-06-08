<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('postal_code');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
