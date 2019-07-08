<template>
  <div class="home">
    <img alt="OMT logo" src="../assets/unnamed.jpg">
    <StartPage msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
// @ is an alias to /src
import StartPage from '@/components/StartPage.vue'

export default {
  name: 'home',
  components: {
    StartPage
  }
}
</script>
