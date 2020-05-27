<template>
    <div>
        <div class="button-container">
            <a class="button" @click="showWindow = true">
                <img :src="require('../assets/cog.png')" width="26" height="26" style="vertical-align:middle" />
            </a>
        </div>


        <div id="settings-window" :class="{show: showWindow}">
            <h2>{{ $t("Settings") }}</h2>
            {{ $t("Language") }}:<br>
            <a @click="setLang('en')" :class="{ 'selected': getLang() == 'en'}" class="option">
                <img :src="require('../assets/en.png')" width="48" height="48"  />
            </a>
            <a @click="setLang('ua')" :class="{ 'selected': getLang() == 'ua'}" class="option">
                <img :src="require('../assets/ua.png')" width="48" height="48"  />
            </a>
            <a @click="setLang('ru')" :class="{ 'selected': getLang() == 'ru'}" class="option">
                <img :src="require('../assets/ru.png')" width="48" height="48"  />
            </a>
            <br/><br>
            {{ $t("Theme") }}: <br>
            <a @click="updateTheme('light')" :class="{ 'selected': getTheme() == 'light'}" class="option">
                {{ $t("Light") }}
            </a> /
            <a @click="updateTheme('dark')" :class="{ 'selected': getTheme() == 'dark'}" class="option">
                {{ $t("Dark") }}
            </a>
            <br><br>
            <a class="button" @click="showWindow = false" style='padding: 5px 15px'>{{ $t("Close") }}</a>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex';
import i18n from './../i18n';

export default {
    data() {
        return {
            showWindow: false
        }
    },
    methods: {
        ...mapGetters(["getLang", "getFontSize", "getTheme"]),
        ...mapMutations(["updateLang", "updateTheme"]),
        setLang: function(lang) {
            i18n.locale = lang;
            this.updateLang(lang);
        }
    }
}
</script>

<style lang="scss" scoped>
.button-container {
    position: absolute;
    right: 44px;
    a {
        position: fixed;
        padding: 0 10px;
        line-height: 34px;
        margin: -21px 0 0 0;
    }
}

#settings-window {
    position: fixed;
    background-color: white;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 2px 16px #c3c3c3;
    padding: 15px 20px;
    border-radius: 5px;
    transform: translateY(-500px);
    text-align: center;
    transition: all ease-out 0.3s;
    will-change: transform;
    margin-left: -8px;
    z-index: 500;

    &.show {
        transform: translateY(-10px);
        //opacity: 1;
    }

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

#app.dark #settings-window {
    background-color: #4e4e4e;
    box-shadow: 0 2px 16px #222222;
}
</style>
