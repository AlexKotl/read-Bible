<template lang="html">
    <div>
        <h2>{{ $t("RegisterUser") }}</h2>
        <h3>{{ message }}</h3>

        <LoginGoogle :title="$t('RegisterWithGoogle')" />
        <div class="delimiter"> - {{ $t("or") }} - </div>
        <form @submit.prevent="submit">
            <input type="text" v-model="name" :placeholder="$t('Name')">
            <input type="email" v-model="email" :placeholder="$t('Email')" required>
            <input type="password" v-model="password" :placeholder="$t('Password')" required>
            <input type="password" v-model="password_confirm" :placeholder="$t('PasswordOneMore')" required>
            <input type="submit" :value="$t('Register')" class="button">
        </form>
    </div>
</template>

<script>
import { mapMutations, mapActions } from "vuex";
import LoginGoogle from "./LoginGoogle";

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
    components: { LoginGoogle },
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
