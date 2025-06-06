<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('entry_id')->constrained();
            $table->longText('note');
            $table->boolean('income')->default(false);
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('account_id')->nullable()->constrained();
            $table->foreignId('party_id')->nullable()->constrained('accounts');
            $table->decimal('amount', 10, 2);
            $table->datetime('paid_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
