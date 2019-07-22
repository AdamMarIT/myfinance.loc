<template>
<div class="listIncomes">
	<AddIncome @add-income="showIncomes()"></AddIncome>
	<div class="col-sm-12">
    <h4>List of income</h4>
    <table class="table table-hover">
      <thead>
        <colgroup class="row">
            <col class="col-md-1">
            <col class="col-md-2">
            <col class="col-md-3">
            <col class="col-md-1">
            <col class="col-md-2">
            <col class="col-md-3">
        </colgroup>
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
            <b-form-input type="date" :readonly="income.inputDisable == true" v-bind:class="{ inputDisable: income.inputDisable }" v-model='income.date' @keyup.enter="updateIncome(income)"></b-form-input>
          </td>
          <td >
            <div class="minWidth30">
              <div>
                <b-form-input type="text" :readonly="income.inputDisable == true" v-bind:class="{ inputDisable: income.inputDisable }" v-model='income.amount' @keyup.enter="updateIncome(income)"></b-form-input>
              </div>
              <div v-show="income.edit">
                <select class="form-control"  v-model='income.currency'>
                <option value="">UA</option>
                <option value="usd">$</option>
              </select>
              </div>
            </div>
          </td>
          <td>
            <b-form-input type="text" class="rate" :readonly="income.inputDisable == true" v-bind:class="{ inputDisable: income.inputDisable }" v-model='income.rate' @keyup.enter="updateIncome(income)"></b-form-input>
          </td>
          <td>
            <b-form-input type="text" :readonly="income.inputDisable == true" v-bind:class="{ inputDisable: income.inputDisable }" v-model='income.comment' @keyup.enter="updateIncome(income)"></b-form-input>
          </td>
          <td>
            <div v-show="income.edit"><b-button v-on:click="updateIncome(income)">OK</b-button></div>
            <div v-show="income.edit===false">
              <b-dropdown id="action" text="Action">
              <b-dropdown-item v-on:click="editIncome(income)">Edit</b-dropdown-item>
              <b-dropdown-item v-on:click="deleteIncome(income.id)">Delete</b-dropdown-item>
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
  import EventBus from './event-bus';

  export default {
 	name: 'ListIncomes',

 	components: {
    AddIncome,
  },
  data(){
    return {
      incomes: [],
    }
  },
   created() {
      this.showIncomes()
  },

  methods: {
    showIncomes() {
      this.$request.get('/api/auth/income_index')
          .then( response=> {
              this.incomes = response.map((e)=> {
                e.edit = false
                e.inputDisable = true
                return e
              }) 
          })
    },
    async deleteIncome(id) {
      await this.$request.get("/api/auth/income_delete/"+id)
      .then( response=> {
        this.showIncomes()
        EventBus.$emit('COUNT_INCOME');
        EventBus.$emit('CHANGE_TAX');
      })
    },

    async editIncome(income) {
      income.edit = true
      income.inputDisable = false
      if (income.currency == 'usd') {
          income.amount = income.amount_usd
        }
    },

    async updateIncome(income) {
      let res = await this.$request.post('/api/auth/income_update/'+income.id, {
              date: income.date,
              amount: income.amount,
              currency: income.currency,
              rate: income.rate,
              comment: income.comment
                })
              .then( response=> {
                if (response.status == 'success') {
                  income.edit = false
                  income.inputDisable = true
                  this.showIncomes();
                  EventBus.$emit('COUNT_INCOME'); 
                  EventBus.$emit('CHANGE_TAX'); 
                }
              })
            },
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

.minWidth30>div {
  display: inline-block;
  max-width: 50%;
  margin-right: 5px;
}

.minWidth30 {
  min-width: 200px;
}

.rate {
  width:80px;
}

.inputDisable {
  border:none;
  outline: none;
  background-color: inherit !important;
  text-align: center;
}

</style>