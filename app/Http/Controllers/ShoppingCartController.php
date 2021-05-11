<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{
    public function addShoppingCart(){
        $a = ((new \App\Models\ShoppingCart)->addShoppingCart());
        return response()->json($a);
    }

    public function addShoppingCartItem_api(Request $r){
        if ($r->input('id') != ""){
            Log::debug('An informational message.');
            $a = ((new \App\Models\ShoppingCartItem)->addShoppingArticle($r->input('id')));
            if ($a)
                return response()->json("OK");
        }
        return response()->json("Fehler");
    }
}
