<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            
            // Job Details
            $table->string('title'); // Job Title
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained()->onDelete('cascade');
            $table->integer('vacancy'); // Vacancy
            $table->decimal('salary', 10, 2)->nullable(); // Salary (Optional, precision 10, scale 2)
            $table->string('location'); // Location
            $table->text('description'); // Job Description
            $table->text('benefits')->nullable(); // Benefits (Optional)
            $table->text('responsibility')->nullable(); // Responsibilities (Optional)
            $table->text('qualifications')->nullable(); // Qualifications (Optional)
            $table->string('keywords')->nullable();
            $table->string('experience'); // Experience

            // Company Details
            $table->string('company_name'); // Company Name
            $table->string('company_location')->nullable(); // Company Location (Optional)
            $table->string('company_website')->nullable(); // Company Website (Optional)

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
