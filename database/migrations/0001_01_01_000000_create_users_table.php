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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('first_name', 30)->nullable();
            $table->char('middle_name', 30)->nullable();
            $table->char('last_name', 30)->nullable();
            $table->char("username", 30)->unique()->nullable();
            $table->char("student_id", 8)->unique()->nullable();
            $table->enum('user_type', [1, 2, 3])->default(3);
            $table->foreignId("course_id")->nullable()->constrained(table: "courses", column: "id")->onUpdate("cascade")->onDelete('cascade');
            $table->enum("year", [1, 2, 3, 4])->nullable();
            $table->enum("status", [0, 1])->default(1);
            $table->string('email')->unique()->nullable(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean("ssc")->nullable(true);
            $table->foreignId("scope")->nullable()->constrained(table: "colleges", column: "id");
            $table->text('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
