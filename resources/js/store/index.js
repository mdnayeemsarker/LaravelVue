import { createStore } from "vuex";

const store = createStore({
    state:{
        token: localStorage.getItem('_token') || 0
    },
    mutations: {
        UPDATE_TOKEN(state, payload){
            state.token = payload
        }
    },
    actions: {
        setToken(context, payload){
            localStorage.setItem('_token', payload)
            context.commit('UPDATE_TOKEN', payload)
        },
        removeToken(context){
            localStorage.removeItem('_token')
            context.commit('UPDATE_TOKEN', 0)
        },
    },
    getters:{
        getToken: function(state) {
            return state.token;
        }
    }
})

export default store;