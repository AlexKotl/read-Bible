<template>
  <LoadingButton
    class="button google-login"
    @click.native="googleLogin"
    :loading="isLoading"
  >
    <img :src="require('./../assets/google.png')" width="28" height="28" />
    {{ title }}
  </LoadingButton>
</template>

<script>
import { mapMutations, mapActions } from "vuex";
import LoadingButton from "./elements/LoadingButton";

export default {
  props: {
    title: {
      default: "Login with Google",
    },
  },
  components: { LoadingButton },
  data() {
    return {
      isLoading: false,
    };
  },
  methods: {
    ...mapMutations(["setUser"]),
    ...mapActions(["fetchChapters"]),
    async authUser(user) {
      if (user.error !== undefined) {
        alert(user.error);
      } else {
        localStorage.session_id = user.session_id;

        this.setUser(user);

        await this.fetchChapters();
        this.$router.push({ name: "chapters" });
      }
    },
    async googleLogin() {
      this.isLoading = true;

      const code = await this.$gAuth.getAuthCode();
      const res = await fetch(process.env.API_URL + "/?action=auth", {
        method: "POST",
        body: JSON.stringify({
          code: code,
        }),
      });
      const user = await res.json();
      await this.authUser(user);

      this.isLoading = false;
    },
  },
};
</script>

<style scoped>
.google-login {
  display: block;
  margin: 20px auto;
  padding: 10px;
  width: 100%;

  img {
    vertical-align: middle;
    margin-right: 10px;
  }
}
</style>
