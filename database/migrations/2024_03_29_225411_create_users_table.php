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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'avatar')) {
                    $table->string('avatar')->default('demo/default.png');
                }
                if (!Schema::hasColumn('users', 'username')) {
                    $table->string('username');
                }
                if (!Schema::hasColumn('users', 'trial_ends_at')) {
                    $table->dateTime('trial_ends_at')->nullable();
                }
                if (!Schema::hasColumn('users', 'verification_code')) {
                    $table->string('verification_code')->nullable();
                }
                if (!Schema::hasColumn('users', 'verified')) {
                    $table->tinyInteger('verified')->nullable();
                }
            });
        }

        if (Schema::hasTable('accounts')) {
            Schema::table('accounts', function (Blueprint $table) {
                if (! Schema::hasColumn('accounts', 'avatar')) {
                    $table->string('avatar')->default('demo/default.png');
                }
                if (! Schema::hasColumn('accounts', 'trial_ends_at')) {
                    $table->dateTime('trial_ends_at')->nullable();
                }
                if (! Schema::hasColumn('accounts', 'verification_code')) {
                    $table->string('verification_code')->nullable();
                }
                if (! Schema::hasColumn('accounts', 'verified')) {
                    $table->tinyInteger('verified')->nullable();
                }
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('accounts')) {
            Schema::table('accounts', function (Blueprint $table) {
                if (Schema::hasColumn('accounts', 'avatar')) {
                    $table->dropColumn('avatar');
                }
                if (Schema::hasColumn('accounts', 'trial_ends_at')) {
                    $table->dropColumn('trial_ends_at');
                }
                if (Schema::hasColumn('accounts', 'verification_code')) {
                    $table->dropColumn('verification_code');
                }
                if (Schema::hasColumn('accounts', 'verified')) {
                    $table->dropColumn('verified');
                }
            });
        }
    }
};
