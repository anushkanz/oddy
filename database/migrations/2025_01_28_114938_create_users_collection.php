<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the 'users' collection
        Schema::create('users', function (Blueprint $collection) {
            // Unique ID (automatically created by MongoDB)
            $collection->index('_id');

            // User details
            $collection->string('name');
            $collection->string('email')->unique();
            $collection->string('password');
            $collection->string('phone')->nullable();
            $collection->integer('status');
            $collection->string('role')->default('customer'); // 'customer' or 'admin'
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
        Schema::drop('users');
    }
}