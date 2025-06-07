<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('cp')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('portable')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
