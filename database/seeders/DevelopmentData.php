<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User File
        $file = fopen(base_path('/public/csv/user.csv'),"r");
        $i = 0;
        while($row = fgets($file))
        {
            if($i!=0){
                $num = explode(";", $row);
                DB::table('ab_user')->insert([
                    'id' => $num[0],
                    'ab_name' => $num[1],
                    'ab_password' => $num[2],
                    'ab_mail' => $num[3]
                ]);
                //echo $num[0]. $num[1] . gettype($num[2]) .  $num[3] . '<br>';
            }
            $i++;
        }
        fclose($file);
        //


        // Article File
        $file = fopen(base_path('/public/csv/articles.csv'),"r");
        $i = 0;
        while($row = fgets($file))
        {
            if($i!=0){
                $num = explode(";", $row);

                DB::table('ab_article')->insert([
                    'id' => $num[0],
                    'ab_name' => $num[1],
                    'ab_price' => (int) $num[2],
                    'ab_description' => $num[3],
                    'ab_creator_id' => $num[4],
                    'ab_createdate' => $num[5],
                ]);
            }
            $i++;
        }
        fclose($file);
        //


        //File Article Category
        $file = fopen(base_path('/public/csv/articlecategory.csv'),"r");
        $i = 0;
        while($row = fgets($file))
        {
            if($i!=0){
                $num = explode(";", $row);
                DB::table('ab_articlecategory')->insert([
                    'id' => $num[0],
                    'ab_name' => $num[1],
                    'ab_parent' => (int) $num[2]
                ]);
            }
            $i++;
        }
        fclose($file);
    }
}
