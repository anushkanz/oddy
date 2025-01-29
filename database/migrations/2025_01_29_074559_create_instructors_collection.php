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
        // Create the 'instructors' collection
        Schema::create('instructors', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // Reference to the Users collection (if instructors are also users)
            $collection->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Instructor details
            $collection->string('name');
            $collection->string('bio')->nullable();
            $collection->array('skills')->nullable(); // Array of skills (e.g., ["yoga", "painting"])
            $collection->string('profile_picture')->nullable(); // URL to profile picture

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
        // Drop the 'instructors' collection
        Schema::drop('instructors');
    }
};
