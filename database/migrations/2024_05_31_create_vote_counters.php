<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengaduans', function (Blueprint $table) {
    if (!Schema::hasColumn('pengaduans', 'upvotes')) {
        $table->integer('upvotes')->default(0);
    }
    if (!Schema::hasColumn('pengaduans', 'downvotes')) {
        $table->integer('downvotes')->default(0);
    }
});

    }

    public function down()
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['upvotes', 'downvotes']);
        });
    }
};
