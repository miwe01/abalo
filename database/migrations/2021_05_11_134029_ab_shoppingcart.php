<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AbShoppingcart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ab_shoppingcart', function(Blueprint $table){
            $table->bigInteger('id')->primary()->comment('Primärschlüssel');
            $table->bigInteger('ab_creator_id')->nullable(false)->comment('Referenz auf den Benutzer, dem der Warenkorb gehört');
            $table->timestamp('ab_createdate')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Zeitpunkt der Erstellung');

            $table->foreign('ab_creator_id')->references('id')->on('ab_user');
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
        Schema::dropIfExists('ab_shoppingcart');
    }
}
