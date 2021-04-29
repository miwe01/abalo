<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Menü</title>
</head>
<script src="{{asset("js/cookiecheck.js")}}"></script>

<body>
<script>
    function create(name){
        return document.createElement(name);
    }

    function createMenu(menu){
        let nav = create('nav');
        let ul = create('ul');

        let elements = menu["el"];

        for (let i=0;i<elements.length;i++){
            let e = create("li")
            e.innerText = elements[i].name;
            ul.append(e);

            // if submenu exists
            if (elements[i].sub === true){
                let sub_ul = create('ul');
                let j = 1;

                for (j=1; j<=elements[i].anzahl;j++)
                {
                    let sub_e = create("li");
                    sub_e.innerText = elements[i+j].name;
                    sub_ul.append(sub_e);
                }
                ul.append(sub_ul);
                i += elements[i].anzahl;
            }
        }
        nav.append(ul);

        document.body.appendChild(nav);
    }

    let menu = {
        el:
        [
            {name:"Home", link: "home"},
            {name: "Kategorien", link: "kategorien", sub:false},
            {name: "Verkaufen", link: "verkaufen", sub:false},
            {name: "Unternehmen", link:"unternehmen", sub:true, anzahl: 2},
            {name: "Philosophie", link:"Philosophie", sub:false},
            {name: "Karriere", link: "karriere", sub: false},
        ]
    };

    createMenu(menu);

// Cookie akzeptieren reset
//document.cookie = "check=false; expires=Thu, 01 Jan 2022 00:00:00 UTC; path=/;";
console.log(document.cookie);


setCookieDiv();




</script>

</body>
</html>
