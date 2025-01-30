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
        // Create the 'class_dates' collection
        Schema::create('class_dates', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // Reference to the class_dates collection (if class_dates are also users)
            $collection->foreignId('class_id')->constrained('classes')->onDelete('cascade');

            $collection->timestamp('class_date');
            $collection->time('start_at');
            $collection->time('end_at');
           
            // Timestamps
            $collection->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_dates');
    }
};
