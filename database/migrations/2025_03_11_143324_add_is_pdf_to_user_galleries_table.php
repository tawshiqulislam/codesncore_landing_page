<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_galleries', function (Blueprint $table) {
            $table->boolean('is_pdf')->default(false);
        });
    }

    public function down()
    {
        Schema::table('user_galleries', function (Blueprint $table) {
            $table->dropColumn('is_pdf');
        });
    }
};
