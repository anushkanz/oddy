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
        // Create the 'classes' collection
        Schema::create('classes', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // Reference to the Users collection (if classes are also users)
            $collection->foreignId('instructor_id')->constrained('users')->onDelete('cascade');

            // Instructor details
            $collection->string('title');
            $collection->comment('description');

            // Reference to the Category collection (if classes are also category)
            $collection->foreignId('category_id')->constrained('category')->onDelete('cascade');

            // Reference to the Location collection (if classes are also location)
            $collection->foreignId('location_id')->constrained('location')->onDelete('cascade');

            $collection->integer('duration');
            $collection->integer('price');
            $collection->integer('max_capacity');
            $collection->timestamp('start_date');
            $collection->timestamp('end_date');
            $collection->string('level');

            $collection->array('photo_gallery'); // Array of gallery (e.g., ["url", "caption"])

            // Timestamps
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
