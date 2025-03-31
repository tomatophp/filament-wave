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
        if (! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('avatar')->default('demo/default.png');
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('remember_token', 100)->nullable();
                $table->timestamps();
                $table->string('username')->unique();
                $table->dateTime('trial_ends_at')->nullable();
                $table->string('verification_code')->nullable();
                $table->tinyInteger('verified')->nullable();
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'avatar')) {
                    $table->string('avatar')->default('demo/default.png');
                }
                if (! Schema::hasColumn('users', 'username')) {
                    $table->string('username')->unique();
                }
                if (! Schema::hasColumn('users', 'trial_ends_at')) {
                    $table->dateTime('trial_ends_at')->nullable();
                }
                if (! Schema::hasColumn('users', 'verification_code')) {
                    $table->string('verification_code')->nullable();
                }
                if (! Schema::hasColumn('users', 'verified')) {
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
        Schema::dropIfExists('users');
    }
};
