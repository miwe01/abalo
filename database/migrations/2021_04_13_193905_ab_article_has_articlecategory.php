<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AbArticleHasArticlecategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'pgsql';
    public function up()
    {
        //
        Schema::create('ab_article_has_articlecategory', function(Blueprint $table){
            $table->id();

            $table->bigInteger('ab_articlecategory_id')->nullable(false)->comment('Referenz auf eine Artikelkategorie');
            $table->bigInteger('ab_article_id')->nullable(false)->comment('Referenz auf einen Artikel ab_articlecategory_id, ab_article_id');
            //$table->unique('ab_articlecategory_id', 'ab_article_id');

            $table->foreign('ab_articlecategory_id')->references('id')->on('ab_articlecategory');
            $table->foreign('ab_article_id')->references('id')->on('ab_article');

            //DB::statement('ALTER TABLE `ab_article_has_articlecategory` ADD COLUMN `id` SERIAL PRIMARY KEY');
           // DB::statement('ALTER TABLE ab_article_has_articlecategory ADD mobile VARCHAR(13)');
//            ALTER TABLE test1 ADD COLUMN id SERIAL PRIMARY KEY;
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
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
}
