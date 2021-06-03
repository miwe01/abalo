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
    <button
        v-for="tab in tabs"
        v-bind:key="tab"
        v-bind:class="['tab-button', { active: currentTab === tab }]"
        v-on:click="currentTab = tab"
    >
        @{{ tab }}
    </button>

    <site-body v-bind:is="currentTabComponent" class="tab"></site-body>
    <site-footer>
    </site-footer>
</div>



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

<script>
    Vue.component('myMenu', {
            render(h) {
                return h('nav', {
                    'id': {
                        'menu': "hallo"
                    }
                })
            }
    })

    Vue.component('tab-home', {
        template: `<div class="demo-tab">Willkommen bei Abalo</div>`
    })

    Vue.component('tab-artikelsuche', {
        data: function(){
           return{
               message: '',
               articles: '',
               zaehler: 0,
               offset: 0,
               limit: 2
           }

        },
        template: `<div id="filter-div">
            <p>@{{message}}</p>
                Artikel suchen:<input id="filter" type="text" @input="addEvent"><br>

                <ul v-for="item in articles">
                    <li> ID: @{{item.id}} Name: @{{item.ab_name}}</li>
                </ul>

                <div>
                    <span @click="dec(zaehler)"><</span>
                    <span>@{{zaehler}}</span>
                    <span @click="inc(zaehler)">></span>
                  </div>
                </div>`,
        methods:{
            addEvent: function(event)
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
            inc: function(z){
                if (z < 10){
                    this.zaehler += 1;
                    this.offset += this.limit
                    this.addEvent();
                }

            },
            dec: function(z){
                if (z > 0){
                    this.zaehler -= 1;
                    this.offset -= this.limit
                    this.addEvent();
                }

            }
        }
    })
    Vue.component('tab-artikelliste', {
        template: `
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

        </table>`
    })
    Vue.component('tab-impressum', {
        template: '#checkbox-template'
    })


    Vue.component('site-header', {
        template: `<h1>Abalo</h1>
`
    });
    Vue.component('site-body', {
        template: ``
    });


    Vue.component('site-footer', {
        template: `
            <button
                v-on:click="$root.currentTab = 'Impressum'"
            >Impressum</button>
            `
    });

    new Vue({
        el: "#app",
        data: {
            Impressum: '',
            currentTab: "Home",
            tabs: ['Home', 'Artikelliste', 'Artikelsuche']
        },
        computed: {
            currentTabComponent: function() {
                return "tab-" + this.currentTab.toLowerCase();
            }
        }
    });
</script>



</body>
</html>
