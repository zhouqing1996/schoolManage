<template>
  <div class="page">
    <div class="loginwarrp">
      <div class="logo">中学学生档案管理系统</div>
      <div class="login_form">
        <li class="login-item" >
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-user">用户账号：</span>
          <input type="text" v-model="registerForm.userno" class="login_input" placeholder="用户账号">
          <span class="error"></span>
        </li>
        <li class="login-item" >
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-user">用户名：</span>
          <input type="text" v-model="registerForm.username" class="login_input" placeholder="用户名">
          <span class="error"></span>
        </li>
        <li class="login-item">
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-key">设置密码：</span>
          <input :type="passwordVisible1" v-model="registerForm.password" class="login_input" placeholder="6-10位包含数字、字母、特殊字符">
          <i slot="suffix" :class="icon1" @click="showPass1"></i>
          <span class="error"></span>
        </li>
        <li class="login-item">
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-key">确认密码：</span>
          <input :type="passwordVisible2" v-model="registerForm.password1" class="login_input" placeholder="密码">
          <i slot="suffix" :class="icon2" @click="showPass2"></i>
          <span class="error"></span>
        </li>
        <li class="login-item">
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-s-custom">注册身份：</span>
          <select v-model="registerForm.role" placeholder="选择注册身份">
            <option value="2">教  师</option>
            <option value="3" selected="selected">学  生</option>
            <option value="1">管理员</option>
          </select>
          <span class="error"></span>
        </li>
        <div class="clearfix">
          <li class="login-sub">
            <input type="button" value="注册" v-on:click="submitForm(registerForm)">
          </li>
          <span class="error"></span>
        </div>
          <div  >
            <!--<span><router-link to="/login">有账号？立即登录</router-link></span>-->
            <!--<span><router-link to="/forget">忘记密码？立即找回</router-link></span>-->
          </div>
        </div>
      </div>
    </div>
</template>
<script>
    export default {
        name: "register",
      data() {
        return {
          registerForm: {
            userno:'',
            password: "",
            password1: "",
            username: "",
            role:''
          },
          flag: true,
          passwordVisible1:'password',
          passwordVisible2:'password',
          icon1:"el-icon-view",
          icon2:"el-icon-view",
        }
      },
      methods: {
        showPass1() {
          if (this.passwordVisible1 === "text") {
            this.passwordVisible1 = "password";
            //更换图标
            this.icon1 = "el-icon-view";
          } else {
            this.passwordVisible1 = "text";
            this.icon1 = "el-icon-lock";
          }
        },
        showPass2() {
          if (this.passwordVisible2 === "text") {
            this.passwordVisible2 = "password";
            //更换图标
            this.icon2 = "el-icon-view";
          } else {
            this.passwordVisible2 = "text";
            this.icon2 = "el-icon-lock";
          }
        },
        submitForm(formName) {
          let r = '/^(?=.*[a-zA-Z])(?=.*\\d)(?=.*[~!@#$%^&*()_+`\\-={}:";\'<>,.\\/]).{6,10}/';
          var Reg = new RegExp(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+`\-={}:";'<>,.\/]).{6,10}/)
          var num =new RegExp(/^[0-9]*$/)
          if(!Reg.test(this.registerForm.password))
          {
            this.$alert('密码规则为：6-10位包含数字、字母、特殊字符的字串', '警告', {
              confirmButtonText: '确定',})
          }
          else if(!num.test(this.registerForm.userno))
          {
            this.$alert('用户账号格式不正确！', '警告', {
              confirmButtonText: '确定',})
          }
          else if(this.registerForm.password1 != this.registerForm.password)
          {
            this.$alert('两次输入密码不一致', '警告', {
              confirmButtonText: '确定',})
          }
          else{
            console.log(this.registerForm.username);
            console.log(this.registerForm.password);
            this.$http.post('/home/index/register',{
              username:this.registerForm.username,
              password:this.registerForm.password,
              role:this.registerForm.role,
              no:this.registerForm.userno
            }).then(res=>{
              console.log(res.data)
              if(res.data.message=="注册成功")
              {
                alert('注册成功')
                this.$router.push({
                  path:'/login',
                  params:{
                    username:this.registerForm.username,
                    password:this.registerForm.password
                  }
                })
              }
              else
              {
                alert(res.data.message)
              }
            }).catch(function (error) {
              console.log(error)
            })
          }

        },
      }
    }
</script>

<style scoped>
  @import "../common/css/login.css";
</style>


