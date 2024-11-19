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
        Schema::create('master_comments', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable();
            $table->string('type_work')->nullable();
            $table->string('name_client')->nullable();
            $table->string('phone_client')->nullable();
            $table->text('experience')->nullable();
            $table->text('recommendations')->nullable();
            $table->unsignedInteger('emotion_rating')->nullable();
            $table->unsignedInteger('payment_rating')->nullable();
            $table->unsignedInteger('quality_rating')->nullable();
            $table->unsignedInteger('delivery_rating')->nullable();
            $table->unsignedInteger('honesty_rating')->nullable();
            $table->unsignedInteger('user_id')->unsigned();
            $table->unsignedInteger('post_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_comments');
    }
};
