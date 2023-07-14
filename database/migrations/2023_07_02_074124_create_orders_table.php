<?php

use App\Helper\OrderStatus;
use App\Repository\OrderRepository;
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
            $table->timestamp("chef_assigned_at")->nullable();
            $table->string("status")->default(OrderRepository::REQUIRED_PAYMENT);
            $table->timestamp("completed_at")->nullable();
            $table->float("total_price")->nullable();
            $table->string("payment_intent_id")->nullable();
            $table->string("city")->nullable();
            $table->string("street")->nullable();
            $table->string("house_number")->nullable();
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
