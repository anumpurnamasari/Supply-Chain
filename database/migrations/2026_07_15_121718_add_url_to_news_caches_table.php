<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (!Schema::hasColumn('news_caches', 'url')) {
        Schema::table('news_caches', function (Blueprint $table) {
            $table->text('url')->nullable()->after('source');
        });
    }
}
    public function down(): void
    {
        Schema::table('news_caches', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};
