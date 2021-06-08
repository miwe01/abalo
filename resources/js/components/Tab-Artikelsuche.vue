<template>
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
            else {
                this.zaehler = 0
                this.offset = 0
                this.articles = ""
            }
            if (l.length === 0)
                this.articles = "";
        },
        sendAjax(text) {
            let s = text;
            axios
                .get("/api/articles/?search=" + s + "&limit=" + this.limit + "&offset=" + this.offset)
                .then(response => (this.articles = response.data))
                .catch(error => console.log(error))
        },
        // seitenanzahl ändern
        inc: function (z) {
            if (z < 10) {
                this.zaehler += 1;
                this.offset += this.limit;
                this.addEvent();
            }
        },
        dec: function (z) {
            if (z > 0) {
                this.zaehler -= 1;
                this.offset -= this.limit;
                this.addEvent();
            }
        }
    }
}
</script>

<style scoped>

</style>
