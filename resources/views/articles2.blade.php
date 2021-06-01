<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <title>Artikel</title>
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script src="{{asset("js/cookiecheck.js")}}"></script>

    <style>
        table, td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        table{
            min-width: 1000px;
            max-width: 1000px;
        }
        td{
            padding: 10px;
        }
    </style>

</head>
<body>
<h1>Artikel einkaufen</h1>

<div id="filter-div">
    <p>@{{message}}</p>
    Artikel suchen:<input id="filter" type="text" @input="addEvent"><br>

    <ul v-for="item in articles">
        <li> ID: @{{item.id}} Name: @{{item.ab_name}}</li>
    </ul>
</div>


<script>
    var filter = new Vue({
        el: "#filter-div",
        data:{
            message: null,
            articles: []
        },
        methods:{
            addEvent: function(event) {
                if (event.target.value.length >= 3)
                    this.sendAjax(event.target.value);
                if (event.target.value.length === 0)
                    this.articles = "";
            },
            sendAjax(text){
                let s = text;
                const limit = 5;
                axios
                    .get("/api/articles/?search=" + s + "&limit=" + limit)
                    .then(response => (this.articles = response.data))
                    .catch(error => console.log(error))
            }
        }
    })
</script>


@if(!empty($articles))
    <h2>Warenkorb</h2>

    <table id="warenkorbArtikel">
        @foreach ($shoppingCartArticles as $a)
            <tr>
                <td id="warenkorb-{{$a->id}}">{{$a->id}}</td>
                <td>{{$a->ab_name}}</td>
                <td>{{$a->ab_price}}€</td>
                <td>{{$a->ab_description}}</td>
                <td>{{$a->ab_createdate}}</td>
                <td><span onclick="removeArticle({{json_encode($a->id)}})" style="font-size: 20px;cursor: pointer">-</span></td>
            </tr>
        @endforeach

    </table>


    <h2>Artikelübersicht</h2>

    <table>
    @foreach ($articles as $a)
        <tr>
            <td id="{{$a->id}}">{{$a->id}}</td>
            <td>{{$a->ab_name}}</td>
            <td>{{$a->ab_description}}</td>
            <td>{{$a->ab_price}}€</td>
            <td>{{$a->ab_createdate}}</td>
            <td><span onclick="inWarenkorb({{json_encode($a)}}, true)" class="checkShoppingCart" style="font-size: 20px;cursor: pointer">+</span></td>
        </tr>
        <!-- Wenn Artikel schon im Warenkorb ist ->display:none -->
            <script>
        @if($a->id == $a->ab_article_id)
                document.getElementById({{$a->id}}).parentElement.style.display = "none";
        @endif
            </script>
    @endforeach

    </table>
@endif

<script>

   function removeArticle(artikelid){
       document.getElementById("warenkorb-"+ artikelid).parentElement.remove();
       document.getElementById(artikelid).parentElement.style.display = "table-row";

       // ajax lösche item aus db
       // Params: Artikelid, ShoppingcartID
       removeItemfromShoppingCart(artikelid, 1);
   }

   // API um Artikel zu löschen
   function removeItemfromShoppingCart(artikelid, shoppingid){
       var xhr = new XMLHttpRequest();
       xhr.open('DELETE', "/api/shoppingcart/" + shoppingid + '/articles/' + artikelid);
       xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

       // csrf token
       xhr.setRequestHeader("X-CSRF-TOKEN",
           document.getElementById("csrf-token").getAttribute('content')
       );

       xhr.onreadystatechange = function () {
           if (xhr.status === 200 && xhr.readyState === 4)
               console.log(xhr.responseText);
           else
               console.error(xhr.statusText);
       }
       xhr.send();
   }


    // ajax setzt artikel in Warenkorb (Serverseitig)
    function addItemtoShoppingCart(artikelid){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "/api/shoppingcart");
        // csrf token
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-CSRF-TOKEN",
            document.getElementById("csrf-token").getAttribute('content')
        );

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200)
                console.log("DEBUG:" + xhr.responseText);
            else
                console.error("DEBUG:" + xhr.statusText);
            }
        xhr.send('id=' + artikelid);
    }


    // mache Artikel in Warenkorb und lasse Artikel verschwinden
    // außerdem füge ein Minus zum Artikel hinzu
    function inWarenkorb(artikel){
        // Wenn neuer Artikel soll aus Liste verschwinden


        addItemtoShoppingCart(artikel.id);
        document.getElementById(artikel.id).parentElement.style.display = "none";

        let tr = document.createElement('tr');
        let i=0;

        for (let key in artikel) {
            if (key !== "ab_article_id" && key !== "ab_creator_id"){
                let td = document.createElement('td');
                if (i === 0){
                    td.setAttribute('id', "warenkorb-" + artikel[key]);
                }

                if (key === "ab_price")
                    td.innerText = artikel[key] + "€";
                else
                    td.innerText = artikel[key];

                tr.appendChild(td);
                i++;
            }
        }

        let tdminus = document.createElement('td');
        let minus = document.createElement('span')
        minus.innerText = "-";
        minus.style.fontSize = "20px";
        minus.style.cursor = "pointer";

        tdminus.append(minus);
        tr.appendChild(tdminus);
        minus.addEventListener("click", function(){
            removeArticle(artikel.id);
        });

        document.getElementById("warenkorbArtikel").appendChild(tr);
    }

    //document.cookie = "check=false; expires=Thu, 01 Jan 2022 00:00:00 UTC; path=/;";
    setCookieDiv();
</script>
</body>
</html>
