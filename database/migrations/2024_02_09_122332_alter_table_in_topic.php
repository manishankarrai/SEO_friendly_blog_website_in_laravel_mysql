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
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('subcategory');
            $table->dropColumn('topic_thumbnail');
            $table->dropColumn('topic_banner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->integer('category');
            $table->integer('subcategory');
            $table->string('topic_thumbnail')->nullable();
            $table->string('topic_banner')->nullable();
        });
    }
};
