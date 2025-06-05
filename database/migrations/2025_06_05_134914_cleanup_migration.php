<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupMigration extends Migration
{
    public function up(): void
    {
        // Drop sensitive fields from accounts
        Schema::table('accounts', function (Blueprint $table) {
            if (Schema::hasColumn('accounts', 'account_number')) {
                $table->dropColumn('account_number');
            }
            if (Schema::hasColumn('accounts', 'routing_number')) {
                $table->dropColumn('routing_number');
            }
            if (Schema::hasColumn('accounts', 'site_username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('accounts', 'site_password')) {
                $table->dropColumn('password');
            }
        });

        // Drop unused tables
        Schema::dropIfExists('hours');
        Schema::dropIfExists('miles');
    }

    public function down(): void
    {
        // Re-add sensitive fields to accounts
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('account_number')->nullable()->after('description');
            $table->string('routing_number')->nullable()->after('account_number');
            $table->string('username')->nullable()->after('website');
            $table->string('password')->nullable()->after('username');
        });

        // Recreate unused tables
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->decimal('hours', 5, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('miles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->decimal('miles', 6, 2)->default(0.00);
            $table->timestamps();
        });
    }
}
