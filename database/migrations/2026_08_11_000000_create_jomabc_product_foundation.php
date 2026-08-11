<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('parent')->index();
            $table->string('affiliate_code')->nullable()->unique();
            $table->boolean('affiliate_active')->default(false);
        });

        Schema::create('child_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('display_name', 40);
            $table->unsignedSmallInteger('birth_year')->nullable();
            $table->string('avatar_key')->default('owl-indigo');
            $table->unsignedInteger('xp')->default(0);
            $table->unsignedSmallInteger('current_level')->default(1);
            $table->unsignedSmallInteger('streak_days')->default(0);
            $table->boolean('leaderboard_opt_in')->default(false);
            $table->timestamps();
        });

        Schema::create('learning_modules', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_module_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('difficulty')->default(1);
            $table->unsignedTinyInteger('duration_minutes')->default(7);
            $table->unsignedSmallInteger('xp_reward')->default(20);
            $table->boolean('is_published')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['learning_module_id', 'slug']);
        });

        Schema::create('lesson_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('score')->default(0);
            $table->unsignedSmallInteger('max_score')->default(0);
            $table->decimal('accuracy', 5, 2)->default(0);
            $table->string('status')->default('started');
            $table->json('meta')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan_code')->default('jomabc-annual');
            $table->string('status')->default('pending');
            $table->unsignedInteger('price_sen')->default(6900);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('buyer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('amount_sen')->default(3450);
            $table->string('status')->default('pending');
            $table->timestamp('available_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_commissions');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('lesson_attempts');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('learning_modules');
        Schema::dropIfExists('child_profiles');

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['affiliate_code']);
            $table->dropColumn(['role', 'affiliate_code', 'affiliate_active']);
        });
    }
};
