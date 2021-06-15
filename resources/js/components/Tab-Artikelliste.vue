<template>
    <div>
        <h2>Alle Artikel</h2>
        <table>
        <th>ID</th><th>Name</th><th>Preis</th><th>Beschreibung</th><th>Erstellungsdatum</th>
        <tr v-for="item in allarticles">
            <td class="td-id">{{item.id}}</td> <td class="td-name">{{item.ab_name}}</td><td class="td-preis">{{ item.ab_price }}€</td>
            <td class="td-beschreibung">{{ item.ab_description }}</td><td class="td-erstellung">{{ item.ab_createdate }}</td>
        </tr>
        </table>
        <div>
            <span @click="dec(zaehler)" class="counter"><</span>
            <span id="zaehler">{{zaehler}}</span>
            <span @click="inc(zaehler)" class="counter">></span>
        </div>

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
            this.$isLoading(true)
            axios
                .get("/api/articles/?search=&limit=" + this.limit + "&offset=" + this.offset)
                .then(response => {

                    this.allarticles = response.data
                })
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

<style lang="scss" scoped>
@mixin border($property){
    border: 1px solid $property;
}

table{
    width: 1000px;
    margin-bottom: 20px;
    height: 250px;
    box-shadow: 2px 2px;
}
table, td, th{
    @include border(black);
    border-collapse: collapse;
    padding-left: 5px;
}
table{
    th{
        text-align: left;
        height: 25px;
    }
    .td-id, .td-preis{
        width: 20px;
    }
    .td-name{
        width: 20%;
    }
    .td-beschreibung{
        width: 55%;
    }
    .td-erstellung{
        width: 100% / 4;
    }
}

#zaehler, .counter{
    font-size: 20px;
}
.counter{
    cursor: pointer;
}
</style>
