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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->char("fullname", 150);
            $table->text("photo")->nullable(true);
            $table->text("bio");
            $table->bigInteger("votes")->default(0)->nullable(true);
            
            //Foreign Key
            $table->foreignId("user_id")->constrained(table: "users", column: "id")->onUpdate("cascade")->onDelete('cascade');
            $table->foreignId("position_id")->constrained(table: "positions", column: "id")->onUpdate("cascade")->onDelete('cascade');
            $table->foreignId("election_id")->constrained(table: "elections", column: "id")->onUpdate("cascade")->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
