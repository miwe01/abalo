<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ShoppingCart;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticlesController extends Controller
{
    //
    public function search(Request $r){
        $allArticles = ((new \App\Models\Article)->allArticles());
        $shoppingCartArticles = ((new \App\Models\Article)->shoppingCartArticles());
        ((new ShoppingCart)->addShoppingCart());

        return view('articles2', ['articles'=>$allArticles, 'shoppingCartArticles'=>$shoppingCartArticles]);
    }

    public function insertArticle(){
        return view('m2_newarticle');
    }
    public function insertArticleAjax(Request $r){
        if ($r->has('name') && $r->has('price') && $r->has('description')){
            $a = (new Article())->insertArticle();
            if ($a)
                return response()->json(['sucess'=>"SUCESS"]);
            }

        return response()->json(['error'=>"ERROR"]);
    }

    // M3 Aufgabe 7
    public function index(){
        return view('searchArticle');
    }

    public function allIds_api()
    {
        if (isset($_GET["search"])){
            $a = ((new \App\Models\Article)->search($_GET['search']));
            return response()->json(
                $a
               );
        }
    }

    // M3 Aufgabe 8
    public function addArticle_api(){
        if (isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"])){
            $a = ((new \App\Models\Article)->insertArticle());
            if ($a)
                return response()->json(["id" =>$a]);
            return response()->json("Fehler aufgetreten");
        }
        return response()->json("Parameter sind nicht gesetzt");

    }
    public function addArticle(){
        return view('articles_api');
    }
}
