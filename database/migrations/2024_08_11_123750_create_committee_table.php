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
        Schema::create('committee', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained(table: "user", column: "id")->onUpdate("cascade")->onDelete("cascade");
            $table->boolean("ssc")->nullable(true);
            $table->foreignId("scope")->constrained(table: "colleges", column: "id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee');
    }
};
