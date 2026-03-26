<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Zen Japonés');
            $table->string('site_tagline')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->string('whatsapp_number', 50)->nullable();
            $table->string('reservation_url')->nullable();
            $table->string('billing_url')->nullable();
            $table->longText('privacy_content')->nullable();
            $table->longText('jobs_content')->nullable();
            $table->unsignedInteger('menu_version')->default(1);
            $table->timestamp('last_published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('site_settings');
    }

};
