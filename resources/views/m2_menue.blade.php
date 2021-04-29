<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Menü</title>
</head>
<script src="{{asset("js/cookiecheck.js")}}"></script>

<body>
<script>
    function create($s){
        return document.createElement($s);
    }
let nav = create('nav');
let ul1 = create('ul');
let ul2 = create('ul');
let li1 = create('li');
let li2 = create('li');
let li3 = create('li');
let li4 = create('li');
let li5 = create('li');
let li6 = create('li');

li1.innerText = "Home";
li2.innerText = "Kategorien";

li3.innerText = "Verkaufen";
li4.innerText = "Unternehmen";
li5.innerText = "Philosophie";
li6.innerText = "Karriere";

ul2.append(li5, li6);
ul1.append(li1, li2, li3, li4, ul2);
nav.append(ul1);

document.body.appendChild(nav);



setCookieDiv();




</script>

</body>
</html>
