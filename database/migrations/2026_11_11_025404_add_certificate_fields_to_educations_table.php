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
        Schema::table('educations', function (Blueprint $table) {
            $table->string('certificate_image')->nullable()->after('description');
            $table->string('event_name')->nullable()->after('certificate_image');
            $table->longText('history')->nullable()->after('event_name');
            $table->string('credential_url')->nullable()->after('history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn(['certificate_image', 'event_name', 'history', 'credential_url']);
        });
    }
};
