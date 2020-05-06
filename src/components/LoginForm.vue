<template>
    <div>
        <h1>{{ $t("Enter") }}</h1>
        <h3>{{ message }}</h3>
        <a class="button google-login" @click="googleLogin">
            <img :src="require('./../assets/google.png')" width="28" height="28" />
            {{ $t("Login with Google") }}
        </a>
        <div class="delimiter"> - {{ $t("or") }} - </div>
        <form @submit.prevent="submit">
            <input type="text" v-model="email" value="" :placeholder="$t('Login')" />
            <input type="password" v-model="password" value="" :placeholder="$t('Password')" />
            <input type="submit" name="" :value="$t('Enter')" class="button" />
        </form>
    </div>

</template>

<script>
import { mapMutations, mapActions } from "vuex";

export default {
    data() {
        return {
            message: "",
            email: "",
            password: "",
        }
    },
    methods: {
        ...mapMutations(["setUser"]),
        ...mapActions(["fetchChapters"]),
        async submit() {
            const res = await fetch(process.env.API_URL + "/?action=auth", {
                method: "POST",
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                })
            });
            const user = await res.json();

            if (user.error !== undefined) {
                this.message = user.error;
            }
            else {
                localStorage.session_id = user.session_id;

                this.setUser(user);

                await this.fetchChapters();
                this.$router.push({ name: 'chapters'});
            }
        },

        async googleLogin() {
            const googleUser = await this.$gAuth.signIn();
            if (this.$gAuth.isAuthorized) {
                const code = await this.$gAuth.getAuthCode();
                const res = await fetch(process.env.API_URL + "/?action=auth", {
                    method: "POST",
                    body: JSON.stringify({
                        code: code
                    })
                });
                console.log('auth res',await res.json());
            }

        }
    }
}
</script>

<style lang="scss" scoped>

h3 {
    color: red;
}

.google-login {
    display: block;
    margin: 20px auto;
    padding: 10px;

    img {
        vertical-align: middle;
        margin-right: 10px;
    }
}
.delimiter {
    text-align:center;
    margin-bottom: 20px;
}
</style>