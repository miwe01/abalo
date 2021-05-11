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
        Log::debug("check");
        // Bekomme Id von Shopping Cart
        $shoppingcardid = ((new \App\Models\ShoppingCart)->getShoppingCartId(1));

        Log::debug($shoppingcardid);

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

}
