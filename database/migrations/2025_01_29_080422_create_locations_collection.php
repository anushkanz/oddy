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
        // Create the 'locations' collection
        Schema::create('locations', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // Reference to the Users collection (if instructors are also users)
            $collection->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Location details
            $collection->string('name');
            $collection->comment('address');
            $collection->string('city');
            $collection->string('country');
            $collection->double('latitude');
            $collection->double('longitude');
    
            // Timestamps
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
