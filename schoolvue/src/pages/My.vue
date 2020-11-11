<template>
  <!--我的资料-->
  <div>
    <div class="back">
      <el-page-header @back="back">
      </el-page-header>
    </div>
    <div>
      <el-form class="my-container" label-position="left" label-width="0px">
        <h3 class="my_title">我的资料</h3>
        <p>用户编号：{{this.userid}}</p>
        <p>用户名：{{this.username}}</p>
        <p v-if="this.userrole==1">身份：网站管理员</p>
        <p v-if="this.userrole==2">身份：教师</p>
        <p v-if="this.userrole==3">身份：学生</p>
      </el-form>
    </div>

  </div>
</template>

<script>
  export default {
    name: "my",
    data(){
      return {
        userid:this.$store.getters.getsId,
        username:this.$store.getters.getsName,
        userrole:this.$store.getters.getsRole,
      }
    },
    methods:{
      back:function()
      {
        let that = this
        if(that.userrole==1)
        {
          this.$router.push({
            path:'/question',
          })
        }
        else {
          this.$router.push({
            path:'/u/question',
          })
        }

      },
    }
  }
</script>

<style scoped>
  .back{
    margin-top: 30px;
    margin-bottom: 20px;
  }
  .my-container {
    border-radius: 15px;
    background-clip: padding-box;
    margin: 90px auto;
    width: 350px;
    padding: 35px 35px 15px 35px;
    background: #fff;
    border: 1px solid #eaeaea;
    box-shadow: 0 0 25px #cac6c6;
  }
  .my_title {
    margin: 0px auto 40px auto;
    text-align: center;
    color: #505458;
  }
</style>
