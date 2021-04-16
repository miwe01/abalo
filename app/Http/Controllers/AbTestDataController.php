<?php

namespace App\Http\Controllers;

use App\Models\AbTestData;
use Illuminate\Http\Request;

class AbTestDataController extends Controller
{
    //
    function index(){

        (new \App\Models\AbTestData)->index();
    }



}
