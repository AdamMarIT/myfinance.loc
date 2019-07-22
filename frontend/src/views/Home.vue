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
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-4 form" v-if="forgot">
            <b-form>
              <p v-if="error" class="error">
                Invalid email entered
                </p>
              <b-form-group id="input-group-1" label-for="input-1">
                <b-form-input
                  id="input-1"
                  v-model="email"
                  type="email"
                  required
                  placeholder="Enter your email for reset password"
                  @keyup.enter="onSubmit"
                ></b-form-input>
              </b-form-group>
              <b-button @click="onSubmit">Submit</b-button>
            </b-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Login from '@/components/Login.vue'

export default {
  components: {
    Login
  },
  
  data(){
    return {
      show: false,
      forgot: false,
      email: '',
      error: false
    }
  },

  methods: {
    fogotPassword() {
      this.show = false;
      this.forgot = true;
    },

    async onSubmit() {
        let response = await this.$request.post('/api/forgot', {
          email: this.email,
        })
             .then( response=> {
                console.log(response)
              })
    }

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


