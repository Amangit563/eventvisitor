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
        Schema::create('ticketscanns', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('ticket_id');
            $table->string('date');
            $table->string('time');
            $table->string('device_no');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('location');
            $table->string('designation');
            $table->string('company_name');
            $table->string('company_location');
            $table->string('event_name');
            $table->string('evnet_location');
            $table->string('col1');
            $table->string('col2');
            $table->string('col3');
            $table->string('col4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticketscanns');
    }
};
