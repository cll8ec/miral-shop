<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("products", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("salla_id")->unique();
            $table->string("slug")->unique();
            $table->string("name");
            $table->text("description")->nullable();
            $table->decimal("price", 10, 2)->default(0);
            $table->string("currency", 3)->default("SAR");
            $table->integer("stock")->default(0);
            $table->boolean("is_active")->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->index("is_active");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("products");
    }
};
