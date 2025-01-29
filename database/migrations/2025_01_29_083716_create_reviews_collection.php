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
        // Create the 'reviews' collection
        Schema::create('reviews', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // Reference to the Users collection (if reviews are also users)
            $collection->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Reference to the Classes collection (if reviews are also users)
            $collection->foreignId('class_id')->constrained('classes')->onDelete('cascade');

            // Instructor details
            $collection->integer('rating');
            $collection->comment('comment');

            // Timestamps
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'reviews' collection
        Schema::drop('reviews');
    }
};
