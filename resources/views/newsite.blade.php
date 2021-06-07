<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <title>New Site</title>

    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/artikeleingabe.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        table,th,td{
            border:1px solid black;
            border-collapse: collapse;
        }
        td, th{
            padding: 10px;
        }
    </style>

</head>

<body>
<div id="app">
    <!-- Aufgabe10 -->
    <site-header>
        <menu id="myMenu">
            <script type="module">
                import menu from '{{asset('js/menu.js')}}'
                menu.createMenu();
            </script>
        </menu>

    </site-header>
    <nav id="menu"></nav>

    <!-- Aufgabe8 -->
    <site-body v-bind:is="currentTabComponent" class="tab"></site-body>

    <!-- Aufgabe9 -->
    <site-footer></site-footer>
</div>

<script>
    // Aufgabe8
    // site components
    Vue.component('site-header', {
        template: `<h1>Abalo Webshop</h1>`
    });
    Vue.component('site-body', {
        template: ``
    });
    // Aufgabe9
    Vue.component('site-footer', {
        template:
            `<button v-on:click="$root.currentTab = 'impressum'">Impressum</button>`
    });

    // tab components
    Vue.component('tab-home', {
        template: `<div>
                        <h2>Willkommen bei Abalo</h2>
                        <p>Abalo - Dein Online Shop</p>
                   </div>`
    })

    // Aufgabe11 Aufgabe12
    Vue.component('tab-artikelsuche', {
        data: function(){
           return{
               message: '', articles: '', zaehler: 0, offset: 0, limit: 5
           }
        },
        template: `#filtersuche`,
        methods:{
            addEvent: function()
            {
                let l = document.getElementById('filter').value;
                if (l.length >= 3)
                    this.sendAjax(l);
                else{
                    this.zaehler=0
                    this.offset=0
                    this.articles=""
                }
                if (l.length === 0)
                    this.articles = "";
            },
            sendAjax(text){
                let s = text;
                axios
                    .get("/api/articles/?search=" + s + "&limit=" + this.limit + "&offset=" + this.offset)
                    .then(response => (this.articles = response.data))
                    .catch(error => console.log(error))
            },
            // seitenanzahl ändern
            inc: function(z){
                if (z < 10){
                    this.zaehler += 1;
                    this.offset += this.limit;
                    this.addEvent();
                }
            },
            dec: function(z){
                if (z > 0){
                    this.zaehler -= 1;
                    this.offset -= this.limit;
                    this.addEvent();
                }
            }
        }
    })
    Vue.component('tab-artikeleingabe',{
        template: `#artikeleingabe`,
        mounted: function() {
            createForm();
        }
    })

    Vue.component('tab-artikelliste', {
        template: `#artikelliste`,
        data: function(){
            return {
                allarticles: "", zaehler:0, offset:0, limit: 5
            }
        },
        // Aufgabe12
        methods: {
            addEvent: function()
            {
                axios
                    .get("/api/articles/?search=&limit=" + this.limit + "&offset=" + this.offset)
                    .then(response => (this.allarticles = response.data))
                    .catch(error => console.log(error))
            },
            // seitenanzahl ändern
            inc: function(z){
                if (z < 10){
                    this.zaehler += 1;
                    this.offset += this.limit;
                    this.addEvent();
                }
            },
            dec: function(z){
                if (z > 0){
                    this.zaehler -= 1;
                    this.offset -= this.limit;
                    this.addEvent();
                }
            }
        },
        mounted: function(){
            this.addEvent();
        }
    })

    // Aufgabe9
    Vue.component('tab-impressum', {
        template: '#impressum-template'
    })

    // Vue Instanz
    new Vue({
        /* Aufgabe8 */
        el: "#app",
        data: {
            Impressum: '',
            currentTab: "home",
            tabs: ['home', 'artikelliste', 'artikelsuche', 'artikeleingabe']
        },
        computed: {
            currentTabComponent: function() {
                return "tab-" + this.currentTab;
            }
        },
        // Aufgabe10
        // Methode um Klick Event an Element zu binden
        methods:{
            addEventToMenu: function(id, tab){
                document.getElementById(id).addEventListener('click', function() {
                    this.currentTab = tab;
                }.bind(this), false);
            }
        },
        mounted: function(){
            // Nachdem auch die ganze Webseite geladen wurde (auch import)
            window.addEventListener('load', () => {
                this.addEventToMenu('li-Kategorien', 'artikelliste');
                this.addEventToMenu('li-Home', 'home');
                this.addEventToMenu('li-Verkaufen', 'artikeleingabe');
                this.addEventToMenu('li-Unternehmen', 'artikelsuche');
            })

        }
    });
    //
</script>


<!-- X-Template -->
<script type="text/x-template" id="artikelliste">
<div>
    <h2>Alle Artikel</h2>
    <th>ID</th><th>Name</th><th>Preis</th><th>Beschreibung</th><th>Erstellungsdatum</th>
    @verbatim
    <tr v-for="item in allarticles">
        <td>{{item.id}}</td> <td>{{item.ab_name}}</td><td>{{ item.ab_price }}€</td>
        <td>{{ item.ab_description }}</td><td>{{ item.ab_createdate }}</td>
    </tr>
        <div>
            <span @click="dec(zaehler)"><</span>
            <span>{{zaehler}}</span>
            <span @click="inc(zaehler)">></span>
        </div>
    @endverbatim
    <br>
</div>
</script>

<!-- Aufgabe11 -->
<script type="text/x-template" id="filtersuche">
    @verbatim
<div id="filter-div">
    <p>{{message}}</p>
    Artikel suchen:<input id="filter" type="text" @input="addEvent"><br>

    <ul v-for="item in articles">
        <li> ID: {{item.id}} Name: {{item.ab_name}}</li>
    </ul>

    <div>
        <span @click="dec(zaehler)"><</span>
        <span>{{zaehler}}</span>
        <span @click="inc(zaehler)">></span>
    </div>
    <br>
</div>
    @endverbatim
</script>

<!-- Aufgabe9 -->
<!-- X-Templates -->
<script type="text/x-template" id="impressum-template">
    <div class="demo-tab">
        <h2>Impressum</h2>
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

<script type="text/x-template" id="artikeleingabe">
    <div id="artikeleingabe-id">
        <h2>Artikeleingabe</h2>
        <p id="ausgabe"></p>
    </div>

</script>


</body>
</html>
