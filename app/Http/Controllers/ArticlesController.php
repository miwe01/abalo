<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ShoppingCart;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Session\Session;

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
        Log::debug('check');
        if (isset($_GET["search"])){
            $a = ((new \App\Models\Article)->search($_GET['search']));
            return response()->json(
                $a
               );
        }
    }

    // M3 Aufgabe 8
    public function addArticle_api(Request $r){
        Log::debug($r);
        if (isset($r['name']))
            Log::debug("namee");
        if (isset($r["name"]) && isset($r["price"]) && isset($r["description"])){
            $a = ((new \App\Models\Article)->insertArticle($r["name"], $r["price"], $r["description"]));

            if ($a)
                return response()->json(["id" =>$a]);
            return response()->json("Fehler aufgetreten");
        }
        return response()->json("Parameter sind nicht gesetzt");

    }
    public function addArticle(){
        return view('articles_api');
    }

    public function newSite(){
        $allArticles = ((new \App\Models\Article)->allArticles());
        $shoppingCartArticles = ((new \App\Models\Article)->shoppingCartArticles());
        ((new ShoppingCart)->addShoppingCart());
        return view('newsite', ['articles'=>$allArticles, 'shoppingCartArticles'=>$shoppingCartArticles]);
    }

    // view New Site with single file components
    public function viewNewSite(Request $r){
        // checkt ob $user existiert, gilt nur für angemeldete Benutzer
        $user = "";
        $seller = "";

        if ($r->session()->exists('abalo_user') && $r->session()->exists('seller')){
            $user = $r->session()->get('abalo_user');
            $seller = $r->session()->get('seller');
        }
        return view('artikeleingabe_vue', ['user' => $user, 'seller'=>$seller]);
    }

    //sell Article api
    public function sellArticle_api(Request $r){
            if ($r->session()->exists('abalo_user')){
                if ($r->id != ""){
                    // ArtikelName bekommen und wer der Seller von dem Artikel ist
                    $articleName = (new \App\Models\Article)->getArticleName($r->id);
                    $articleSeller = (new \App\Models\Article)->getArticleSeller($r->id);
                    $r->session()->put('seller', $articleSeller);

                    $client = new \Bloatless\WebSocket\Client;
                    $client->connect('127.0.0.1', 8000, '/demo');
                    $client->sendData(json_encode([
                                'action' => 'echo',
                                'data' => '{"id":3, "artikelid":3, "message":'. $articleName . ', "seller":"' . $articleSeller . '"}']
                        )
                    );
                    echo "Daten gesendet";
                }
            }

        }

   // checkt wenn eingeloggter Benutzer, Artikel Besitzer ist
    public function eingeloggterBenutzerID(Request $r){
        if ($r->session()->exists('abalo_id')) {
            return $r->session()->get('abalo_id');
        }
//            if ($r->id != ""){
//                $articleSeller = (new \App\Models\Article)->getArticleSeller($r->id);
////                echo $r->session()->get('abalo_user');
////                echo $articleSeller;
//                //
//                //
//                // || danach wegmachen nur für Test Zwecke!!!!!!!!!!!!!!!!
//                //
//                //
//                if ($articleSeller == "seller3" || $articleSeller == $r->session()->get('abalo_user')){
//                    return "ja";
//                }
//
//            }
       // }


    }

    public function checkAktuellenBenutzer(Request $r)
    {
        $articleSeller = "";
        // wenn Id mitgeschickt gibt Namen zurück
        if (!isset($r->id)){
            die("Parameter nicht gesetzt");
        }
        if (is_numeric($r->id))
            $articleSeller = (new \App\Models\Article)->getArticleSeller($r->id);
        else
            $articleSeller = $r->id;

        // wenn Benutzer eingeloggt
        if ($r->session()->exists('abalo_id')) {
            // Wenn Benutzer nicht gleich Verkauefer ist
            if ($articleSeller != $r->session()->get('abalo_user'))
                return "1";
        }
        return "2";
    }

}


