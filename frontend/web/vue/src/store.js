import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    items: []
  },
  mutations: {
    setItems: (state, items) => state.items = items
  },
  actions: {
      getItems: async ({commit}) => {
        await this.$http.get(`${process.env.VUE_APP_API_URL}/request/employment-type`).then((res) => {
          commit('setItems', res)
        });
      }
  }
})
