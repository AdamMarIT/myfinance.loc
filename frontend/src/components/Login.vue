<template>
<div class="registration">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4 form">
				<b-form>
					<p v-if="errors.length">
				    <ul>
				      <li v-for="error in errors">{{ error }}</li>
				    </ul>
				  </p>
					<b-form-group id="input-group-1" label-for="input-1">
						<b-form-input
							id="input-1"
							v-model="form.email"
							type="email"
							required
							placeholder="Enter your email"
						></b-form-input>
					</b-form-group>
					<b-form-group id="input-password" label-for="password">
						<b-form-input 
							id="password" 
							v-model="form.password" 
							type="password"
							required placeholder="Enter your password">
						</b-form-input>
					</b-form-group>
					<b-button @click="onSubmit">Submit</b-button>
				</b-form>
			</div>
		</div>
	</div>
</div>
</template>

<script>
  export default {

    data() {
      return {
        form: {
          email: '',
          password: '',
        },
        errors: [],
       
       
      }
    },
   
    methods: {
      async onSubmit() {
      	let response = await this.$request.post('/api/login', {
         	email: this.form.email,
         	password: this.form.password
        })
        let token = response.access_token;
	        if (token) {
						this.$store.commit('setAccessToken', token)
						this.$router.push("dashboard") 
					}
      	},
			
		}
}

</script>

<style scoped>

.form {
	margin: 15px 0 0;
}
button {
	margin: 0 10px;
}
ul {
	list-style-type: none;
	text-align: left;
	color: red;
}

</style>