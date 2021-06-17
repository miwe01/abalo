/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('axios');
window.Vue = require('vue').default;

import loading from 'vuejs-loading-screen'
Vue.use(loading, {
    bg: 'rgb(255, 255, 255, 0.5)',
    icon: 'spinner',
    size: 5,
    icon_color: 'black',
})




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

let tabArtikeleingabe = Vue.component('site-header', require('./components/Tab-ArtikelEingabe.vue').default);
let header = Vue.component('site-header', require('./components/Site-Header.vue').default);
let body = Vue.component('site-body', require('./components/Site-Body.vue').default);
let footer = Vue.component('site-footer', require('./components/Site-Footer.vue').default);
let tabHome = Vue.component('tab-home', require('./components/Tab-Home.vue').default);
let tabArtikelsuche = Vue.component('tab-home', require('./components/Tab-Artikelsuche.vue').default);
let tabArtikelliste = Vue.component('tab-artikelliste', require('./components/Tab-Artikelliste.vue').default);
let tabImpressum = Vue.component('tab-impressum', require('./components/Tab-Impressum.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    /* Aufgabe8 */
    el: "#app",

    data: {
        Impressum: '',
        currentTab: "home",
        tabs: ['home', 'artikelliste', 'artikelsuche', 'artikeleingabe'],
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
    components:{
        'tab-artikeleingabe' : tabArtikeleingabe,
        'site-header': header,
        'site-body': body,
        'site-footer': footer,
        'tab-home': tabHome,
        'tab-artikelsuche': tabArtikelsuche,
        'tab-artikelliste': tabArtikelliste,
        'tab-impressum': tabImpressum,
    },
    mounted: function(){
        // Nachdem auch die ganze Webseite geladen wurde (auch import)
        window.addEventListener('load', () => {
            this.addEventToMenu('li-Kategorien', 'artikelliste');
            this.addEventToMenu('li-Home', 'home');
            this.addEventToMenu('li-Verkaufen', 'artikeleingabe');
            this.addEventToMenu('li-Unternehmen', 'artikelsuche');
        })
    },

});
