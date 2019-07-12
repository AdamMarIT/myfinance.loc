<template>
<div class="main">
	<div>
		<b-navbar toggleable="lg" type="dark" class="bgBlue">
			<b-navbar-brand href="/dashboard/main">
				<img alt="OMT logo" src="../assets/1784_oooo.png">
			</b-navbar-brand>
			<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav>
				<b-nav-item href="/dashboard/main" class="navLink">Current month</b-nav-item>
				<b-nav-item href="#" class="navLink">Reports</b-nav-item>
			</b-navbar-nav>
			<!-- Right aligned nav items -->
			<b-navbar-nav class="ml-auto">
				<b-nav-item href="#" class="navLink">Send my link</b-nav-item>
				<b-nav-item-dropdown right>
					<!-- Using 'button-content' slot -->
					<template slot="button-content"><em>{{this.userName}}</em></template>
					<b-dropdown-item href="/dashboard/profile">Profile</b-dropdown-item>
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
      }
    },

	computed: {
        userN: async function(){
           let response = await this.$request.get('/api/auth/me')
           console.log(response.name)
           this.userName = { toString: function () {
           		return response.name
           	}
           }
           return response.name
        }
  },

	methods: {
		// async created() {
		// 	let response = await this.$request.get('/api/auth/me')
		// 	console.log(response, '123')
		
		// },

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