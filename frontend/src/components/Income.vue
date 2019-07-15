<template>
<div class="income">
	<td>
   <div>{{ income.number}}</div>
  </td>
  <td>
  	<div>{{ income.date}}</div>
  </td>
  <td>
  	<div>{{ income.sum}}</div>
  </td>
  <td>
  	<div>
	  	<b-dropdown id="dropdown-1" text="Action" class="m-md-2">
		    <b-dropdown-item>Edit</b-dropdown-item>
		    <b-dropdown-item  v-on:click="deleteIncome()">Delete</b-dropdown-item>
		  </b-dropdown>
		</div>
  </td>
</div>
</template>

<script>
  export default {
 	name: 'Income',

  props: ['income'],

  methods: {
    deleteIncome() {
      this.$emit('delete-income'); 
    },
  }
}
</script>

<style scoped>

.form {
	margin: 15px 0 0;
}
button {
	margin: 0 10px;
}
.error {
	color: red;
}

</style>