<template>
    <div>
        <button v-on:click="$root.currentTab = 'impressum'">Zum Impressum</button>
    </div>
</template>

<script>
export default {

name: "Site-Footer"
}
</script>

<style scoped>
button{
    margin-left: 210px;
    margin-top: 10px;

}
</style>
