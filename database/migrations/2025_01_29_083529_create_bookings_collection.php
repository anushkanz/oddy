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
        // Create the 'bookings' collection
        Schema::create('bookings', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

           // Reference to the Users collection (if classes are also users)
           $collection->foreignId('user_id')->constrained('users')->onDelete('cascade');

           // Reference to the Classes collection (if Classes are also users)
           $collection->foreignId('class_id')->constrained('classes')->onDelete('cascade');

           // Reference to the Payment collection (if payment are also users)
           $collection->foreignId('payment_id')->constrained('payment')->onDelete('cascade');

            // Booking details
            $collection->string('status');
            $collection->foreignId('class_date_id')->constrained('class_dates')->onDelete('cascade');
            $collection->integer('seat_count');
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
        // Drop the 'bookings' collection
        Schema::drop('bookings');
    }
};
