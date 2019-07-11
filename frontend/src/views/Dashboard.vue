<template>
  <div class="dashboard">
   dashboard
  </div>
</template>

<script>

export default {
	async created() {
		let response = await this.$request.get('/api/auth/me')
        console.log(response);
	}
}
  
</script>
