<?php

use App\Http\Helper\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("customer_id");
            $table->foreign("customer_id")->references("id")->on("users");
            $table->foreignId("chef_id")->nullable();
            $table->foreign("chef_id")->references("id")->on("users");
            $table->string("status")->default(OrderStatus::REQUIRED_PAYMENT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
