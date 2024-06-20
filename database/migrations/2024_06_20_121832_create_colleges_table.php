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
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->char("college_name", length:100)->nullable(false)->unique();
            $table->timestamps();
        });


        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->char("course_name", length:100)->nullable(false)->unique();
            $table->unsignedBigInteger("college_id");
            $table->timestamps();

            //Foreign Key
            $table->foreign("college_id")->references("id")->on("colleges")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   Schema::dropIfExists("courses");
        Schema::dropIfExists('colleges');
    }
};
