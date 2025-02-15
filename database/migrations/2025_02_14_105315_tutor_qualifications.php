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
        Schema::create('instructor_qualifications', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // User details
            $collection->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $collection->string('title');
            $collection->comment('description');
            $collection->array('photo_gallery');
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
        // Drop the 'users' collection
        Schema::drop('instructor_qualifications');
    }
};