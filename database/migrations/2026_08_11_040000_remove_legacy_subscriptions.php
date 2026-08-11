<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->dropUnique(['subscription_id']);
            $table->dropConstrainedForeignId('subscription_id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subscription_id');
        });

        Schema::dropIfExists('subscriptions');
    }

    public function down(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan_code');
            $table->string('status')->default('pending');
            $table->unsignedInteger('price_sen')->default(6900);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->foreignId('subscription_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unique('subscription_id');
        });
    }
};
