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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name')->default('');
            $table->longText('description');
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('account_id')->nullable()->constrained();
            $table->foreignId('party_id')->nullable()->constrained('accounts');
            $table->decimal('amount', 10, 2);
            $table->datetime('next_due_date')->nullable();
            $table->integer('cycle')->default(1);
            $table->integer('payments_remaining')->nullable();
            $table->decimal('balance_remaining', 10, 2)->nullable();
            $table->boolean('income')->default(false);
            $table->boolean('autopay')->default(false);
            $table->boolean('estimated_amount')->default(true);
            $table->boolean('estimated_date')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
