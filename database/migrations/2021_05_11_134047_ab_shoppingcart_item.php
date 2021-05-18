<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AbShoppingcartItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ab_shoppingcart_item', function(Blueprint $table){
            $table->bigInteger('id')->primary()->comment('Primärschlüssel');
            $table->bigInteger('ab_shoppingcart_id')->nullable(false)->comment('Referenz auf den Warenkorb');
            $table->bigInteger('ab_article_id')->nullable(false)->comment('Referenz auf den Artike');
            $table->timestamp('ab_createdate')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Zeitpunkt der Erstellung');

            $table->foreign('ab_article_id')->references('id')->on('ab_article');
            $table->foreign('ab_shoppingcart_id')->references('id')->on('ab_shoppingcart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('ab_shoppingcart_item');
    }
}
