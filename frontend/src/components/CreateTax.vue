<template>
<div class="createTax">
  <div class="col-sm-12">
      <h4>Create a tax</h4>
      <b-form inline>
        <input class="form-control mb-2 mr-sm-2 mb-sm-2" type="text"  v-model='form.name' placeholder="Name">
        <select class="form-control mb-2 mr-sm-2 mb-sm-2"  v-model='form.type' required>
          <option value="">Choose type</option>
          <option value="fixed">fixed</option>
          <option value="percent">%</option>
        </select>
        <input class="form-control mb-2 mr-sm-2 mb-sm-2" type="text"  v-model='form.amount' placeholder="Amount in UAN">
        <select class="form-control mb-2 mr-sm-2 mb-sm-2"  v-model='form.periodicity'>
          <option value="">only this month</option>
          <option value="month">month</option>
          <option value="quarter">quarter</option>
          <option value="year">year</option>
        </select>
        <b-button class=" mb-2 mr-sm-2 mb-sm-2" variant="primary" @click="onSubmit">Create</b-button>
      </b-form>
  </div>
</div>
</template>

<script>
  export default {
 	name: 'CreateTax',

  data(){
    return {
      form: {
        name: '',
        type: '',
        amount: '',
        periodicity: '',
      }
    }
  },

  methods: {
      async onSubmit() {
      let res = await this.$request.post('/api/auth/tax_create', {
              name: this.form.name,
              type: this.form.type,
              amount: this.form.amount,
              periodicity: this.form.periodicity || this.today()
              })
              .then( response=> {
                if (response.status == 'success') {
                  this.form.amount = ''
                  this.form.name = ''
                  this.form.type = ''
                  this.form.periodicity = ''
                  this.$emit('add-tax');
                }
              })
      
    },

    today() {
      let d = new Date(),
          month = '' + (d.getMonth() + 1),
          day = '' + d.getDate(),
          year = d.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      this.form.date = [year, month, day].join('-');

      return this.form.date;
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

h4 {
  text-align: left;
}

.col-sm-12 {
  margin-bottom: 15px;
}

</style>