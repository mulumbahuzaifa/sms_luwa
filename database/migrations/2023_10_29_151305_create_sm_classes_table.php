<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Example: "Senior One", "Senior Two"
            $table->enum('level', ['O-Level', 'A-Level']); // O-Level or A-Level
            $table->string('class_code')->unique(); // Unique code for the class (e.g., S1)
            $table->string('year'); // Academic year or session (e.g., "2023-2024")
            $table->unsignedBigInteger('class_teacher_id')->nullable(); // If using a foreign key for class teacher
            $table->timestamps();

            // Foreign key constraint for class teacher (if applicable)
            $table->foreign('class_teacher_id')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_classes');
    }
};
