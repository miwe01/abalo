<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShoppingCart extends Model
{
    use HasFactory;
    protected $table = 'ab_shoppingcart';

    public function addShoppingCart(){
        $q = DB::table('ab_shoppingcart')->insertOrIgnore([
            'id' => 1,
            'ab_creator_id' => 1
        ]);
        return 1;
    }

    public function getShoppingCartId($creatorid){
        return DB::table('ab_shoppingcart')->where('ab_creator_id', $creatorid)->value('id');
    }

}
