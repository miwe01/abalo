<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
<script>
    var xhr = new XMLHttpRequest();

    var url = new URL(window.location.href);
    var name = url.searchParams.get("name");
    var price = url.searchParams.get("price");
    var description = url.searchParams.get("description");

    if (price > 0 && name !== ""){

        xhr.open('POST', "/articles");
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
        }

        xhr.send('name=' + name + '&price=' + price + '&description=' + description);
        //xhr.send();
    }
</script>
</body>
</html>
