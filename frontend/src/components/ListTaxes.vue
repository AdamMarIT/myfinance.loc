<template>
<div class="listTaxes">
	<CreateTax></CreateTax>
	<div class="col-sm-12">
    <h4>List of income</h4>

	
  </div>
	
</div>
</template>

<script>
	import CreateTax from './CreateTax.vue'

  export default {
 	name: 'ListTaxes',

 	components: {
	    CreateTax
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