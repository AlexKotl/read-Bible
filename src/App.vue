<template>
    <div id="app" :class="{dark: getTheme === 'dark'}">
        <div class="container">
            <div class="menu-actions">
                <Settings class="show"></Settings>

                <div v-if="getUser.session_id">
                    {{ $t('Hello') }} {{ getUser.user_name }},
                    <a @click="logout" href="#">{{ $t('Logout') }}</a>
                </div>
                <div v-else>
                    <router-link :to="{ name: 'login' }">{{ $t('Login') }}</router-link>
                    <router-link :to="{ name: 'registration' }" style="margin-left:10px">{{ $t('Registration') }}</router-link>
                </div>
            </div>

            <router-link :to="{ name: 'chapters' }">
                <h1>{{ $t('Bible') }}</h1>
            </router-link>

            <div class="content">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import Settings from "./components/Settings.vue";

export default {
    name: 'app',
    computed: mapGetters(["getUser", "getTheme"]),
    components: { Settings },
    data() {
        return {
        }
    },
    methods: {
        ...mapMutations(['setUser']),
        ...mapActions(["fetchChapters"]),
        logout() {
            delete localStorage.session_id;
            this.setUser({});
            this.fetchChapters();
        },
        showSettings() {

        }
    },
    async mounted() {
        // auth user
        if (localStorage.session_id !== undefined) {
            const res = await fetch(process.env.API_URL + '/?action=verify_session&session_id=' + localStorage.session_id);
            const data = await res.json();
            if (data.user_name !== undefined) {
                this.setUser({
                    session_id: localStorage.session_id,
                    user_name: data.user_name,
                    user_email: data.user_email
                });
            }
        }

        // load chapters to store
        this.fetchChapters();
    }
}
</script>

<style lang="scss">
#app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    font-size: 18px;

    .container {
        margin: auto;
        padding: 20px 10px 150px 10px;
        max-width: 500px;
    }

    &.dark {
        background-color: #333;
        color: white;

        h1, h2 {
            color: #949ea9;
        }
    }


}

h1, h2 {
    text-align: center;
    color: #2c3e50;
    text-decoration: none;
}

.button {
    background-color: #ebebeb;
    box-shadow: 0px 3px 0 #c2c2c2;
    color: black;
    text-decoration: none;
    border-radius: 5px;
    margin: 4px 3px;
    padding: 4px 7px;
    font-weight: bold;
    font-size: 16px;
    min-width: 20px;
    text-align: center;
    display: inline-block;

    &:hover {
        background-color: #f2f1f1;
    }

    &.green {
        background-color: #69ba89;
        box-shadow: 0px 3px 0 #488f64;
        color: white;

        &:hover {
            background-color: #85c8a0;
        }
    }

    &.disabled {
        color: #b6b6b6;
    }

}

a {
    color: #51946c;
    cursor: pointer;
}

div, form {
    box-sizing: border-box;
}

form {
    input[type=text], input[type=password], input[type=email] {
        width: 100%;
        font-size: 1em;
        line-height: 2em;
        margin-bottom: 7px;
        border-radius: 3px;
        border: 1px solid #c7c7c7;
        box-sizing: border-box;
    }
    .button {
        padding: 10px 20px;
    }
}

</style>
