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
        // Create the 'payments' collection
        Schema::create('payments', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // Reference to the Booking collection 
            $collection->foreignId('booking_id')->constrained('booking')->onDelete('cascade');

            // Payment details
            $collection->double('amount');
            $collection->string('payment_method');
            $collection->string('status');
            $collection->string('transaction_id');
            $collection->comment('transaction_return');

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
        // Drop the 'payments' collection
        Schema::drop('payments');
    }
};
