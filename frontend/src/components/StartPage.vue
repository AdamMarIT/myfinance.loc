<template>
  <div class="start">
    <h1>Your own money and taxes</h1>
    <p>
      There is something easy you can do about it.
    </p>
     <div id="nav">
      <router-link to="/login"><b-button>Login</b-button></router-link> 
      <router-link to="/registration"><b-button>Registration</b-button></router-link>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1 {
  margin: 40px 0 0;
}
button {
  margin: 0 10px;
}
</style>
