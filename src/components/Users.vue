<template>
    <div>
        <h2>{{ $t("Users") }}</h2>

        <div class="users-list">
            <div v-for="user in users"
                :key="'id'+user.id"
                class="item">
                <img :src="user.picture" />
                {{ user.name }}
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            users: [],
        }
    },
    methods: {

    },
    async created() {
        const res = await fetch(process.env.API_URL + '/?action=get_users&');
        const data = await res.json();

        this.users = data;
    }
}
</script>

<style lang="scss" scoped>
.users-list {
    display: flex;
    flex-flow: wrap;
}
.item {
    width: 33%;
    text-align:center;
    padding: 20px 6px;

    img {
        width:100%;
        border-radius: 50%;
    }
}
</style>
