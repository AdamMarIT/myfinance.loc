<template>
  <div class="dashboard">
  	Profile
   	
  </div>
</template>

<script>

export default {
	async created() {
		let response = await this.$request.get('/api/auth/me')
		console.log(response)
		
		},
}
	
</script>