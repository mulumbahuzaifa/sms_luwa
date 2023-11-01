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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Example: "English", "Mathematics"
            $table->string('code')->unique(); // Unique code for the subject (e.g., ENG for English)
            $table->string('level'); // Academic level (e.g., "O-Level", "A-Level")
            $table->text('description')->nullable(); // Description of the subject (optional)
            $table->boolean('compulsory')->default(false); // Whether the subject is compulsory or not
            $table->unsignedBigInteger('department_id')->nullable(); // If using a foreign key for department
            $table->unsignedBigInteger('class_id')->nullable(); // If using a foreign key for department
            $table->timestamps();

            // Foreign key constraint for department (if applicable)
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('class_id')->references('id')->on('sm_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};
