<template>
<div class="main">
	<div>
		<b-navbar toggleable="lg" type="dark" class="bgBlue">
				<b-navbar-brand>
					<router-link to="/dashboard/main">
					<img alt="OMT logo" src="../assets/1784_oooo.png">
					</router-link>
				</b-navbar-brand>
			<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav>
				<b-nav-item class="navLink">
					<router-link to="/dashboard/main">Current month</router-link>
				</b-nav-item>
				<b-nav-item href="#" class="navLink">Reports</b-nav-item>
			</b-navbar-nav>
			<!-- Right aligned nav items -->
			<b-navbar-nav class="ml-auto">
				<b-nav-item href="#" class="navLink">Send my link</b-nav-item>
				<b-nav-item-dropdown right>
					<!-- Using 'button-content' slot -->
					<template slot="button-content"><em>{{this.userName}}</em></template>
						<b-dropdown-item>
							<router-link to="/dashboard/profile">Profile</router-link>
						</b-dropdown-item>
					<b-dropdown-item @click="logOut">Sign Out</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
			</b-collapse>
		</b-navbar>
	</div>
	<div class="row">
		<div class="col-md-3 leftSidebar">
			<div class="rate">
				Exchange rate for today: &nbsp;{{this.USD}}
			</div>
			<div class="monthlyIncome">
				Income for this month: &nbsp;{{this.amountIncome}}  &#8372; <br />
			</div>
			<div class="monthlyTax">
				<b-card no-body class="accordion">
		      <b-card-header header-tag="header" class="p-1" role="tab">
		        <p v-b-toggle.accordion-1>v</p>
		      </b-card-header>
		      <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
		        <b-card-body>
		          <b-card-text>I start opened because <code>visible</code> is <code>true</code></b-card-text>
		          <b-card-text>{{ text }}</b-card-text>
		        </b-card-body>
		      </b-collapse>
		    </b-card>
				Tax for this month: &nbsp;{{}} <br />
				
			</div>
			<div class="profit">
				Amount of profit: &nbsp;{{}}
			</div>
		</div>
		<div class="col-md-9 content">
			<router-view></router-view>
		</div>
	</div>
</div>
</template>

<script>

export default {
	data() {
      return {
        userName: '',
        USD: '',
        amountIncome: ''
      }
    },

  created() {
			this.$request.get('/api/auth/me')
      		.then( response=> {
           		this.userName = String(response.name)
      		})

      this.$request.get('/api/course')
      		.then( response=> {
           		this.USD = '$'+response
           		this.$store.commit('setRateUSD', response)
      		})

      this.$request.get('/api/auth/amountIncome')
      		.then( response=> {
           		this.amountIncome = response 	

      		})	    	    
	},

	methods: {
	 	logOut() {
	 		this.$store.commit('setAccessToken', '')
			this.$router.push("/") 
	 	}
	}
}
	
</script>

<style scoped>

.bgBlue {
	background-color: #14395e;
	font-size: 120%;
}

img {
	margin: -10px 0;
}

.navLink {
	margin: 0 10px;
}

.leftSidebar {
	height: 100vh;
	background-color: #ccc;	
}

.leftSidebar div {
	border-bottom: solid 1px #999;
	line-height: 50px;
  min-height: 50px;
  margin: 10px;
  font-size: 	large;
}

.accordion {
	background-color: inherit;
	border: inherit;
}

.content {
	height: 100vh;
}

.rate {
	margin-bottm: 10px;
}



</style>