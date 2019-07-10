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
    </div>
  </div>
</template>

<script>
import Login from './Login.vue'

export default {
  components: {
    Login
  },

  data(){
    return {
      show: false
    }
  },

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
</style>
