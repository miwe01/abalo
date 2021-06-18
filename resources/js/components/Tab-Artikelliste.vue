<template>
    <div>
        <h2>Alle Artikel</h2>
        <table id="ArtikelListe">
            <th class="ArtikelListe__th">ID</th>
            <th class="ArtikelListe__th">Name</th>
            <th class="ArtikelListe__th">Preis</th>
            <th class="ArtikelListe__th">Beschreibung</th>
            <th class="ArtikelListe__th">Erstellungsdatum</th>
            <th class="ArtikelListe__th"></th>

            <tr v-for="item in allarticles" class="ArtikelListe__tr">

            <td class="ArtikelListe__td--id-width ArtikelListe__td">{{item.id}}</td>
            <td class="ArtikelListe__td--name-width ArtikelListe__td">{{item.ab_name}}</td>
            <td class="ArtikelListe__td--price-width ArtikelListe__td">{{ item.ab_price }}€</td>
            <td class="ArtikelListe__td--desc-width ArtikelListe__td">{{ item.ab_description }}</td>
            <td class="ArtikelListe__td--create-width ArtikelListe__td">{{ item.ab_createdate }}</td>


            <!-- M5 Aufgabe 10 -->
            <td v-if="hisArticle == item.ab_creator_id" class="ArtikelListe__tr">
                <button @click="angebotSenden(item.ab_name, item.ab_creator_id)">Artikel jetzt als Angebot anbieten</button>
            </td>
        </tr>
        </table>

        <!-- M5 Aufgabe 9-->
        <div>
        <select v-model="select">
            <option disabled value="">Artikel auswählen</option>
            <template v-for="item in allarticles">
                <option v-if="hisArticle === item.ab_creator_id"  v-bind:value="{id: item.id}">{{item.ab_name}}</option>
            </template>
        </select>
        <button @click="verkaufeArtikel(select.id)">Artikel verkaufen</button>
        </div>


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
            allarticles: "", hisArticle: "", select: "", zaehler: 0, offset: 0, limit: 5
        }
    },
    // M4 Aufgabe12
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
        // M5 Aufgabe 9
        // sende an Post Api mit Artikel ID
        verkaufeArtikel: function(id){
            if (id === undefined)
                return;
            axios
                .post("/articles/" + id + "/sold")
                .then(response => {
                    console.log("Response " + response.data);
                })
                .catch(error => console.log(error))
        },

        // M5 Aufgabe 10
        // Angebot senden
        angebotSenden: function(artikelname, verkaueferid){
            let object = {
                action: 'echo',
                data: '{"id":4, "artikelname":"' + artikelname + '", "seller":' + verkaueferid + '}'
            }
            socket.send(JSON.stringify(object))

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
        filterAricle: function () {
            return this.articles.filter(i => i.col === 'one')
        },

    },
    created: function () {
        // M5 A10
        // ueberprueft ob Angebot gesendet wurde und ob User Naricht angezeigt bekommen soll
        let vm = this;
        var socket = new WebSocket('ws://localhost:8000/demo');
        socket.onmessage = function(event) {
            var jsonObject = JSON.parse(event.data);
            var json = JSON.parse(jsonObject.data);

            // Wenn Angebot Naricht reinkommt
            if (json.id === 4){
                var seller = json.seller;
                // checkt wenn nicht Artikelverkäufer = Eingeloggter User ist
                axios
                    .get("/checkAktuellenBenutzer?id=" + seller)
                    .then(response => {
                        console.log("Response " + response.data);
                        if (response.data === 1)
                        {
                            // Wenn Artikel auf aktueller Seite ist
                            // getallArticles nimmt this.allArticles(Objekt von Objekten) und ändert um in Array von Arrays
                            if(vm.getallArticles().includes(json.artikelname)){
                                alert("Der Artikel " + json.artikelname + " wird nun günstiger angeboten! Greifen Sie schnell zu.“");
                            }
                        }
                    })
                    .catch(error => console.log(error))
            }

        }
        // bekomme ID von aktuell eingelogtem Benutzer
        axios
            .get("/eingeloggterBenutzer")
            .then(response => {
                // M5 Aufgabe 9
                // HisArticle enthält ID vom Verkäufer
                this.hisArticle = response.data
                console.log(this.hisArticle);
                // Sende Daten an Liste nachdem aktuell eingeloggter Benutzer überprüft wurde
                this.addEvent();
            })
            .catch(error => console.log(error))

    }

}
</script>

<style lang="scss" scoped>
$primary-color: #292525;

@mixin border($property){
    @if($property == ""){
        @error "Farbe fehlt";
    }

    border: 1px solid $property;
}

#ArtikelListe{
    width: 1000px;
    margin-bottom: 20px;
    height: 250px;
    box-shadow: 2px 2px;
}

#ArtikelListe__tr, .ArtikelListe__td, .ArtikelListe__th{
    color: $primary-color;
    @include border(black);
    border-collapse: collapse;
    padding-left: 5px;
}
#ArtikelListe{
    .ArtikelListe__th{
        text-align: left;
        height: 25px;
    }
    .ArtikelListe__td--id-width, .ArtikelListe__td--price-width{
        width: 20px;
    }
    .ArtikelListe__td--name-width{
        width: 20%;
    }
    .ArtikelListe__td--desc-width{
        width: 55%;
    }
    .ArtikelListe__td--create-width{
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
