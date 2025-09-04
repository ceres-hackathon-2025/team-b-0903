<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained();
            $table->foreignId('tag_id')->constrained();
            $table->timestamps();

            $table->unique(['post_id', 'tag_id']); // 同じタグの重複を防ぐ
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
