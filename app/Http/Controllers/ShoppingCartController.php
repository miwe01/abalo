<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{
    // adds a Shopping cart
    public function addShoppingCart(){
        $a = ((new \App\Models\ShoppingCart)->addShoppingCart());
        return response()->json($a);
    }

    // add Item to shopping List
    public function addShoppingCartItem_api(Request $r){
        if ($r->input('id') != ""){
            $a = ((new \App\Models\ShoppingCartItem)->addShoppingArticle($r->input('id')));
            if ($a)
                return "OK";
        }
        return "FEHLER";
    }

    // remove Item from Shopping List
    public function removeShoppingCartItem_api($shoppingID, $artikelID){

        if ($shoppingID == "" || $artikelID == "")
            return response()->json('Fehler remove');

        $a = ((new \App\Models\ShoppingCartItem)->removeShoppingArticle($shoppingID, $artikelID));
        return response()->json('OK remove');
    }

    // bekomme alle Items die im ShoppingCart sind
    public function getAllShoppingArticles($shoppingID){
        if ($shoppingID == "")
            return response()->json('Fehler beim Shopping Artikel finden');

        $a = ((new \App\Models\ShoppingCartItem)->getAllShoppingArticles($shoppingID));
        return response()->json($a);
    }
}
