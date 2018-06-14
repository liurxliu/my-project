<template>
  <modal name="login" transition="pop-out" :width="modalWidth" :height="400">
    <div class="login-form">
      <div class="login">
        <h1 class="title">Create Account</h1>
        <div class="social-login">
          <button class="loginBtn loginBtn--facebook" @click="facebook">
            Login with Facebook
          </button>
          <button class="loginBtn loginBtn--google" @click="google">
            Login with Google
          </button>
          <button class="loginBtn loginBtn--github" @click="github">
            Login with Github
          </button>
        </div>
      </div>
      <div class="login-part">
      </div>
    </div>
  </modal>
</template>
<script>
const MODAL_WIDTH = 656
export default {
  props: ['active'],
  data () {
    return {
      modalWidth: MODAL_WIDTH
    }
  },
  created () {
    this.modalWidth = window.innerWidth < MODAL_WIDTH
      ? MODAL_WIDTH / 2
      : MODAL_WIDTH
  },
  methods: {
    show() {
      this.$modal.show('login');
    },
    hide() {
      this.$modal.hide('login');
    },
    facebook() {
      window.location.replace('/login/facebook');
    },

    google() {
      window.location.replace('/login/google');
    },

    github() {
      window.location.replace('/login/github');
    }
  },
}
</script>
<style>

</style>