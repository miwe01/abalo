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
    function sendData(name, preis, beschreibung, token){
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/newarticle');
        // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.setRequestHeader("X-CSRF-Token", token);

        let formData = new FormData();
        formData.append("name", name);
        formData.append("price", preis);
        formData.append("description", beschreibung);
        xhr.send(formData);
        //formData.append("_token", token);
        xhr.onreadystatechange = function() {
            console.log(xhr.status);
            if (xhr.readyState === 4 && xhr.status === 200) {
               // console.log(xhr.responseText);
                let json = JSON.parse(xhr.responseText);
                 console.log("sucess");
                 if (json["sucess"] === "SUCESS"){
                     document.getElementById('ausgabe').innerText = "Das Produkt wurde erfolgreich hinzugefügt";
                 }
            }
            else{
                document.getElementById('ausgabe').innerText = "Fehler beim einfügen";
            }
        };
    }


    function checkField(){
        event.preventDefault();
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
        p.innerText = "";

        let name = document.getElementById('name').value;
        let price = document.getElementById('price').value;
        let description = document.getElementById('description').value;
        let token = document.getElementById('token').value;
        sendData(name, price, description, token);
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
   // f.setAttribute('onsubmit', 'return checkField()');
    f.setAttribute('id', 'neuer_artikel')

    btn.innerText = "Senden";
    btn.setAttribute('onclick', 'checkField()');

    i1.setAttribute('placeholder', 'Artikelname');
    i2.setAttribute('placeholder', 'Preis');
    i3.setAttribute('placeholder', 'Beschreibung');

    i2.setAttribute('type', 'number');

    i1.setAttribute('name', 'name');
    i2.setAttribute('name', 'price');
    i3.setAttribute('name', 'description');

    i1.setAttribute('id', 'name');
    i2.setAttribute('id', 'price');
    i3.setAttribute('id', 'description');

    csrf.setAttribute("id", "token");
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
<p id="ausgabe"></p>
</body>
</html>
