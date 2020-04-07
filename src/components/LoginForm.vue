<template>
    <div>
        <h1>Вход</h1>
        <h3>{{ message }}</h3>
        <form @submit.prevent="submit">
            <input type="text" v-model="email" value="" placeholder="Логин">
            <input type="password" v-model="password" value="" placeholder="Пароль">
            <input type="submit" name="" value="Вход" class="button">
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
            const res = await fetch("http://bible-api/?action=auth", {
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
                localStorage.user_name = user.user_name;
                localStorage.user_email = user.user_email;

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