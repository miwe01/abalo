<template>
    <div id="filter-div">
        <h2>Artikelsuche</h2>
        <p>Einfach Suchbegriff eingeben:</p>
        <p>{{message}}</p>
        Artikel suchen:<input id="filter" type="text" @input="addEvent" autofocus>

        <div id="gefundeneArtikel">
        <ul v-for="item in articles" >
            <li> ID: {{item.id}} Name: {{item.ab_name}}</li>
        </ul>
        </div>
    </div>
</template>

<script>
export default {
name: "Tab-Artikelsuche",
    data: function(){
        return{
            message: '', articles: '', zaehler: 0, offset: 0, limit: 5
        }
    },
    template: `#filtersuche`,
    methods: {
        addEvent: function () {
            let l = document.getElementById('filter').value;
            if (l.length >= 3)
                this.sendAjax(l);
            if (l.length === 0)
                this.articles = "";
        },
        sendAjax(text) {
            let s = text;
            axios
                .get("/api/articles/?search=" + s + "&limit=" + this.limit + "&offset=" + this.offset)
                .then(response => (this.articles = response.data))
                .catch(error => console.log(error))
        }
    }
}
</script>

<style scoped>
#gefundeneArtikel{
    margin-top: 15px;
}
</style>
