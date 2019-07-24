<template>
<div class="main">
	<div>
		<b-navbar toggleable="lg" type="dark" class="bgBlue">
				<b-navbar-brand>
					<router-link to="/dashboard/main">
					<img alt="OMT logo" src="../assets/1784_oooo.png">
					</router-link>
				</b-navbar-brand>
			<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav>
				<b-nav-item class="navLink">
					<router-link to="/dashboard/main">Current month</router-link>
				</b-nav-item>
				<b-nav-item class="navLink">
					<router-link to="/dashboard/files">My files</router-link>
				</b-nav-item>
				<b-nav-item class="navLink">
					<router-link to="/dashboard/reports">Reports</router-link>
				</b-nav-item>
			</b-navbar-nav>
			<!-- Right aligned nav items -->
			<b-navbar-nav class="ml-auto">
				<b-nav-item class="navLink"><router-link to="#">Send my link</router-link></b-nav-item>
				<b-nav-item-dropdown right>
					<!-- Using 'button-content' slot -->
					<template slot="button-content"><em>{{this.userName}}</em></template>
						<b-dropdown-item>
							<router-link to="/dashboard/profile">Profile</router-link>
						</b-dropdown-item>
					<b-dropdown-item @click="logOut">Sign Out</b-dropdown-item>
				</b-nav-item-dropdown>
			</b-navbar-nav>
			</b-collapse>
		</b-navbar>
	</div>
	<div class="row margin">
		<div class="col-md-3 leftSidebar">
			<div class="rate">
				Exchange rate for today: &nbsp;{{this.USD}} 
			</div>
			<div class="monthlyIncome">
				Income for this month: &nbsp;{{this.amountIncome}}  &#8372; <br />
			</div>
			<div class="monthlyTax">
		    <b-button
		    	block
		    	variant="light"
		      :class="showCollapse ? 'collapsed' : null"
		      :aria-expanded="showCollapse ? 'true' : 'false'"
		      aria-controls="collapse-4"
		      @click="showCollapse = !showCollapse"
		    >
		      Tax for this month: &nbsp;{{ this.amountTax }} &#8372; <span class="myTab"> &nbsp;</span> <b>&#8595</b>   
		    </b-button>
		    <b-collapse id="collapse-4" v-model="showCollapse">
		      <ul v-for="tax in taxes" class="list">
		      	<li> {{ tax.name }} &nbsp; - &nbsp; {{ tax.amount}} &#8372; </li>
		      </ul>
		    </b-collapse>
			</div>
			<div class="profit">
				Amount of profit: &nbsp;{{ this.amountIncome - this.amountTax }} &#8372;
			</div>
		</div>
		<div class="col-md-9 content">
			<router-view></router-view>
		</div>
	</div>
</div>
</template>

<script>
import EventBus from '@/components/event-bus';

export default {
	data() {
      return {
        userName: '',
        USD: '',
        amountIncome: '',
        amountTax: '',
        taxes: [],
        showCollapse: true
      }
    },
  mounted () {
  	let self = this
    EventBus.$on('COUNT_INCOME',() => {
      self.getAmountIncome();
    });
    EventBus.$on('CHANGE_TAX',() => {
      self.getAmountOfTax();
      self.getListOfTaxes();
    });
  },

  created() {
	  this.$request.get('/api/auth/me')
      		.then( response=> {
           		this.userName = String(response.name)
      		})

      this.$request.get('/api/course')
      		.then( response=> {
           		this.USD = '$'+response
           		this.$store.commit('setRateUSD', response)
      		})
      this.getAmountIncome()
      this.getAmountOfTax()
      this.getListOfTaxes()	    	    
	},

	methods: {
	 	logOut() {
	 		this.$store.commit('setAccessToken', '')
			this.$router.push("/") 
	 	},
	 	getAmountIncome() {
	 		this.$request.get('/api/auth/amount_income')
      		.then( response=> {
           		this.amountIncome = response 	
      		})
	 	},

	 	getAmountOfTax() {
	 		this.$request.get('/api/auth/amount_tax')
      		.then( response=> {
           		this.amountTax = response 	
      		})
	 	},

	 	getListOfTaxes() {
	 		this.$request.get('/api/auth/list_of_tax')
      		.then( response=> {
           		this.taxes = response 	
      		})
	 	},

	}
}
	
</script>

<style scoped>

.myTab {
	margin: 0 7%;
}

.bgBlue {
	background-color: #14395e;
	font-size: 120%;
}

img {
	margin: -10px 0;
}

.navLink {
	margin: 0 10px;
}

.leftSidebar {
	min-height: 100vh;
	background-color: #ccc;	
}

.leftSidebar div {
	border-bottom: solid 1px #999;
	line-height: 50px;
  min-height: 50px;
  margin: 10px;
  text-align: left;
  text-indent: 2em;
}

#collapse-4 {
	border: none;
}

.monthlyTax>button {
	background-color: inherit;
	border: none;
	color: inherit;
	text-align: inherit;
	text-indent: 1em;
}

.list>li {
	line-height: 25px;
	text-align: left;
	margin-left: 15%;
}

.content {
	min-height: 100vh;
}

.rate {
	margin-bottm: 10px;
}

.margin {
	margin: 0 !important;
}

</style>