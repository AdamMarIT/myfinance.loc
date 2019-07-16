<template>
<div class="listIncomes">
	<AddIncome @add-income="showIncomes()"></AddIncome>
	<div class="col-sm-12">
    <h4>List of income</h4>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Date</th>
          <th scope="col">Amount</th>
          <th scope="col">Rate</th>
          <th scope="col">Comment</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(income, index ) in incomes" v-bind:key="index">  
          <td>
            <div>{{ index + 1}}</div>
          </td>
          <td>
            <div>{{ income.date}}</div>
          </td>
          <td>
            <div>{{ income.amount}}</div>
          </td>
          <td>
            <div>{{ income.rate}}</div>
          </td>
          <td>
            <div>{{ income.comment}}</div>
          </td>
          <td>
            <div>
              <b-dropdown id="action" text="Action">
              <b-dropdown-item>Edit</b-dropdown-item>
              <b-dropdown-item  v-on:click="deleteIncome(income.id)">Delete</b-dropdown-item>
              </b-dropdown>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
	import AddIncome from './AddIncome.vue'

  export default {
 	name: 'ListIncomes',

 	components: {
    AddIncome,
  
  },
  data(){
    return {
      incomes: []
    }
  },
   created() {
      this.showIncomes()
  },

  methods: {
    showIncomes() {
      this.$request.get('/api/auth/income_index')
          .then( response=> {
              this.incomes = response
          })
    },
    async deleteIncome(id) {
      await this.$request.get("/api/auth/income_delete/"+id)
      .then( response=> {
        this.showIncomes()
      })
    }
    
  }
}
</script>

<style scoped>
h4 {
  text-align: left;
}

#action{
  margin: -10px;
}

</style>