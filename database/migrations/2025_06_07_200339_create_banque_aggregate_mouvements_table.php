<?php

use App\Models\Core\BanqueAggregateAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banque_aggregate_mouvements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id');
            $table->string('title');
            $table->string('description');
            $table->float('amount');
            $table->string('date');
            $table->string('booking_date')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('value_date')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('operation_type')->nullable();
            $table->boolean('future')->default(false);
            $table->foreignIdFor(BanqueAggregateAccount::class)->constrained('banque_aggregate_accounts');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banque_aggregate_mouvements');
    }
};
