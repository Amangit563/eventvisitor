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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->integer('phone')->unique();;
            $table->integer('parent_id')->default(1);
            $table->string('company_name');
            $table->string('company_location');
            $table->string('event_name');
            $table->string('event_location');
            $table->string('role');
            $table->integer('status')->default(1);
            $table->string('designation');
            $table->string('col1')->nullable(); // Used nullable instead of default(NULL)
            $table->string('col2')->nullable();
            $table->string('col3')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
