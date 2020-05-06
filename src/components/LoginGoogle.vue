<template>
    <a class="button google-login" @click="googleLogin">
        <img :src="require('./../assets/google.png')" width="28" height="28" />
        {{ title }}
    </a>
</template>

<script>
import { mapMutations, mapActions } from 'vuex';

export default {
    props: {
        title: {
            default: "Login with Google"
        }
    },
    methods: {
        ...mapMutations(["setUser"]),
        ...mapActions(["fetchChapters"]),
        async authUser(user) {
            if (user.error !== undefined) {
                alert(user.error);
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
                const user = await res.json();
                this.authUser(user);
            }

        }
    }
}
</script>

<style lang="scss" scoped>
.google-login {
    display: block;
    margin: 20px auto;
    padding: 10px;

    img {
        vertical-align: middle;
        margin-right: 10px;
    }
}
</style>