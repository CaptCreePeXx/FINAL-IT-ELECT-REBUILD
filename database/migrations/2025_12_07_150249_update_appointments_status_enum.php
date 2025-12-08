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
    \DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending','approved','completed','cancelled','declined','cancellation_requested') NOT NULL DEFAULT 'pending'");
}

public function down(): void
{
    \DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending','approved','completed','cancelled') NOT NULL DEFAULT 'pending'");
}

};
