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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id");
            $table->foreign("order_id")->on("orders")->references("id");
            $table->boolean("refund")->nullable();
            $table->string("customer_message");
            $table->string("admin_message")->nullable();
            $table->foreignId("admin_id")->nullable();
            $table->foreign("admin_id")->on("users")->references("id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
