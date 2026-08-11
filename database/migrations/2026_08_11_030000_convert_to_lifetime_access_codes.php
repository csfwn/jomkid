<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('access_status')->default('none')->index();
            $table->timestamp('lifetime_access_at')->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('customer_name', 128)->after('uuid');
            $table->string('customer_email')->after('customer_name')->index();
        });

        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->foreignId('buyer_user_id')->nullable()->change();
            $table->foreignId('subscription_id')->nullable()->change();
            $table->foreignId('payment_id')
                ->nullable()
                ->after('subscription_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unique('payment_id');
        });

        Schema::create('access_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('used_by_user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('email')->index();
            $table->char('code_hash', 64)->unique();
            $table->string('code_hint', 4);
            $table->string('status')->default('active')->index();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_codes');

        Schema::table('affiliate_commissions', function (Blueprint $table) {
            $table->dropUnique(['payment_id']);
            $table->dropConstrainedForeignId('payment_id');
            $table->foreignId('buyer_user_id')->nullable(false)->change();
            $table->foreignId('subscription_id')->nullable(false)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_email']);
            $table->foreignId('user_id')->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['access_status']);
            $table->dropColumn(['access_status', 'lifetime_access_at']);
        });
    }
};
