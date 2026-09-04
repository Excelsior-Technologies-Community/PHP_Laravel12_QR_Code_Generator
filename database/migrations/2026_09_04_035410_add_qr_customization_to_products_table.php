<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('qr_foreground_color')
                ->default('#000000')
                ->after('qr_code');

            $table->string('qr_background_color')
                ->default('#ffffff')
                ->after('qr_foreground_color');

            $table->unsignedInteger('qr_size')
                ->default(300)
                ->after('qr_background_color');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'qr_foreground_color',
                'qr_background_color',
                'qr_size',
            ]);
        });
    }
};