<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableMigration extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('description')->default('')->nullable(false)->change();
        });
        
        Schema::table('entries', function (Blueprint $table) {
            $table->string('description')->default('')->nullable(false)->change();
        });

    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('description')->nullable()->default(null)->change();
        });

        Schema::table('entries', function (Blueprint $table) {
            $table->string('description')->nullable()->default(null)->change();
        });

    }
}
