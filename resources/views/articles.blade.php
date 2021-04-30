<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            <td><span onclick="inWarenkorb({{json_encode($a)}})" style="font-size: 20px">+</span></td>
        </tr>
    @endforeach

    </table>
@endif

<script>
    function inWarenkorb(artikel){
        console.log(artikel);
        console.log(artikel.ab_name);
        document.getElementById(artikel.id).parentElement.style.display = "none";

        let tr = document.createElement('tr');
        let i=0;
        for (let value of Object.values(artikel)){
            let td = document.createElement('td');
            td.innerText = value;

            if (i === 0){
                td.setAttribute('id', value + "warenkorb");
            }

            console.log(value);

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
        tdminus.append(minus);
        tr.appendChild(tdminus);

        document.getElementById('warenkorbArtikel').appendChild(tr);

    }

    //document.cookie = "check=false; expires=Thu, 01 Jan 2022 00:00:00 UTC; path=/;";
    setCookieDiv();

</script>
</body>
</html>
