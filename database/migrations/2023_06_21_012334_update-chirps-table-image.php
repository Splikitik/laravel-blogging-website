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
        Schema::table('chirps', function(Blueprint $table) {
            $table->string('description')->after('message')->nullable();
            $table->string('image')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(Blueprint $table): void
    {
        $table->dropColumn('description', 'image');
    }
};
