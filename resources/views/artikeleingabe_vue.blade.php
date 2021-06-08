<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artikeleingabe</title>
    <meta name="csrf-token" content="">
    <script defer src="./js/app.js"></script>

</head>
<body>

<div id="app">
    <site-header>
        <script type="module">
            import menu from '{{asset('js/menu.js')}}'
            menu.createMenu();
        </script>
    </site-header>
    <nav id="menu"></nav>

    <h1>------</h1>
    <site-body v-bind:is="currentTabComponent" class="tab"></site-body>
    <h1>------</h1>
    <site-footer></site-footer>
    <footer></footer>

</div>

</body>
</html>
