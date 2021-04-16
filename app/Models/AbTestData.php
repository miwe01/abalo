<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbTestData extends Model
{

    use HasFactory;
    protected $table = 'ab_testdata';

    public function index(){
        foreach (AbTestData::all() as $test) {
            echo $test->id . ' ' . $test->ab_testname . '<br>';
        }
    }

}
