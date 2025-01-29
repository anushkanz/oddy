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
        // Create the 'categories' collection
        Schema::create('categories', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');
            // Location details
            $collection->string('name');
            $collection->comment('description');
            $collection->string('slug');
    
            // Timestamps
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
