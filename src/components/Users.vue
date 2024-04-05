<template>
  <div>
    <h2>{{ $t("Users") }} - {{ users.length }}</h2>

    <div class="users-list">
      <div v-for="user in users" :key="'id' + user.id" class="item">
        <img :src="user.picture || require('./../assets/user.png')" /> <br />
        <b>{{ user.name }}</b>
        <div v-if="user.chapters_count > 0" class="user-chapters">
          {{ $t("Chapters") }}: {{ user.chapters_count }}
        </div>
        <div v-if="user.achievements_count > 0" class="user-achievements">
          <img
            :src="require('./../assets/achievements/default.png')"
            class="icon"
          />
          {{ user.achievements_count }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
    };
  },
  methods: {},
  async created() {
    const res = await fetch(process.env.API_URL + "/?action=get_users&");
    const data = await res.json();

    this.users = data;
  },
};
</script>

<style scoped>
.users-list {
  display: flex;
  flex-flow: wrap;
}
.user-chapters {
  font-size: 15px;
  margin-top: 3px;
}
.user-achievements {
  font-size: 15px;
  font-weight: bold;

  .icon {
    vertical-align: middle;
    width: 24px;
  }
}
.item {
  width: 33%;
  text-align: center;
  padding: 20px 6px;

  > img {
    width: 80%;
    border-radius: 50%;
  }
}
</style>
