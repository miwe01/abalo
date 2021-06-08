<template>
    <div>
        <h2>Alle Artikel</h2>
        <th>ID</th><th>Name</th><th>Preis</th><th>Beschreibung</th><th>Erstellungsdatum</th>
        <tr v-for="item in allarticles">
            <td>{{item.id}}</td> <td>{{item.ab_name}}</td><td>{{ item.ab_price }}€</td>
            <td>{{ item.ab_description }}</td><td>{{ item.ab_createdate }}</td>
        </tr>
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
    name: "Tab-Artikelliste",
    data: function () {
        return {
            allarticles: "", zaehler: 0, offset: 0, limit: 5
        }
    },
    // Aufgabe12
    methods: {
        addEvent: function () {
            axios
                .get("/api/articles/?search=&limit=" + this.limit + "&offset=" + this.offset)
                .then(response => (this.allarticles = response.data))
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
    },
    mounted: function () {
        this.addEvent();
    }

}
</script>

<style scoped>

</style>
