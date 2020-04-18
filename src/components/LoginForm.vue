<template>
    <div>
        <h1>{{ $t("Enter") }}</h1>
        <h3>{{ message }}</h3>
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
        }
    }
}
</script>

<style lang="scss" scoped>

h3 {
    color: red;
}
</style>