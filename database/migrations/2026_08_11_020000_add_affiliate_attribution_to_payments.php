<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('affiliate_user_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();
        });

        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->unique('subscription_id');
        });
    }

    public function down(): void
    {
        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->dropUnique(['subscription_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('affiliate_user_id');
        });
    }
};
