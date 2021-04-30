<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AbArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ab_article', function(Blueprint $table){
            $table->bigInteger('id')->comment('Primärschlüssel')->primary();
            $table->string('ab_name', 80)->nullable(false)->comment('Name');
            $table->integer('ab_price')->nullable(false)->comment('Preis in Cent');
            $table->string('ab_description', 1000)->nullable(false)->comment('Beschreibung, die die Güte oder die Beschaffenheit näherdarstellt. Wird durch den „Ersteller“ (Benutzer) gepflegt');
            $table->bigInteger('ab_creator_id')->nullable(false)->comment('Referenz auf den Benutzer, der den Artikel erstellt hat undverkaufen möchte');
            $table->timestamp('ab_createdate')->nullable(false)->comment('Zeitpunkt der Erstellung des Artikels')->default(DB::raw('CURRENT_TIMESTAMP'));

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
        Schema::dropIfExists('ab_article');
    }
}
