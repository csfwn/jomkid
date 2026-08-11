<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('package_code')->default('basic')->index();
            $table->unsignedSmallInteger('child_profile_limit')->nullable()->default(3);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('package_code')->default('basic')->index();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['package_code']);
            $table->dropColumn('package_code');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['package_code']);
            $table->dropColumn(['package_code', 'child_profile_limit']);
        });
    }
};
