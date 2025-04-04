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
        Schema::create('user_products_quote', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('image');
            $table->text('other_images')->nullable();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->longText('content');
            $table->integer('serial_number')->default(0);
            $table->integer('featured');
            $table->integer('detail_page');
            $table->unsignedBigInteger('lang_id');
            $table->unsignedBigInteger('user_id');
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->string('icon', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_products_quote');
    }
};
