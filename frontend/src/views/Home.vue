<template>
  <div class="start">
    <img alt="OMT logo" src="../assets/unnamed.jpg">
    <h1>Your own money and taxes</h1>
    <p>
      There is something easy you can do about it.
    </p>
     <div id="nav">
      <b-button v-on:click="show = true">Login</b-button> 
      <router-link to="/registration"><b-button>Registration</b-button></router-link>
      <Login v-if="show"></Login> 
      <b-button v-if="show" variant="link" @click="fogotPassword">oh?</b-button>
      <ForgotPassword v-if="forgot"></ForgotPassword>
    </div>
  </div>
</template>

<script>
import Login from '@/components/Login.vue'
import ForgotPassword from '@/components/ForgotPassword.vue'

export default {
  components: {
    Login,
    ForgotPassword
  },
  
  data(){
    return {
      show: false,
      forgot: false,
    }
  },

  methods: {
    fogotPassword() {
      this.show = false;
      this.forgot = true;
    },
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.start {
  margin: 60px 0 0;
}
h1 {
  margin: 40px 0 0;
}
button {
  margin: 0 10px;
}

.form {
  margin: 15px 0 0;
}

.error {
  color: red;
}
</style>


