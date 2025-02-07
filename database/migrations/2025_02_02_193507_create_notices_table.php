<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable(); // New field for category
            $table->string('author')->nullable(); // New field for author
            $table->date('notice_date')->nullable(); // New field for date
            $table->string('file')->nullable(); // For PDF file
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notices');
    }
};
