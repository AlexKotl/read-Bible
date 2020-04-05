<template>
    <div>
        <h2>Оглавление</h2>
        <router-link
            v-for="chapter in chapters"
            :key="chapter"
            active-class="is-active"
            class="link"
            :to="{ name: 'chapter', params: { id: chapter } }">
            {{chapter}}, 
        </router-link>
    </div>
</template>

<script>
export default {
    data() {
        return {
            chapters: ['1', '2', 'Three']
        }
    }
}
</script>

<style lang="scss">

</style>