<?php

namespace App\Http\Controllers;

use App\Models\AbTestData;
use Illuminate\Http\Request;

class AbTestDataController extends Controller
{
    //
    function index(){
        echo "Hallo";
        (new \App\Models\AbTestData)->index();

        echo '<br>';

        $file = file_get_contents('articles.csv');

        $file = str_replace('"', '', $file);
        $array = explode(';',$file);
        //dd($array);
//        echo $array[5] . $array[1];
        $file = fopen(base_path('/public/articlecategory.csv'),"r");
        $i = 0;
        while($row = fgets($file))
        {
            if($i!=0){
                $num = explode(";", $row);
                echo $num[0]. $num[1] . $num[2] . '<br>';
            }
            $i++;
        }
        fclose($file);


//        for($i=0;$i<count($array);$i+=5){
//            DB::table('ab_article')->insert([
//                'id' => $array[$i],
//                'ab_name' => $array[$i+1],
//                'ab_price' => $array[$i+2],
//                'ab_description' => $array[$i+3],
//                'ab_creator_id' => $array[$i+4],
//                'ab_createdate' => $array[$i+5],
//
//            ]);
//        }
    }



}
