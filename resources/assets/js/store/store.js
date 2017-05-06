import Vuex from 'vuex';
import Vue from 'vue';
import { PROJECT_URL } from '../components/api';

Vue.use(Vuex);

const state = {
    showLoading : false,
    projectData : [],
    breadcrumb : [{"name":'Home','path':'/'}]
};

// vue 裡用 this.$store.commit('showLoading' , true)
// mutation 必須是同步函數, 很重要
// set
const mutations = {
    isLogin( state, value ) {
        state.isLogin = value;
    },
    projectData( state, value ) {
        state.projectData = value;
    }
};

/*
 vue 裡用 this.$store.dispatch('showLoading' , true)
 methods(){
 ...Vuex.mapActions(['showLoading','count']),
 }
 Action 類似於 mutation，不同在於：
 Action 提交的是 mutation，而不是直接變更狀態。
 Action 可以包含任意異步操作。
 Action 可以非同步，但一定只能 return Promise
 */
const actions = {
    showLoading( {commit} , value) {
        commit( 'showLoading',value );
    },
    getProjectData( {commit} ) {
        axios.get(PROJECT_URL).then((response) => {
            console.log(response.data);
            commit( 'projectData', response.data.data);
        }, (err) => {
            console.log(err)
        })
    },
    createNewProject( {commit}) {
        this.getProjectData(commit);
    }
};

/**
 computed:{
        ...Vuex.mapGetters(['showLoading','isLogin','userName'])
    },
 */
const getters = {
    showLoading: state => state.showLoading,
    projectData: state => state.projectData
};


// https://vuex.vuejs.org/en/plugins.html
// Plugins
const myPlugin = store => {
    // called when the store is initialized
    store.subscribe(( mutation, state ) => {
        // called after every mutation.
        console.log( mutation );
        // The mutation comes in the format of { type, payload }.
    });
};

export default new Vuex.Store( {
    plugins: [myPlugin],
    state,
    getters,
    actions,
    mutations,
    strict: false,//嚴格模式
});