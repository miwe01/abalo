<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    //
    public function search(Request $r){
        if (isset($_GET['search'])){
            (new \App\Models\Article)->searching($_GET['search']);
        }
    }
}
