<template>
<div class="incomes">
  <div class="taskline">
    <div>
      <div class="col-10">
        <input class="form-control" type="date" value="2011-08-19" id="date-input">
      </div>
      <input type="text" id="new-item" @keyup.enter="addIncome()" v-model="sum" placeholder="enter sum" class="form-control">
    </div>
    <select class="form-control" id="currency">
      <option value="usd">USD</option>
      <option value="ua">UA</option>
    </select>
    <div>
      <input type="text" id="new-item" @keyup.enter="addIncome()" v-model="comment" placeholder="comment" class="form-control">
    </div>
    <div class="button button-small" id="add-button" v-on:click="addIncome()">
      +
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Sum</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index )in items" v-bind:key="index">
        <Income :inkome="income" @delete-income="deleteIncome(index)"></Income>
      </tr>
    </div>
    </template>

<script>
  import Income from './Income.vue'

  export default {
 	name: 'IncomesTable',

   components: {
    Income
  },

  data(){
    return {
      number: ''
      date : '',
      sum: '',
      inkomes: []
    }
  },

  methods: {
    
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