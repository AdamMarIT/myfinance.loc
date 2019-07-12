<template>
<div class="income">
	<td v-for="key in columns">
   <!--  {{entry[key]}} -->
  </td>
  <td>
    <div class="button button-small" v-on:click="deleteIncome()">
    &times;
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