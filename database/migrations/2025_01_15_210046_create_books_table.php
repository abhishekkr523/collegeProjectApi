<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title'); // title of the book
            $table->string('author'); // author of the book
            $table->string('publisher')->nullable(); // publisher of the book
            $table->integer('publication_year'); // publication year of the book
            $table->string('isbn')->unique(); // ISBN of the book (unique)
            $table->integer('number_of_pages')->nullable(); // number of pages in the book
            $table->enum('status', ['available', 'borrowed', 'reserved'])->default('available'); // current status of the book
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations by dropping the 'books' table.
     */

    public function down()
    {
        Schema::dropIfExists('books');
    }
}
