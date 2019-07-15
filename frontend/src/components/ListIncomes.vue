<template>
<div class="listIncomes">
	<AddIncome></AddIncome>
	<div class="col-sm-12">
    <h4>List of income</h4>


  </div>
</div>
</template>

<script>
	import AddIncome from './AddIncome.vue'

  export default {
 	name: 'ListIncomes',

 	components: {
    AddIncome
  },

  props: [''],

  methods: {
    
  }
}
</script>

<style scoped>
h4 {
  text-align: left;
}

</style>