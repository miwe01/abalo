<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Article extends Model
{
    use HasFactory;
    protected $table = 'ab_article';

    public function search($s){
        $limit = PHP_INT_MAX;
        $offset = 0;
        if (isset($_GET["limit"]))
            $limit = $_GET["limit"];
        if (isset($_GET["offset"]))
            $offset = $_GET["offset"];
        //Log::debug( DB::table('ab_article')->where('ab_name', 'ilike', '%'.$s.'%')->get());
        return DB::table('ab_article')->where('ab_name', 'ilike', '%'.$s.'%')->limit($limit)->offset($offset)->get();
    }

    public function allArticles(){
        return DB::table('ab_article')
            ->leftjoin('ab_shoppingcart_item', 'ab_article.id', '=', 'ab_shoppingcart_item.ab_article_id')
            ->select('ab_article.*', 'ab_shoppingcart_item.ab_article_id')
            ->get()
            ->sortBy('id');
    }
    public function shoppingCartArticles(){
        return DB::table('ab_article')
            ->leftjoin('ab_shoppingcart_item', 'ab_article.id', '=', 'ab_shoppingcart_item.ab_article_id')
            ->select('ab_article.*', 'ab_shoppingcart_item.ab_article_id')
            ->whereNotNull('ab_shoppingcart_item.ab_article_id')
            ->get();
    }


    public function insertArticle($name, $price, $description){
        if (isset($name) && $name !== "" && isset($price) && $price > 0 && isset($description) && $description !== "")
        {
            Log::debug('djd');
            // gibt größte ID zurück um größte Id+1 zurückzubekommen
            $maxId = DB::table('ab_article')->max('id');

            $q = DB::table('ab_article')->insert([
                'id' => $maxId +1,
                'ab_name' => $name,
                'ab_price' => $price,
                'ab_description' => $description,
                'ab_creator_id' => 1
            ]);
            return $maxId +1;

        }
        return 1;
    }

    public function getArticleName($id){
        if(isset($id)){
            return DB::table('ab_article')->where('id', $id)->get('ab_name');
        }
    }
    public function getArticleSeller($id){
        if(isset($id)){
            $creatorid = DB::table('ab_article')->where('id', $id)->value('ab_creator_id');
            return DB::table('ab_user')->select('ab_name')->where('id', $creatorid)->value('ab_name');
        }
    }
}
