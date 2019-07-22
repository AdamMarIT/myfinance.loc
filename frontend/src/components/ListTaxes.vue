<template>
<div class="listTaxes">
	<CreateTax @add-tax="showTaxes()"></CreateTax>
	<div class="col-sm-12">
    <h4>List of tax</h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Type</th>
          <th scope="col">Amount</th>
          <th scope="col">Periodicity</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(tax, index ) in taxes" v-bind:key="index">  
          <td>
            <div>{{ index + 1}}</div>
          </td>
          <td>
            <b-form-input type="text" :readonly="tax.inputDisable == true" v-bind:class="{ inputDisable: tax.inputDisable }" v-model='tax.name' @keyup.enter="updateTax(tax)"></b-form-input>
          </td>
          <td>
            <div v-show="tax.inputDisable == true">{{ tax.type }}</div>
            <div v-show="tax.inputDisable == false">
              <select class="form-control mb-2 mr-sm-2 mb-sm-2" v-model='tax.type' required>
                <option value="fixed">fixed</option>
                <option value="percent">%</option>
              </select>
            </div>
          </td>
          <td>
            <b-form-input type="text" :readonly="tax.inputDisable == true" v-bind:class="{ inputDisable: tax.inputDisable }" v-model='tax.amount' @keyup.enter="updateTax(tax)"></b-form-input>
          </td>
          <td>
            <div v-show="tax.inputDisable == true">{{ tax.periodicity }}</div>
            <div v-show="tax.inputDisable == false">
              <select class="form-control mb-2 mr-sm-2 mb-sm-2" v-model='tax.periodicity'>
                <option value="">only this month</option>
                <option value="month">month</option>
                <option value="quarter">quarter</option>
                <option value="year">year</option>
              </select>
            </div>
            </td>
          <td>
            <div v-show="tax.edit"><b-button v-on:click="updateTax(tax)">OK</b-button></div>
            <div v-show="tax.edit===false">
              <b-dropdown id="action" text="Action">
              <b-dropdown-item v-on:click="editTax(tax)">Edit</b-dropdown-item>
              <b-dropdown-item v-on:click="deleteTax(tax.id)">Delete</b-dropdown-item>
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
	import CreateTax from './CreateTax.vue'
  import EventBus from './event-bus';

  export default {
 	name: 'ListTaxes',

 	components: {
	    CreateTax
	  },

	data(){
	    return {
	      taxes: []
	    }
	  },

	created() {
      this.showTaxes()
  },

  methods: {
    showTaxes() {
      this.$request.get('/api/auth/tax_index')
          .then( response=> {
              this.taxes = response.map((e)=> {
                e.edit = false
                e.inputDisable = true
                return e
              }) 
          })
    },

    async deleteTax(id) {
      await this.$request.get("/api/auth/tax_delete/"+id)
      .then( response=> {
        this.showTaxes()
        EventBus.$emit('CHANGE_TAX');
      })
    },

    async editTax(tax) {
      tax.edit = true
      tax.inputDisable = false
    },
    
    async updateTax(tax) {
      let res = await this.$request.post('/api/auth/tax_update/'+tax.id, {
                name: tax.name,
                type: tax.type,
                amount: tax.amount,
                periodicity: tax.periodicity
              })
              .then( response=> {
                if (response.status == 'success') {
                  tax.edit = false
                  tax.inputDisable = true
                  this.showTaxes();
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


.inputDisable {
  border:none;
  outline: none;
  background-color: inherit !important;
  text-align: center;
}

</style>