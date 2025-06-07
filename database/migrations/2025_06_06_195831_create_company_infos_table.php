<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('director')->nullable();
            $table->string('capital')->nullable();
            $table->string('type')->nullable();
            $table->string('object')->nullable();
            $table->string('num_tva')->nullable();
            $table->string('num_siren')->nullable();
            $table->string('num_siret')->nullable();
            $table->string('num_naf')->nullable();
            $table->string('rcs')->nullable();
            $table->boolean('tva')->default(true);
            $table->string('bridge_client_id')->nullable();

            $table->foreignId('company_id')->constrained()
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
