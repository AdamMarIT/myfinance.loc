<template>
<div class="addIncome">
  <div class="col-sm-12">
      <h4>Add an income</h4>
      <b-form inline>
        <b-form-input class="mb-2 mr-sm-2 mb-sm-2" id="date" type="date" v-model='form.date'></b-form-input>
        <input class="form-control mb-2 mr-sm-2 mb-sm-2" type="text"  v-model='form.amount' placeholder="Amount">
        <select class="form-control mb-2 mr-sm-2 mb-sm-2"  v-model='form.currency' id="inline-form-custom-select-pref">
          <option value="">UA</option>
          <option value="usd">$</option>
        </select>
        <input class="form-control mb-2 mr-sm-2 mb-sm-2" type="text"  v-model='form.comment' placeholder="Comment">
        <b-button class=" mb-2 mr-sm-2 mb-sm-2" variant="primary" @click="onSubmit">ADD</b-button>
      </b-form>
  </div>
</div>
</template>

<script>
  import EventBus from './event-bus';

  export default {
 	name: 'AddIncome',

  data(){
    return {
      form: {
          date: '',
          amount: '',
          currency: '',
          comment: '',
        },
    }
  },

  created() {
    this.today()
  },

  methods: {
    async onSubmit() {
      let res = await this.$request.post('/api/auth/income_add', {
              date: this.form.date,
              amount: this.form.amount,
              currency: this.form.currency,
              rate: this.$store.state.rateUSD,
              comment: this.form.comment
                })
              .then( response=> {
                if (response.status == 'success') {
                  this.form.date = this.today()
                  this.form.amount = ''
                  this.form.currency = ''
                  this.form.comment = ''
                  this.$emit('add-income');
                  EventBus.$emit( 'COUNT_INCOME' );
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