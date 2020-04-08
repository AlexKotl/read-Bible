<template lang="html">
    <div>
        <h2>Регистрация пользователя</h2>
        <h3>{{ message }}</h3>
        <form @submit.prevent="submit">
            <input type="text" v-model="name" placeholder="Имя">
            <input type="email" v-model="email" placeholder="Email" required>
            <input type="password" v-model="password" placeholder="Пароль" required>
            <input type="password" v-model="password_confirm" placeholder="Пароль еще раз" required>
            <input type="submit" value="Регистрация" class="button">
        </form>
    </div>
</template>

<script>
import { mapMutations, mapActions } from "vuex";
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirm: '',
            message: '',
        }
    },
    methods: {
        ...mapMutations(["setUser"]),
        ...mapActions(["fetchChapters"]),
        async submit() {
            // form validation
            this.message = '';
            if (this.email == '') {
                this.message = 'Email не может быть пустым';
            }
            if (this.password !== this.password_confirm) {
                this.message = 'Пароли не совпадают';
            }

            const res = await fetch(process.env.API_URL + "/?action=register", {
                method: "POST",
                body: JSON.stringify({
                    name: this.name,
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
