<template>
  <div class="dashboard">
	  <b-tabs>
	    <!-- <b-tab title="An accountant's ledger" active class="listcard">
	    	<div><List> </List></div>
	    </b-tab> -->
	    <b-tab title="Income" class="listcard">
	    	<div><ListIncomes></ListIncomes></div>
	    </b-tab>
	    <b-tab title="Tax" class="listcard">
	    	<div><ListTaxes></ListTaxes></div>
	    </b-tab>
	  </b-tabs>
  </div>
</template>

<script>
	//import List from '@/components/List.vue'
	import ListIncomes from '@/components/ListIncomes.vue'
	import ListTaxes from '@/components/ListTaxes.vue'

export default {
	name: 'Dashboard',

  components: {
   // List,
    ListIncomes,
    ListTaxes
  },
}
  
</script>

<style scoped>

.dashboard {
	margin-top: 10px;
}

.listcard {
	border-left: solid 1px #ddd;
	height: 100vh;
}

.listcard>div {
	padding-top: 20px;
}

</style>
