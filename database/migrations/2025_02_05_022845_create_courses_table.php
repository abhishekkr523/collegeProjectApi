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
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key (Auto Increment)
            $table->string('name'); // Course name
            $table->text('description')->nullable(); // Course description
            $table->foreignUuid('category_id')->references('id')->on('course_categories')->onDelete('cascade');  // Course category
            $table->integer('duration'); // Duration in months
            $table->string('instructor'); // Instructor name
            $table->integer('credits')->default(3); // Course credits (default: 3)
            $table->decimal('fee', 10, 2)->nullable(); // Course fee
            $table->date('start_date'); // Start date
            $table->date('end_date')->nullable(); // End date (optional)
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
