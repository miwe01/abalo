<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;
    protected $table = 'ab_article';

    public function search($s){
        return DB::table('ab_article')->where('ab_name', 'ilike', '%'.$s.'%')->get();
    }

    public function insertArticle(){
        //print_r($_POST);
        if (isset($_POST['name']) && $_POST['name'] !== "" && isset($_POST['price']) && $_POST['price'] > 0 && isset($_POST['description']) && $_POST['description'] !== "")
        {
            $q = DB::table('ab_article')->insert([
                'ab_name' => $_POST['name'],
                'ab_price' => $_POST['price'],
                'ab_description' => $_POST['description'],
                'ab_creator_id' => 1
            ]);
            return $q;

        }
        return 1;

    }
}
