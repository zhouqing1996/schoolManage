import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export  default new Vuex.Store({

  state:{
    //全局变量
    sId:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sId']:"",
    sName:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sName']:"",
    sPwd:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sPwd']:"",
    sRole:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sRole']:"",
    sStatus:JSON.parse(sessionStorage.getItem("vuex"))?JSON.parse(sessionStorage.getItem("vuex"))['sStatus']:"",

    isLogin:false

  },
  mutations:{
    userStatus(state, flag) {
      state.isLogin = flag
    },
    //set方法
    setsId:function (state,id) {
      state.sId = id;
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    setsName:function (state,name) {
      state.sName = name;
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    setsPwd:function (state,pwd) {
      state.sPwd = pwd;
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    setsRole:function (state,role) {
      state.sRole = role;
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    setsStatus:function (state,status) {
      state.sStatus = status;
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    delsId(state)
    {
      state.sId = "";
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    delsName(state)
    {
      state.sName = "";
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    delsPwd(state)
    {
      state.sPwd = "";
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    delsRole(state)
    {
      state.sRole = "";
      sessionStorage.setItem("vuex",JSON.stringify(state))
    },
    delsStatus(state)
    {
      state.sStatus = "";
      sessionStorage.setItem("vuex",JSON.stringify(state))
    }
  },
  getters:{
    isLogin: state => state.isLogin,
    //get方法
    getsId:(state)=>{
      return state.sId
    },
    getsName:(state)=>{
      return state.sName
    },
    getsPwd:(state)=>{
      return state.sPwd
    },
    getsRole:(state)=>{
      return state.sRole
    },
    getsStatus:(state)=>{
      return state.sStatus
    }
  },
  actions:{
    //获取登录状态
    userLogin({commit}, flag) {
      commit("userStatus", flag)
    },
    slogin:({commit},obj)=>{
      commit('setsId',obj.userid),commit('setsName',obj.username),commit('setsPwd',obj.password),
        commit('setsRole',obj.role),
        commit('setsStatus',obj.status)
    },
    slogout:({commit})=>{
      commit('delsId'),commit('delsName'),commit('delsPwd'),
        commit('delsRole'),
        commit('delsStatus')
    },
    sforget:({commit},obj)=>{
      commit('setsId',obj.userid),commit('setsName',obj.username),commit('setsPwd',obj.password),
        commit('setsRole',obj.role),
        commit('setsStatus',obj.status)
    },
  }
});

