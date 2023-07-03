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
        Schema::create('burgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("meat_id");
            $table->foreign("meat_id")->references("id")->on("burger_customizations");
            $table->foreignId("bread_id");
            $table->foreign("bread_id")->references("id")->on("burger_customizations");
            $table->json("sides")->nullable();
            $table->foreignId("order_id")->nullable();
            $table->foreign("order_id")->references("id")->on("orders");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burgers');
    }
};
