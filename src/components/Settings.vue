<template>
    <div id="settings-window">
        <h2>Настройки</h2>
        Язык:
        <a @click="setLang('ua')" :class="{ 'selected': getLang() == 'ua'}" class="option">🇺🇦</a>
        <a @click="setLang('ru')" :class="{ 'selected': getLang() == 'ru'}" class="option">🇷🇺</a>
        <a @click="setLang('en')" :class="{ 'selected': getLang() == 'en'}" class="option">🇺🇸</a>
        <br/>
        Тема:
        Светлая / Темная
        <br><br>
        <a class="button">Закрыть</a>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex';

export default {
    data() {
        return {

        }
    },
    methods: {
        ...mapGetters(["getLang", "getFontSize"]),
        ...mapMutations(["updateLang"]),
        setLang: function(lang) {
            console.log('Setting', lang)
            this.updateLang(lang);
        }
    }
}
</script>

<style lang="scss" scoped>
#settings-window {
    position: absolute;
    background-color: white;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 2px 4px #c3c3c3;
    padding: 15px;
    border-radius: 5px;

    .option {
        border: 2px solid transparent;
        border-radius: 5px;
        display: inline-block;
        padding: 2px 7px;
    }

    .selected {
        border: 2px solid #42b983;
    }
}
</style>
