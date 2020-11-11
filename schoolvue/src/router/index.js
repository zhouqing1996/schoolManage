import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
// import HelloWorld from '@/components/HelloWorld'
import Home from '../pages/Home'
import Register from '../pages/register'
import Forget from '../pages/forget'
import Login from '../pages/login'
//404错误
import NotFound from '../pages/404'


import SLineChart from '../components/SLineChart'
import CalenderHeatmap from '../components/CalenderHeatmap'
import BarChart from '../components/BarChart'

import My from '../pages/My'
import ChangePwd from '../pages/Changepwd'

//家长身份
import PLogin from '../pages/parents/plogin'
import PRegister from '../pages/parents/pregister'
import PForget from '../pages/parents/pforget'

//管理员身份
import AdminHome from '../pages/admin/AdminHome'
import AdminIndex from '../pages/admin/AdminIndex'
//用户管理
import AdminUserMaster from '../pages/admin/userManage/master'

import Data from '../pages/home/Data'
export default new Router({
  base:'/Manage/',
  mode:'hash',
  hash:true,
  routes: [

    {
      path: '/',
      name: 'Home',
      meta:{
        isLogin:true,
      },
      component: AdminHome,
      children:[
        {
          path:'/admin/index',
          name:'AdminIndex',
          meta:{
            isLogin:true
          },
          component:AdminIndex
        },
        {
          path:'/admin/userManage/master',
          name:'AdminUserMaster',
          meta:{
            isLogin:true
          },
          component:AdminUserMaster
        }
      ]
    },
    {
      path:'/p/login',
      name:'PLogin',
      meta:{
        isLogin:false
      },
      component:PLogin
    },
    {
      path:'/p/register',
      name:'PRegister',
      meta:{
        isLogin:false
      },
      component:PRegister
    },
    {
      path:'/p/forget',
      name:'PForget',
      meta:{
        isLogin:false
      },
      component:PForget
    },
    {
      path:'/slinechart',
      name:'slinechart',
      meta:{
        isLogin:false
      },
      component:SLineChart
    },
    {
      path:'/heatmap',
      name:'heatmap',
      meta:{
        isLogin:false
      },
      component:CalenderHeatmap
    },
    {
      path:'/barchart',
      name:'barchart',
      meta:{
        isLogin:false
      },
      component:BarChart
    },
    {
      path:'/my',
      name:'my',
      meta:{
        isLogin:true
      },
      component:My
    },
    {
      path:'/data',
      name:'data',
      meta:{
        isLogin:false
      },
      component:Data
    },
    {
      path:'/changepwd',
      name:'changepwd',
      meta:{
        isLogin:true
      },
      component:ChangePwd
    },
    {
      //注册
      path: '/register',
      name: 'Register',
      meta:{
        isLogin:false,
      },
      component: Register
    },
    {
      //忘记密码
      path:'/forget',
      name:'Forget',
      meta:{
        isLogin:false,
      },
      component:Forget
    },
    {
      //登录
      path:'/login',
      name:'Login',
      meta:{
        isLogin:false,
      },
      component:Login
    },
    {
      path:'*',
      name:'notfound',
      meta:{
        isLogin:false
      },
      component:NotFound
    },
  ]
})
