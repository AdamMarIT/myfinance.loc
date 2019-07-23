<template>
<div class="forgot">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4 form">
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
</template>

<script>
  export default {

    data() {
      return {
        email: '',
        error: false,
      }
    },
   
    methods: {
      async onSubmit() {
      	let response = await this.$request.post('/api/reset-password', {
         	email: this.email,
        })
      
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
.error {
	color: red;
}

</style>