<?php

namespace App\Models;

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
        Log::debug( DB::table('ab_article')->where('ab_name', 'ilike', '%'.$s.'%')->get());
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


    public function insertArticle(){
        if (isset($_POST['name']) && $_POST['name'] !== "" && isset($_POST['price']) && $_POST['price'] > 0 && isset($_POST['description']) && $_POST['description'] !== "")
        {
            // gibt größte ID zurück um größte Id+1 zurückzubekommen
            $maxId = DB::table('ab_article')->max('id');

            $q = DB::table('ab_article')->insert([
                'id' => $maxId +1,
                'ab_name' => $_POST['name'],
                'ab_price' => $_POST['price'],
                'ab_description' => $_POST['description'],
                'ab_creator_id' => 1
            ]);
            return $maxId +1;

        }
        return 1;

    }
}
