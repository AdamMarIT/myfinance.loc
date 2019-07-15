<template>
<div class="list">
	<div class="buttonLine">
		<b-button variant="success" v-on:click="addIncome"> <b>+</b> Add income</b-button>
		<b-button variant="danger" v-on:click="chooseTax"> Choose a tax</b-button>
		<b-button variant="primary" v-on:click="createTax"> Create a tax</b-button>
	</div>
	<p>I'm the list</p>
</div>
</template>

<script>
  export default {
 	name: 'List',

  props: [''],

  methods: {
    
  }
}
</script>

<style scoped>
.buttonLine {
	text-align: left;
	margin: 0 10px;
}

.buttonLine button {
	margin: 0 10px;
}

</style>