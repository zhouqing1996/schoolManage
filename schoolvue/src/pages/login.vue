<template>
  <div class="page">
    <div class="loginwarrp">
      <div class="logo">中学学生档案管理系统</div>
      <div class="login_form">
        <li class="login-item" >
            <span style="font-size: 20px;color: #0ea0db;" class="el-icon-user">用户账号：</span>
            <input type="text" v-model="loginForm.username" class="login_input" placeholder="账号">
          <span class="error"></span>
        </li>
          <li class="login-item">
            <span style="font-size: 20px;color: #0ea0db;" class="el-icon-key">登录密码：</span>
            <input :type="passwordVisible" v-model="loginForm.password" class="login_input" placeholder="密码">
              <i slot="suffix" :class="icon" @click="showPass" style="text-align: right"></i>
            <span class="error"></span>
          </li>
          <li class="login-item">
            <span style="font-size: 20px;color: #0ea0db;" class="el-icon-s-custom">登录身份：</span>
            <select v-model="loginForm.role" placeholder="选择登录身份" autocomplete="off" >
              <option value="4" selected>学生</option>
              <option value="3">教师</option>
              <option value="2">校长</option>
              <option value="1">管理员</option>
            </select>
          </li>
        <div class="clearfix">
          <li class="login-sub">
            <input type="button" value="登录" v-on:click="login">
          </li>
          <br>
          <div  >
            <span><router-link to="/p/login">家长登录</router-link></span>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>


<script>
  export default {
    name: "Login",
    data() {
      return {
        passwordVisible:'password',
        icon:"el-icon-view",
        loginForm: {
          username: '',
          password: '',
          role:''
        },
        responseResult: []
      }
    },
    methods: {
      showPass() {
        if (this.passwordVisible === "text") {
          this.passwordVisible = "password";
          //更换图标
          this.icon = "el-icon-view";
        } else {
          this.passwordVisible = "text";
          this.icon = "el-icon-lock";
        }
      },
      login() {
        if(this.loginForm.username==''||this.loginForm.password==''||this.loginForm.role=='')
        {
          this.$alert('请输入完整登录信息', '警告', {
            confirmButtonText: '确定',})
        }
        else{
          this.$http.post('/home/index/login',{
            username:this.loginForm.username,
            password:this.loginForm.password,
            role:this.loginForm.role
          }).then(res=>{
            console.log(res.data)
            var message = res.data.message
            if(message=="登录成功")
            {
              this.$store.dispatch('slogin',res.data.data)
              let role = this.$store.getters.getsRole
              alert(message)
              if(role==1)
              {
                //管理员
                this.$router.push({path:'/admin/index'})
              }
              else if(role ==2)
              {
                //校长
                this.$router.push({path:'/teacher/index'})
              }
              else if(role==3)
              {
                //教师
                this.$router.push({path:'/teacher/index'})
              }
              else if(role==4)
              {
              //  学生
              }
              console.log(this.$store.getters.getsToken)
            }
            else if(message=="该用户不存在")
            {
              alert(message)
            }
            else if(message=="密码错误，登录失败")
            {
              alert(message)
            }
          }).catch(function (error) {
            console.log(error)
          })
        }
      },
      // gotoReigster() {
      //   this.$router.push({
      //     path: "/register"
      //   });
      // },
      // gotoForget(){
      //   this.$router.push({
      //     path:"/forget"
      //   });
      // }
    },
    created:function ()
    {
      this.loginForm.username = this.$route.params.username;
      this.loginForm.password = this.$route.params.password
    }
  }
</script>

<style>
  @import "../common/css/login.css";
</style>
