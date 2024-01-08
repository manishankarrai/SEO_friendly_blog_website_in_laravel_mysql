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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->integer('uid');
            $table->integer('category');
            $table->integer('subcategory');
            $table->string('topic');
            $table->string('topic_seo');
            $table->string('topic_thumbnail')->nullable();
            $table->string('topic_banner')->nullable();
            $table->string('topic_priority');
            $table->enum('status' , ['active' , 'inactive' , 'pending' , 'block' , 'deleted'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
