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
