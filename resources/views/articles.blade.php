<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <title>Artikel</title>
    <script src="{{asset("js/cookiecheck.js")}}"></script>

    <style>
        table, td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        td{
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>Artikel einkaufen</h1>
@if(!empty($articles))
    <h2>Warenkorb</h2>
    <button onclick="newShoppingCart()">Neuen Einkaufswagen anlegen</button>
    <table id="warenkorbArtikel">

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
            <td><span onclick="inWarenkorb({{json_encode($a)}})" style="font-size: 20px;cursor: pointer">+</span></td>
        </tr>
    @endforeach

    </table>
@endif

<script>
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
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error(xhr.statusText);
                }
            }
        };
        xhr.send('id=' + artikelid);
    }
    function inWarenkorb(artikel){
        addItemtoShoppingCart(artikel.id);

        document.getElementById(artikel.id).parentElement.style.display = "none";

        let tr = document.createElement('tr');
        let i=0;
        for (let value of Object.values(artikel)){
            let td = document.createElement('td');
            td.innerText = value;

            if (i === 0){
                td.setAttribute('id', value + "warenkorb");
            }

            tr.appendChild(td);
            i++;
        }
        let tdminus = document.createElement('td');
        let minus = document.createElement('span');
        minus.addEventListener("click", function(){
            let el = document.getElementById(artikel.id + "warenkorb").parentElement;
            el.remove();

            document.getElementById(artikel.id).parentElement.style.display = "table-row";
        })
        minus.innerText = "-";
        minus.style.fontSize = "20px";
        minus.style.cursor = "pointer";
        tdminus.append(minus);
        tr.appendChild(tdminus);

        document.getElementById('warenkorbArtikel').appendChild(tr);
    }

    function newShoppingCart(){
        var xhr = new XMLHttpRequest();

        xhr.open('GET', "/articles/newShoppingCart");

        //xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error(xhr.statusText);
                }
            }
        };
        xhr.send();
    }


    //document.cookie = "check=false; expires=Thu, 01 Jan 2022 00:00:00 UTC; path=/;";
    setCookieDiv();

</script>
</body>
</html>
