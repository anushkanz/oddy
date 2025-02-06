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

        Schema::create('sessions', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // Reference to the class_dates collection (if class_dates are also users)
            $collection->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $collection->string('ip_address', 45)->nullable();
            $collection->text('user_agent')->nullable();
            $collection->longText('payload');
            $collection->integer('last_activity')->index();
           
            // Timestamps
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
