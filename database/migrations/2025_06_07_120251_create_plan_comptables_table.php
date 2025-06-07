<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_comptables', function (Blueprint $table) {
            $table->id();
            $table->string('compte');
            $table->string('libelle');
            $table->string('groupe')->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();

            $table->foreign('parent_id')->references('id')->on('plan_comptables');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_comptables');
    }
};
