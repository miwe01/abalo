<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'ab_article';

    public function searching(string $s){
        echo '<table><tr><th>ID</th><th>Name</th><th>Beschreibung</th><th>Ersteller ID</th><th>Datum</th></tr>';
        foreach (Article::all() as $test) {
            if (stripos($test->ab_name, $s) !== false){
                echo '<tr><td>' . $test->id . '</td><td>'. $test->ab_name . '</td><td>' . $test->ab_description . '</td><td>' . $test->ab_creator_id . '</td><td>' . $test->ab_createdate . '</td>';
                $image = public_path('images/') . $test->id . '.jpg';
                echo "<td><img src='" . $image . "' alt='bild'></td>";
                echo '</tr>';
            }
        }
        echo '</table>';
    }
}
