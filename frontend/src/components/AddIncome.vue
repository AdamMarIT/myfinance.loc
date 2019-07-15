<template>
<div class="addIncome">
  <div class="col-sm-12">
      <h4>Add an income</h4>
      <b-form inline>
        <b-form-input class="mb-2 mr-sm-2 mb-sm-2" id="date" type="date" v-model='date'></b-form-input>
        <input class="form-control mb-2 mr-sm-2 mb-sm-2" type="text"  v-model='amount' placeholder="Amount">
        <select class="form-control mb-2 mr-sm-2 mb-sm-2"  v-model='currency' id="inline-form-custom-select-pref">
          <option value="ua" selected>UA</option>
          <option value="usd">$</option>
        </select>
        <input class="form-control mb-2 mr-sm-2 mb-sm-2" type="text"  v-model='comment' placeholder="Comment">
        <b-button class=" mb-2 mr-sm-2 mb-sm-2" variant="primary">ADD</b-button>
      </b-form>
  </div>
</div>
</template>

<script>
  export default {
 	name: 'AddIncome',

  data(){
    return {
      date : '',
      amount: '',
      currency: '',
      comment: '',
    }
  },

  props: [''],

  created() {
    this.today()
  },

  methods: {
    today() {
      let d = new Date(),
          month = '' + (d.getMonth() + 1),
          day = '' + d.getDate(),
          year = d.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      this.date = [year, month, day].join('-');

      return this.date;
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