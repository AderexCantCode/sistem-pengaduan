<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['upvote', 'downvote']);
            $table->timestamps();

            $table->unique(['pengaduan_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
};
