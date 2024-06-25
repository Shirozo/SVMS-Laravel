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
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->char("title", 50)->unique();
            $table->enum("scope", [1, 2, 3]);
            $table->boolean("started")->default(false);
            $table->unsignedBigInteger("college_limit")->nullable();
            $table->unsignedBigInteger("course_limit")->nullable();
            $table->enum("year_level_limit", [1, 2, 3, 4])->nullable();
            $table->timestamps();

            //Foreign Key
            $table->foreign("college_limit")->references('id')->on('colleges')->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("course_limit")->references("id")->on("courses")->onUpdate("cascade")->onDelete("cascade");
        });

        Schema::create('election_data', function (Blueprint $table) {
            $table->id();
            $table->text("voter_name");
            $table->foreignId("voter_id")->constrained(table: "users", column: "id")->onUpdate("cascade")->onDelete('cascade');
            $table->foreignId("election_id")->constrained(table: "elections", column: "id")->onUpdate("cascade")->onDelete('cascade');
            $table->boolean("has_voted")->default("false");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elections');
    }
};
