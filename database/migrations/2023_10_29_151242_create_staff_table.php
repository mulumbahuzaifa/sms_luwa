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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->text('address');
            $table->string('role'); // Role or position (e.g., Teacher, Administrator)
            $table->string('employee_id')->unique(); // Unique identifier for the staff member
            $table->date('joining_date');
            $table->decimal('salary', 10, 2); // Example: 50000.00
            $table->text('qualifications')->nullable(); // Educational qualifications
            $table->unsignedBigInteger('department_id')->nullable(); // If using a foreign key for department
            $table->timestamps();

            // Foreign key constraint for department (if applicable)
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
};
