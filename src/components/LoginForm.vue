<template>
    <div>
        <h1>{{ $t("Enter") }}</h1>
        <h3>{{ message }}</h3>
        <LoginGoogle :title="$t('LoginWithGoogle')" />
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
import LoginGoogle from "./LoginGoogle";

export default {
    data() {
        return {
            message: "",
            email: "",
            password: "",
        }
    },
    components: { LoginGoogle },
    methods: {
        ...mapMutations(["setUser"]),
        ...mapActions(["fetchChapters"]),
        async authUser(user) {
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
        async submit() {
            const res = await fetch(process.env.API_URL + "/?action=auth", {
                method: "POST",
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                })
            });
            const user = await res.json();
            this.authUser(user);
        },

    }
}
</script>

<style lang="scss" scoped>

h3 {
    color: red;
}

.delimiter {
    text-align:center;
    margin-bottom: 20px;
}
</style>