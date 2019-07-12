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
				<b-nav-item href="#" class="navLink">{{this.USD}}</b-nav-item>
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
	<router-view></router-view>
</div>
</template>

<script>

export default {
	data() {
      return {
        userName: '',
        USD: '',
      }
    },

  created() {
			this.$request.get('/api/auth/me')
      						.then( response=> {
           					this.userName = String(response.name)
      						} )

      let resp = this.$request.get('/api/course')
      						.then( response=> {
           					this.USD = '$'+response
      						} )
           				
				 
        
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



</style>