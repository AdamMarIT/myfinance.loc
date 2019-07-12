<template>
<div class="registration">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<img alt="OMT logo" src="../assets/unnamed.jpg">
				<h3>Registration</h3>
			    <p>
						register the use of the resource
			    </p>
			</div>
			<div class="col-md-4 form">
				<b-form @submit="onSubmit" @reset="onReset" v-if="show">
					<p v-if="errors.length">
				    <ul>
				      <li v-for="error in errors">{{ error }}</li>
				    </ul>
				  </p>
					<b-form-group id="input-group-2" label="Your Name:" label-for="input-2">
						<b-form-input id="input-2" v-model="form.name" required placeholder="Enter name">
						</b-form-input>
					</b-form-group>
					<b-form-group
						id="input-group-1"
						label="Email address:"
						label-for="input-1"
						description="We'll never share your email with anyone else."
						>
						<b-form-input
							id="input-1"
							v-model="form.email"
							type="email"
							required
							placeholder="Enter email"
						></b-form-input>
					</b-form-group>
					<b-form-group id="input-password" label="Password:" label-for="password">
						<b-form-input 
							id="password" 
							v-model="form.password" 
							type="password"
							required placeholder="Enter password">
						</b-form-input>
					</b-form-group>
					<b-form-group id="input-confirmPassword" label="Confirm password:" label-for="confirmPassword">
						<b-form-input 
							id="confirmPassword" 
							v-model="form.confirmPassword" 
							type="password"
							required placeholder="Confirm password">
						</b-form-input>
					</b-form-group>
					<b-button type="submit">Submit</b-button>
					<b-button type="reset">Reset</b-button>
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
          name: '',
          password: '',
          confirmPassword: '',
        },
        errors: [],
        show: true
      }
    },
    methods: {
      async onSubmit(evt) {
      	let isChecked = await this.checkForm()
        
        if (isChecked) {
        	let currentObj = this;
        	let res = this.$request.post('/api/registration', {
              name: this.form.name,
		         	email: this.form.email,
		         	password: this.form.password,
		         	password_confirmation: this.form.confirmPassword
                })
        	
        		.then(function (response) {
        			if (response.status == 'error') {
                    currentObj.errors.push('The email has already been taken')
              } else {
        				currentObj.$router.push("/")
        			}
        		})
            .catch(function (error) {
                	 console.log(error)
                    
                });
      
     		}
     	evt.preventDefault()
      },
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.name = ''
        this.form.password = ''
        this.form.confirmPassword = ''
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },

      checkForm() {

	      this.errors = [];

	      if (!this.form.name) {
	        this.errors.push('Enter your name');
	      }

	      if (!this.form.email) {
	        this.errors.push('Enter your email');
	      } else if (!this.validEmail(this.form.email)) {
	        this.errors.push('Enter your email correctly');
	      }

	      if (this.form.password !== this.form.confirmPassword) {
	       	this.errors.push('Passwords must match');
	      }

	      if (!this.errors.length) {
        	return true;
      	}

    	},

	    validEmail(email) {
	      let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	      return re.test(email);
	   }
 		}
	}

</script>

<style scoped>
.registration {
	 margin: 60px 0 0;
}
.form {
	margin: 30px 0 0;
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