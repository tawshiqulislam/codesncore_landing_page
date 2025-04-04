<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_galleries', function (Blueprint $table) {
            $table->string('s_name')->nullable()->after('alt_text');
            $table->string('p_name')->nullable()->after('s_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_galleries', function (Blueprint $table) {
            $table->dropColumn(['s_name', 'p_name']);
        });
    }
};