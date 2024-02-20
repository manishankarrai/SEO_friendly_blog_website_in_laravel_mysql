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
        Schema::create('socials', function (Blueprint $table) {
            $table->id();

            $table->integer('uid');

            $table->integer('topic');
            $table->string('title' , 700);
            $table->text('title_seo');
            $table->text('long_description');

            $table->integer('view')->default(0);
            $table->enum('status' , ['active' , 'inactive' , 'pending' , 'block' , 'deleted'])->default('active');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socials');
    }
};
