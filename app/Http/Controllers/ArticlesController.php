<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    //
    public function search(Request $r){
        if (isset($_GET['search'])){
            $a = ((new \App\Models\Article)->search($_GET['search']));

            return view('articles', ['articles'=>$a]);
        }
        else{
            $a = ((new \App\Models\Article)->search(""));

            return view('articles', ['articles'=>$a]);
        }
    }

    public function insertArticle(){
        if (isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"])){
            $a = (new Article())->insertArticle();

            if ($a){
                return view('m2_newarticle', ['success' =>'SUCESS']);
            }
            else{

                return view('m2_newarticle', ['error' =>'ERROR']);
            }

        }
        else{
            return view('m2_newarticle');
        }
    }

}
