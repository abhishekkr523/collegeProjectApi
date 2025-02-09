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
            $table->uuid('id')->primary(); 
            $table->string('name'); 
            $table->text('description')->nullable();
            $table->integer('duration'); 
            $table->string('instructor'); 
            $table->integer('credits')->default(3);
            $table->decimal('fee', 10, 2)->nullable(); 
            $table->date('start_date'); 
            $table->date('end_date')->nullable(); 
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_category_course');
        Schema::dropIfExists('courses');
    }
};
