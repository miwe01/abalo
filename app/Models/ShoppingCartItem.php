<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShoppingCartItem extends Model
{
    use HasFactory;
    protected $table = 'ab_shoppingcart_item';

    public function addShoppingArticle($itemid){
        $maxId = DB::table('ab_shoppingcart_item')->max('id');
        // Bekomme Id von Shopping Cart
        $shoppingcardid = ((new \App\Models\ShoppingCart)->getShoppingCartId(1));

        //Log::debug($itemid);

        if($shoppingcardid && $itemid != ""){
            $q = DB::table('ab_shoppingcart_item')->insert([
                'id' => $maxId+1,
                'ab_shoppingcart_id' => $shoppingcardid,
                'ab_article_id' => $itemid
            ]);
            return 1;
        }
        return 0;
    }

    public function removeShoppingArticle($shoppingid, $itemid){
        if ($itemid == "" || $shoppingid == "")
            return 0;
        $q = DB::table('ab_shoppingcart_item')
            ->where('ab_article_id', $itemid)
            ->where('ab_shoppingcart_id', $shoppingid)
            ->delete();
        return 1;
    }

    public function getAllItems(){
        $arr = DB::table('ab_shoppingcart_item')->pluck('ab_article_id');
        Log::debug($arr);
        return $arr;
    }

    // Param: array von Artikelitems
    // Return Artikel die im Moment im Shopping Cart sind
    public function getAllShoppingArticles($shoppingID){
        if ($shoppingID == "")
            return false;
        $arr = DB::table('ab_article')
            ->select('ab_article_id.*')
            ->join('ab_shoppingcart_item', 'ab_article.id', '=', 'ab_shoppingcart_item.ab_article_id');

        return $arr;
    }
}
