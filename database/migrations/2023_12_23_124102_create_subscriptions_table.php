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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('shift_id');
            $table->string('name');
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('referenced_contact')->nullable();
            $table->string('class')->nullable();
            $table->string('team')->nullable();
            $table->string('status')->nullable();
            $table->string('reference')->nullable();
            $table->float('fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
