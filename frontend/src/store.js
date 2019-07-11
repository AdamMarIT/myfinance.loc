import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist'

Vue.use(Vuex)

const vuexPersist = new VuexPersist({
  key: 'my-finance-storage',
  storage: localStorage
})

export default new Vuex.Store({
  plugins: [vuexPersist.plugin],
  state: {
  	accessToken: '',
  	currentUser : {}
  },
  getters: {
  	isAuthenticated: state => !!state.accessToken,
    getAccessToken: state => {
        return state.accessToken
    }
  },
  mutations: {
  	setAccessToken(state, token) {
      state.accessToken = token;
    }
  },
  actions: {

  }
})
