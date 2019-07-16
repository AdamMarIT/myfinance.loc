<template>
<div class="listTaxes">
	<CreateTax @add-tax="showTaxes()"></CreateTax>
	<div class="col-sm-12">
    <h4>List of tax</h4>
    <table class="table">
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
            <div>{{ tax.name}}</div>
          </td>
          <td>
            <div>{{ tax.type}}</div>
          </td>
          <td>
            <div>{{ tax.amount}}</div>
          </td>
          <td>
            <div>{{ tax.periodicity }}</div>
          </td>
          <td>
            <div>
              <b-dropdown id="action" text="Action">
              <b-dropdown-item>Edit</b-dropdown-item>
              <b-dropdown-item  v-on:click="deleteTax(tax.id)">Delete</b-dropdown-item>
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
              this.taxes = response
          })
    },
    async deleteTax(id) {
      await this.$request.get("/api/auth/tax_delete/"+id)
      .then( response=> {
        this.showTaxes()
      })
    }
    
  }

  

}
</script>

<style scoped>
h4 {
  text-align: left;
}

</style>