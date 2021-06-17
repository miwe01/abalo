<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artikeleingabe</title>
    <script defer src="./js/app.js"></script>
    <link href="./css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
   </head>
<body>
Eingeloggter User: {{$user}}<br>
Verkäufer von dem Artikel: {{$seller}}<br>

<script>
    // M5 Aufgabe 8 && 9
    function sendText() {
        let msg = {
            action: 'echo',
            data: '{"id":2, "message":"In Kürze verbessern wir Abalo für Sie!\\nNach einer kurzen Pause sind wir wieder\\nfür Sie da! Versprochen."}'
        }
        socket.send(JSON.stringify(msg))
    };

    var socket = new WebSocket("ws://localhost:8000/demo");
    socket.addEventListener('open', function (event) {
        // sendText();
    });


    socket.onmessage = function (event) {
        var jsonObject = JSON.parse(event.data);
        var json = JSON.parse(jsonObject.data);
        // M5 Aufgabe 8
        if (json.id === 2)
            alert(json.message);
        // M5 Aufgabe9
        if (json.id === 3){
            var seller = json.seller;
            axios
                .get("/checkAktuellenBenutzer?id=" + seller)
                .then(response => {
                    if (response.data !== 1)
                        alert("Großartig! Ihr Artikel " + json.message[0].ab_name + " wurde erfolgreich verkauft!")

                })
                .catch(error => console.log(error))

        }
    }


</script>


<div id="app">
    <site-header id="menu">
        <h1>Abalo</h1>
        <script type="module">
            import menu from '{{asset('js/menu.js')}}'
            menu.createMenu();
        </script>
    </site-header>
    <div id="tab-comp">
     <site-body v-bind:is="currentTabComponent" class="tab"></site-body>
    </div>
    <site-footer></site-footer>
    <footer></footer>

</div>

</body>
</html>
