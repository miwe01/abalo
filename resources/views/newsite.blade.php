<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script src="{{asset('js/vue.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>

<body>
<div id="app">
    <site-header>
        <menu id="myMenu">
            <script type="module">
                import menu from '{{asset('js/menu.js')}}'
                menu.createMenu();
            </script>
        </menu>

    </site-header>
    <nav id="menu"></nav>

    <site-body v-bind:is="currentTabComponent" class="tab"></site-body>
    <site-footer>
    </site-footer>
</div>

<script>
    Vue.component('site-header', {
        template: `<h1>Abalo Webshop</h1>`
    });
    Vue.component('site-body', {
        template: ``
    });
    Vue.component('site-footer', {
        template:
            `<button v-on:click="$root.currentTab = 'impressum'">Impressum</button>`
    });
</script>


<script>
    Vue.component('tab-home', {
        template: `<div>
                    <h2>Willkommen bei Abalo</h2>
                    <p>Abalo - Dein Online Shop</p>
                   </div>`
    })

    Vue.component('tab-artikelsuche', {
        data: function(){
           return{
               message: '', articles: '', zaehler: 0, offset: 0, limit: 2
           }
        },
        template: `#filtersuche`,
        methods:{
            // Ändert Seitenanzahl wenn genug Artikel da sind
            changePage: function(z, msg){
                if (z > 0 && z < 10){
                    if (msg === "next"){
                        this.zaehler += 1;
                        this.offset += this.limit;
                    }
                    else{
                        this.zaehler -= 1;
                        this.offset -= this.limit;
                    }
                    this.addEvent();
                }
            },
            addEvent: function()
            {
                let l = document.getElementById('filter').value;
                if (l.length === 0)
                    this.articles = "";
                if (l.length >= 3)
                    this.sendAjax(l);
                else{
                    this.zaehler=0
                    this.offset=0
                    this.articles=""
                }
            },
            sendAjax(text){
                let s = text;
                axios
                    .get("/api/articles/?search=" + s + "&limit=" + this.limit + "&offset=" + this.offset)
                    .then(response => (this.articles = response.data))
                    .catch(error => console.log(error))
            }
        }
    })
    Vue.component('tab-artikelliste', {
        template: `#artikelliste`
    })
    Vue.component('tab-impressum', {
        template: '#checkbox-template'
    })

    new Vue({
        el: "#app",
        data: {
            Impressum: '',
            currentTab: "home",
            tabs: ['home', 'artikelliste', 'artikelsuche']
        },
        computed: {
            currentTabComponent: function() {
                return "tab-" + this.currentTab;
            }
        },
        methods:{
            addEventToMenu: function(id, tab){
                document.getElementById(id).addEventListener('click', function() {
                    this.currentTab = tab;
                }.bind(this), false);
            }
        },
        mounted: function(){
            // Nachdem auch die ganze Webseite geladen wurde (auch import)
            // Click Event auf Menü
            window.addEventListener('load', () => {
                this.addEventToMenu('li-Kategorien', 'artikelliste');
                this.addEventToMenu('li-Home', 'home');
                this.addEventToMenu('li-Verkaufen', 'artikelsuche');
            })

        }
    });

</script>

<!-- X-Template -->
<script type="text/x-template" id="artikelliste">
<div>
    <h2>Alle Artikel</h2>
    <table id="warenkorbArtikel">
        @foreach ($articles as $a)
            <tr>
                <td id="warenkorb-{{$a->id}}">{{$a->id}}</td>
                <td>{{$a->ab_name}}</td>
                <td>{{$a->ab_price}}€</td>
                <td>{{$a->ab_description}}</td>
                <td>{{$a->ab_createdate}}</td>
            </tr>
        @endforeach
    </table>
</div>
</script>

<!-- X-Template -->
<script type="text/x-template" id="filtersuche">
<div id="filter-div">
    <p>@{{message}}</p>
    Artikel suchen:<input id="filter" type="text" @input="addEvent"><br>

    <ul v-for="item in articles">
        <li> ID: @{{item.id}} Name: @{{item.ab_name}}</li>
    </ul>

    <div>
        <span @click="changePage(zaehler, 'back')"><</span>
        <span>@{{zaehler}}</span>
        <span @click="changePage(zaehler, 'next')">></span>
    </div>
</div>
</script>

<!-- X-Templates -->
<script type="text/x-template" id="checkbox-template">
    <div class="demo-tab">
        <h1>Impressum</h1>
        <p>Betreiber der Website: Max Meister</p>
        <p>
            Adresse: Impressumsstraße 7, 22222 Impressumsstadt
        </p>

        <p>Vertretung des Unternehmens
            Peter Mueller</p>
        <p>
            Kontakt
            Telefon: +49 30 123456
        </p>
        <p>
            Fax: +49 30 123456</p>
        <p>E-Mail: kontakt@max-meister.de</p>
        <p>Internet: www.max-meister.de</p>
    </div>
</script>


</body>
</html>
