<template>
  <div class="page">
    <div class="loginwarrp">
      <div class="logo">中学学生档案管理系统</div>
      <div class="login_form">
        <li class="login-item" >
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-user">用户账号：</span>
          <input type="text" v-model="forgetForm.username" class="login_input" placeholder="用户名">
          <span class="error"></span>
        </li>
        <li class="login-item">
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-key">设置新密码：</span>
          <input :type="passwordVisible" v-model="forgetForm.password" class="login_input" placeholder="6-10位包含数字、字母、特殊字符">
          <i slot="suffix" :class="icon" @click="showPass"></i>
          <span class="error"></span>
        </li>
        <li class="login-item">
          <span style="font-size: 20px;color: #0ea0db;" class="el-icon-s-custom">身  份：</span>
          <select v-model="forgetForm.role" placeholder="选择身份">
            <option value="1">父亲</option>
            <option value="2">母亲</option>
            <option value="3">爷爷</option>
            <option value="4">奶奶</option>
            <option value="5">外公</option>
            <option value="6">外婆</option>
            <option value="7">其他</option>
          </select>
          <span class="error"></span>
        </li>
        <div class="clearfix">
          <li class="login-sub">
            <input type="button" value="确认修改密码" v-on:click="pforget">
          </li>
          <span class="error"></span>
        </div>
        <div  >
          <p style="color: #FF0000;">注意：家长的用户账号是学生的学号！</p>
          <span><router-link to="/p/login">有账号？立即登录</router-link></span>
          <span><router-link to="/p/register">没有账号？注册账号</router-link></span>
        </div>
        </div>
      </div>
    </div>
</template>

<script>
  export default {
    name: "pforget.vue",
    data() {
      return {
        passwordVisible:'password',
        icon:"el-icon-view",
        forgetForm: {
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
      pforget() {
        let r = '/^(?=.*[a-zA-Z])(?=.*\\d)(?=.*[~!@#$%^&*()_+`\\-={}:";\'<>,.\\/]).{6,10}/';
        var Reg = new RegExp(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+`\-={}:";'<>,.\/]).{6,10}/)
        if(!Reg.test(this.forgetForm.password))
        {
          this.$alert('密码规则为：6-10位包含数字、字母、特殊字符的字串', '警告', {
            confirmButtonText: '确定',})
        }
        else{
          this.$http.post('/home/index/pforget',{
            no:this.forgetForm.username,
            password:this.forgetForm.password,
            role:this.forgetForm.role
          }).then(res=>{
            console.log(res.data)
            if(res.data.message=="修改密码成功")
            {
              alert('修改密码成功')
              this.$store.dispatch('logout')
              this.$store.dispatch('slogout')
              this.$router.push({
                path:'/p/login',
                params:{
                  username:this.forgetForm.username
                }
              })
            }
            else {
              alert(res.data.message)
            }
          }).catch(function (error) {
            console.log(error)
          })
        }

      },
    },
    created:function () {
      this.forgetForm.username = this.$route.params.username
    }
  }
</script>

<style>
  #poster {
    /*background:url("../assets/eva.jpg") no-repeat;*/
    background-position: center;
    height: 100%;
    width: 100%;
    background-size: cover;
    position: fixed;
  }
  body{
    margin: 0px;
    padding: 0;
  }

  .forget-container {
    border-radius: 15px;
    background-clip: padding-box;
    margin: 90px auto;
    width: 350px;
    padding: 35px 35px 15px 35px;
    background: #fff;
    border: 1px solid #eaeaea;
    box-shadow: 0 0 25px #cac6c6;
  }

  .forget_title {
    margin: 0px auto 40px auto;
    text-align: center;
    color: #505458;
  }

  .other {
    margin-top: 10px;
    font-size: 14px;
    line-height: 22px;
    color: #1ab2ff;
    cursor: pointer;
    text-align: center;
    /*text-indent: 8px;*/
    width: 360px;
  }
  .other:hover {
    /*color: #2c2fd6;*/
  }
</style>
