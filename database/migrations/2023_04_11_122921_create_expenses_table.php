<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('category_id');
            $table->integer('account_id');
            $table->integer('payee_id');
            $table->decimal('amount');
            $table->datetime('next_due_date')->nullable();
            $table->integer('cycle')->default(1);
            $table->integer('payments_remaining')->nullable();
            $table->boolean('autopay')->default(false);
            $table->boolean('estimated_amount')->default(true);
            $table->boolean('estimated_date')->default(true);
            $table->boolean('fixed')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
