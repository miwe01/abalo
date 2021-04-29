function cookiestatus(cname){
    var ca = document.cookie.split(';');

    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        if (c.indexOf(cname) !== -1) {
            return c.substr(c.indexOf("=") + 1, c.length - 1);
        }
    }
    return false;
}


function setCookieDiv(){
    console.log("Check: " + cookiestatus("check"));
    //document.cookie = "check=false; expires=Thu, 01 Jan 2022 00:00:00 UTC; path=/;";
    if (cookiestatus("check") !== "true"){
        let div = document.createElement('div');
        div.innerText = "Auf unsere Seite werden Cookies verwendet um ihre Web-Erfahrung zu verbessern ";
        div.style.position = "absolute";
        div.style.bottom = "0px";
        div.style.fontSize = "16px";
        div.style.marginBottom = "10px";
        div.style.backgroundColor = "lightgray";
        div.style.display = "block";


        let btn = document.createElement('button');
        btn.innerText = "Alle akzeptieren";
        btn.setAttribute('onclick', 'acceptCookie()');

        div.appendChild(btn);

        document.body.appendChild(div);


    }

}

function acceptCookie(){
    if (cookiestatus("check") !== false){
        document.cookie = "check=true; expires=Thu, 01 Jan 2022 00:00:00 UTC; path=/;";
        document.getElementsByTagName('div')[0].style.visibility = "hidden";
    }
}
