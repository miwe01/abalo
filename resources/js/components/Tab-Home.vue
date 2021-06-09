<template>
    <div>
        <h2>Willkommen bei Abalo</h2>
        <p>Shoppen sie jetzt bei ihrem Online Shop, nur die hochwertigsten Produkte bieten wir ihnen an.</p>
        <p>Wählen Sie eins von beiden aus:</p>
        <button v-on:click="$root.currentTab = 'artikelliste'">Zu allen Artikeln</button>
        <button v-on:click="$root.currentTab = 'artikelsuche'">Nach Artikel suchen</button>

        <p id="artikeleingabe-kunde">Sind Sie bereits Kunde bei Abalo und möchten einen Artikel verkaufen?</p>
        <button v-on:click="$root.currentTab = 'artikeleingabe'">Artikel eintragen</button>
    </div>
</template>

<script>
export default {
name: "Tab-Home"
}
</script>

<style scoped lang="scss">
@import "resources/sass/variables";

#artikeleingabe-kunde{
    margin-top: 40px;
}

</style>
