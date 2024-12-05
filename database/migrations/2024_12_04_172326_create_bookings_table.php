<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->date('check_in_date');
            $table->enum('status', ['confirmed', 'unconfirmed'])->default('unconfirmed');
            $table->foreignId('users_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
