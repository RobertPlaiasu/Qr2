<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->string('picture')->nullable();
            $table->timestamp('expire')->nullable();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_promo', function (Blueprint $table) {
           $table->primary(['product_id','promo_id']);
           $table->foreignId('product_id')->onDelete('cascade');
           $table->foreignId('promo_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
}
