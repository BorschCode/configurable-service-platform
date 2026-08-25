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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('logo_url')->nullable();
            $table->char('currency', 3)->default('USD');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('telegram')->nullable();
            $table->string('address')->nullable();
            $table->string('services_cta_label')->default('View Services');
            $table->string('portfolio_cta_label')->default('View Projects');
            $table->string('contact_cta_label')->default('Request a Quote');
            $table->boolean('is_published')->default(false)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
