<template>
    <div>
        <h1>Вход</h1>
        <h3>{{ message }}</h3>
        <form @submit.prevent="submit" v-if="!is_auth">
            <input type="text" v-model="email" value="" placeholder="Логин">
            <input type="password" v-model="password" value="" placeholder="Пароль">
            <input type="submit" name="" value="Вход" class="button">
        </form>
        <div v-else>
            Вход выполнен
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            message: "",
            email: "",
            password: "",
            is_auth: false
        }
    },
    methods: {
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
                this.is_auth = true;
            }
        }
    }
}
</script>

<style lang="scss">
input[type=text], input[type=password] {
    width: 100%;
    font-size: 1em;
    line-height: 2em;
    margin-bottom: 7px;
    border-radius: 3px;
    border: 1px solid #c7c7c7;
}
h3 {
    color: red;
}
</style>