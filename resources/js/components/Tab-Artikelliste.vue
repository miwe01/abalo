<template>
    <div>
        <h2>Alle Artikel</h2>
        <table>
        <th>ID</th><th>Name</th><th>Preis</th><th>Beschreibung</th><th>Erstellungsdatum</th>
        <tr v-for="item in allarticles">
            <td class="td-id">{{item.id}}</td> <td class="td-name">{{item.ab_name}}</td><td class="td-preis">{{ item.ab_price }}€</td>
            <td class="td-beschreibung">{{ item.ab_description }}</td>
            <td class="td-erstellung">{{ item.ab_createdate }}</td>
            <!-- if benutzer angemeldet und artikel seiner -->
<!--            <td v-bind:id="item.id" style="display: none" v-if="angemeldeterBenutzer(item.ab_creator_id)"><button @click="">Artikel jetzt als Angebot anbieten</button></td>-->
            <td v-if="hisArticle == item.ab_creator_id">
                <button @click="angebotSenden(item.ab_name, item.ab_creator_id)">Artikel jetzt als Angebot anbieten</button>
            </td>

            <template v-if="checkAngebot(item.ab_name)"></template>
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
var socket = new WebSocket('ws://localhost:8000/demo');
export default {
    name: "Tab-Artikelliste",
    data: function () {
        return {
            allarticles: "", hisArticle: "", zaehler: 0, offset: 0, limit: 5
        }
    },
    // Aufgabe12
    methods: {
        addEvent: function () {
            this.$isLoading(true)
            axios
                .get("/api/articles/?search=&limit=" + this.limit + "&offset=" + this.offset)
                .then(response => {
                    this.$isLoading(false)
                    this.allarticles = response.data
                    console.log(this.allarticles);
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
        },
        angebotSenden: function(artikelname, verkaueferid){
            let object = {
                action: 'echo',
                data: '{"id":4, "message":"' + artikelname + '", "seller":' + verkaueferid + '}'
            }
            socket.send(JSON.stringify(object))

        },
        checkAngebot: function(itemname){

        },
        // gibt Array von Artikeln zurück die gerade angezeigt werden
        getallArticles: function(){
            let artikelNamen =[];
            var outputData = this.allarticles.map( Object.values );
            for (let i=0; i<outputData.length;i++){
                for (let j=0; j<outputData[i].length;j++){
                    if (j === 1){
                        artikelNamen[artikelNamen.length] = outputData[i][j];
                    }
                }

            }
            return artikelNamen;
        }

    },
    computed:{

    },
    created: function () {
        // soll nur auf Angebot hören M5 A10
        // var socket = new WebSocket('ws://localhost:8000/demo');
        let vm = this;
        socket.onmessage = function(event) {
            var jsonObject = JSON.parse(event.data);
            var json = JSON.parse(jsonObject.data);
            console.log(json);

            // Wenn Angebot Naricht reinkommt
            if (json.id === 4){
                var seller = json.seller;
                // checkt wenn gleicher Verkäufer ist wenn ja bekommt er nicht die Angebot Meldung
                axios
                    .get("/checkAktuellenBenutzer?id=" + seller)
                    .then(response => {
                        console.log("Response " + response.data);
                        if (response.data === 1)
                        {
                            if(vm.getallArticles().includes(json.message)){
                                alert("Der Artikel " + json.message + " wird nun günstiger angeboten! Greifen Sie schnell zu.“");
                            }
                        }
                    })
                    .catch(error => console.log(error))

                // Angebotener Artikel ist momentan in angezeigter Artikelliste

                // let a = setTimeout(vm.getallArticles(),1000);
                // console.log("check + " + a);

            }

        }
        //this.hisArticle = 7;
        axios
            .get("/eingeloggterBenutzer")
            .then(response => {
                this.hisArticle = response.data
                this.addEvent();
            })
            .catch(error => console.log(error))

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
