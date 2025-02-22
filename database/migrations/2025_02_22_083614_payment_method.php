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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Payment method name (English)
            $table->string('name_ar')->nullable(); // Payment method name (Arabic)
            $table->string('public_key')->nullable(); // Public Key
            $table->string('secret_key')->nullable(); // Secret Key
            $table->boolean('status')->default(true); // Active/Inactive status
            $table->unsignedBigInteger('created_by')->nullable(); // User who created it
            $table->string('slug')->unique(); // Unique slug
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
