<template>
    <div>
    <h1>Artikeleingabe</h1>
        <p>Bitte geben sie einen Artikel ein:</p>
    <form action="" method="post">
        <table>
            <tr>
                <td>
                    <label for="artikelname">Name: </label>
                </td>
                <td>
                    <input type="text" id="artikelname" name="artikelname">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="artikelname">Preis: </label>
                </td>
                <td>
                    <input type="number" id="artikelpreis" name="artikelpreis">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="artikelbeschreibung">Beschreibung: </label>
                </td>
                <td>
                    <input type="text" id="artikelbeschreibung" name="artikelbeschreibung">
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <!--<button type="submit" name="artikelsubmit">Senden</button>-->
                    <button v-on:click="check()">Senden</button>
                </td>
            </tr>
        </table>

    </form>
        <div id="response"></div>

    </div>
</template>

<script>


export default{
    data() {
        return {
            message: 'a'
        }
    },
    methods:{
        // checkt alle Eingaben von Form
        check : function(){
            event.preventDefault();
            let a = [];
            let i;

            a.push(this.errorBorder('artikelname'));
            a.push(this.errorBorder('artikelpreis'));
            a.push(this.errorBorder('artikelbeschreibung'));

            for (i=0;i<a.length;i++){
                if (a[i] === true)
                    return;
            }

            this.sendData(this.getValue('artikelname'), this.getValue('artikelpreis'), this.getValue('artikelbeschreibung'));
        },
        // setzt Roten Rand um Element falls leer
        errorBorder: function(id){
            if (this.getValue(id) === ""){
                document.getElementById(id).style.border = "1px solid red";
                return true;
            }
            document.getElementById(id).style.border = "1px solid black";
            return false;
        },
        getValue: function(id){
            return document.getElementById(id).value;
        },
        sendData(name, price, description){
            axios
                .post("/api/articles/",{
                    name: name,
                    price: price,
                    description: description
                })
                .then(response => (document.getElementById('response').innerHTML= "Produkt wurde hinzugefügt"))
                .catch(error => console.log(error))
        }
    }
};
</script>

<style scoped>
input{
    border: 1px solid black;
}
</style>
