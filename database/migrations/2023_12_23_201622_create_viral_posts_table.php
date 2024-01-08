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
        Schema::create('viral_posts', function (Blueprint $table) {
            $table->id();
            $table->integer('uid');
            $table->integer('category');
            $table->integer('subcategory');
            $table->integer('topic');
            $table->string('title');
            $table->string('title_seo');
            $table->string('link');
            $table->string('sort_description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('post_banner')->nullable();
            $table->integer('view')->default(0);
            $table->enum('status' , ['active' , 'inactive' , 'pending' , 'block' , 'deleted'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viral_posts');
    }
};
