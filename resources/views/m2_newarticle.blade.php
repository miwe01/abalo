<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Neuen Artikel eintragen</h1>
<script src="{{asset("js/cookiecheck.js")}}"></script>

@if(isset($success))
    {{"Das Produkt wurde erfolgreich eingetragen"}}
@elseif(isset($error))
    {{"Fehler beim einfügen"}}
@endif
<script>
    function checkField(){
        let p = document.getElementById('para');
        let check = true;

        if (document.getElementById('name').value === ""){
            p.innerText = "Artikelname ist leer";
            check = false;
        }
        else if(document.getElementById('price').value === ""){
            p.innerText = "Preis ist leer";
            check = false;
        }
        else if (document.getElementById('price').value <= 0){
            p.innerText = "Ungültiger Preis";
            check = false;
        }

        else if (document.getElementById('description').value === ""){
            p.innerText = "Beschreibung ist leer";
            check = false;
        }

        if (check === false)
            return false;

       // document.getElementById('neuer_artikel').submit();
    }


    let f =document.createElement('form');
    let i1 = document.createElement('input');
    let i2 = document.createElement('input');
    let i3 = document.createElement('input');
    let btn = document.createElement('button');
    let csrf = document.createElement('input');
    let linebreak = document.createElement('br');
    let p = document.createElement('p');

    p.setAttribute('id', 'para');
    p.style.color = "red";

    f.setAttribute('method', 'post');
    f.setAttribute('action', '/newarticle');
    f.setAttribute('onsubmit', 'return checkField()');
    f.setAttribute('id', 'neuer_artikel')

    btn.innerText = "Senden";
    //btn.setAttribute('name', 'submit');
    btn.setAttribute('onclick', 'checkField()');


    i1.setAttribute('placeholder', 'Artikelname');
    i2.setAttribute('placeholder', 'Preis');
    i2.setAttribute('type', 'number');
    i3.setAttribute('placeholder', 'Beschreibung');

    i1.setAttribute('name', 'name');
    i2.setAttribute('name', 'price');
    i3.setAttribute('name', 'description');

    i1.setAttribute('id', 'name');
    i2.setAttribute('id', 'price');
    i3.setAttribute('id', 'description');

    csrf.setAttribute("type","hidden");
    csrf.setAttribute("name","_token");
    csrf.setAttribute("value","{{csrf_token()}}")



    f.appendChild(i1);
    f.appendChild(linebreak);
    f.appendChild(i2);
    linebreak = document.createElement('br');
    f.appendChild(linebreak);

    f.appendChild(i3);
    linebreak = document.createElement('br');
    f.appendChild(linebreak);
    linebreak = document.createElement('br');
    f.appendChild(linebreak);
    f.appendChild(csrf);
    f.appendChild(btn);
    f.appendChild(p);



    document.body.appendChild(f);

    //document.cookie = "check=false; expires=Thu, 01 Jan 2022 00:00:00 UTC; path=/;";
    setCookieDiv();
</script>

<form method="post"></form>
</body>
</html>
