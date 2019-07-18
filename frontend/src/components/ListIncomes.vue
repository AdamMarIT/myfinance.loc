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
          <th scope="col">Currency</th>
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
            <b-form-input type="date" v-model='income.date'></b-form-input>
          </td>
          <td>
            <b-form-input type="text" v-model='income.amount'></b-form-input>
          </td>
          <td>
            <b-form-input type="text" v-model='income.rate'></b-form-input>
          </td>
          <td>
            <select class="form-control"  v-model='income.currency'>
              <option value="">UA</option>
              <option value="usd">$</option>
            </select>
          </td>
          <td>
            <b-form-input type="text" v-model='income.comment'></b-form-input>
          </td>
          <td>
            <div>
              <b-dropdown id="action" text="Action">
              <!-- <b-dropdown-item v-on:click="editIncome(income.id)">Edit</b-dropdown-item> -->
              <b-dropdown-item v-on:click="income.edit = true">Edit</b-dropdown-item>
              <b-dropdown-item v-on:click="deleteIncome(income.id)">Delete</b-dropdown-item>
              </b-dropdown>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <b-modal v-model="edit" @hidden="resetModal" @ok="handleOk()" header-text-variant="'Edit income'">
      <b-form @submit="handleSubmit">
        <b-form-input class="mb-2 mr-sm-2 mb-sm-2" id="date" type="date" v-model='formedit.date'>{{ incomeById.date}}</b-form-input>
        <b-form-input class="mb-2 mr-sm-2 mb-sm-2" type="text" v-model='formedit.amount'>{{ incomeById.amount}}</b-form-input>
        <select class="form-control mb-2 mr-sm-2 mb-sm-2"  v-model='formedit.currency'>
          <option value="">UA</option>
          <option value="usd">$</option>
        </select>
        <b-form-input class="mb-2 mr-sm-2 mb-sm-2" type="text" v-model='formedit.rate'></b-form-input>
        <b-form-input class="mb-2 mr-sm-2 mb-sm-2" type="text" v-model='formedit.comment'>{{ incomeById.comment}}</b-form-input>
        <input type="hidden" v-model="formedit.id">
      </b-form>
    </b-modal>
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
      incomeById: [],
      edit: false,
      formedit: {
          date: '',
          amount: '',
          currency: '',
          rate: '',
          comment: '',
        },
    }
  },
   created() {
      this.showIncomes()
      console.log(edit)
  },

  methods: {
    showIncomes() {
      this.$request.get('/api/auth/income_index')
          .then( response=> {
              this.incomes = response.map((e)=> {
                e.edit = false
                return e
              }) 
          })
    },
    async deleteIncome(id) {
      await this.$request.get("/api/auth/income_delete/"+id)
      .then( response=> {
        this.showIncomes()
        EventBus.$emit( 'COUNT_INCOME' );
      })
    },

    async editIncome(id) {
      await this.$request.get("/api/auth/income_edit/"+id)
      .then( response=> {
        this.edit = true
        this.formedit.id = response.id
        this.formedit.date = response.date
        this.formedit.currency = response.currency

        if (response.currency == 'usd') {
          this.formedit.amount = response.amount_usd
        } else {
          this.formedit.amount = response.amount
        }
        
        this.formedit.comment = response.comment
        this.formedit.rate = response.rate
        
      })
    },

    resetModal() {
        this.name = ''
        this.nameState = null
      },
    handleOk() {
        // Trigger submit handler
        this.handleSubmit()
      },

    async handleSubmit() {
      let res = await this.$request.post('/api/auth/income_update/'+this.formedit.id, {
              date: this.formedit.date,
              amount: this.formedit.amount,
              currency: this.formedit.currency,
              rate: this.formedit.rate,
              comment: this.formedit.comment
                })
              .then( response=> {
                if (response.status == 'success') {
                  this.formedit.date = ''
                  this.formedit.amount = ''
                  this.formedit.currency = ''
                  this.formedit.comment = ''
                  this.formedit.rate = ''
                  this.showIncomes();
                  EventBus.$emit( 'COUNT_INCOME' );
                  this.edit = false
                }
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

td>* {
  display: inline-block;
}

</style>