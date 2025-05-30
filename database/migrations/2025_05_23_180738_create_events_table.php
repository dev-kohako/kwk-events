<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid_code')->unique();
        $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('address');
        $table->string('complement')->nullable();
        $table->string('zipcode');
        $table->string('number');
        $table->string('city');
        $table->string('state');
        $table->dateTime('starts_at');
        $table->dateTime('ends_at');
        $table->integer('max_subscription')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
