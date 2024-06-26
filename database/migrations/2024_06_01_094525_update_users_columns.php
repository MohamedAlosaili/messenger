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
        schema::table("users", function (Blueprint $table) {
            $table->timestamp('created_at')->useCurrent()->change();
            $table->boolean('is_deleted')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table("users", function (Blueprint $table) {
            $table->dropColumn('is_deleted');
            $table->dropColumn('deleted_at');
        });
    }
};
