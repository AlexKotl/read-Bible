<template>
  <div>
    <div class="stats-placeholder" v-if="!getUser.session_id">
      <div class="greetings-window">
        {{ $t("greetings_guest") }}
        <br />
        <router-link :to="{ name: 'login' }" class="button">{{
          $t("Login")
        }}</router-link>
        <router-link :to="{ name: 'registration' }" class="button">{{
          $t("Registration")
        }}</router-link>
      </div>
      <img
        :src="require('./../assets/stats-placeholder.jpg')"
        class="placeholder"
        alt=""
      />
    </div>
    <StatisticsShort v-else :disabled="!getUser.session_id"></StatisticsShort>

    <h2>{{ $t("Index") }}</h2>
    <div v-for="(chapters, book) in getChapters" :key="book">
      <b>{{ book }}</b>
      <div>
        <router-link
          v-for="chapter in chapters"
          :key="chapter.id"
          :class="{ green: chapter.is_read, button: true }"
          :to="{ name: 'chapter', params: { id: chapter.id } }"
        >
          {{ chapter.number }}
        </router-link>
      </div>
      <br />
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import StatisticsShort from "./StatisticsShort.vue";

export default {
  computed: mapGetters(["getChapters", "getUser"]),
  methods: mapActions(["fetchChapters"]),
  components: { StatisticsShort },
};
</script>

<style scoped>
#app.dark .greetings-window {
  color: black;
}

.stats-placeholder {
  position: relative;

  .placeholder {
    width: 100%;
  }
}
.greetings-window {
  position: absolute;
  background-color: white;
  padding: 15px 10px;
  border: 1px solid #e9ddb9;
  font-size: 15px;
  border-radius: 5px;
  text-align: center;
  margin: 54px 20px 0 20px;
}
</style>
