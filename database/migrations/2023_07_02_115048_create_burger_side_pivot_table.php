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
        Schema::create('burger_side_pivot', function (Blueprint $table) {
            $table->foreignId("burger_id");
            $table->foreign("burger_id")->references("id")->on("burgers")->cascadeOnDelete();
            $table->foreignId("side_id");
            $table->foreign("side_id")->references("id")->on("sides");
            $table->primary(["burger_id", "side_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burger_side_pivot');
    }
};
