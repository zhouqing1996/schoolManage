<template>
    <!--管理员主页-->
  <el-container >
    <el-header class="header">
      <div >
        <span class="logo">
            <img src="../../assets/image/linggan.png" style="width: 30px;height: 30px;"/>
            中学学生档案管理系统
          </span>
        <div >
          <span class="nav1" ><i class="el-icon-sunny">新的</i> </span>
          <span class="nav2"><i class="el-icon-position">技术支持</i></span>
          <ul class="nav ul a">
            <a herf="#" class="ul a">
              <i class="el-icon-user"></i>
              {{username}}</a>
            <ul class="plat ul a">
              <li><a href="http://www.baidu.com">个人信息</a></li>
              <li><a @click="logout">注销</a></li>
            </ul>
          </ul>
        </div>
      </div>
    </el-header>
    <el-container>
      <el-aside class="aside" style="width: 200px">
        <el-menu
          background-color="#545c64"
          text-color="#fff"
          active-text-color="#ffd04b"
          :unique-opened="true"
          style="font-size: 30px;color: #45B549;width: 200px">
          <el-submenu index="1">
            <template slot="title">
              <i class="el-icon-location"></i>
              <span>用户管理</span>
            </template>
            <el-menu-item index="1-1">
              <router-link to="/admin/userManage/master">
                <i class="el-icon-guide"></i>校长用户
              </router-link>
            </el-menu-item>
            <el-menu-item index="1-2">
              <router-link to="/admin/userManage/teacher">
              <i class="el-icon-coin"></i>教师用户
              </router-link>
            </el-menu-item>
            <el-menu-item index="1-3">
              <router-link to="/admin/userManage/student">
              <i class="el-icon-connection"></i>学生用户
              </router-link>
            </el-menu-item>
            <el-menu-item index="1-4">
              <router-link to="/admin/userManage/parents">
              <i class="el-icon-wallet"></i>家长用户
              </router-link>
            </el-menu-item>
            <el-menu-item index="1-4">
              <router-link to="/admin/userManage/useran">
                <i class="el-icon-guide"></i>用户数据分析
              </router-link>
            </el-menu-item>
          </el-submenu>
          <el-menu-item index="2">
            <i class="el-icon-menu"></i>
            <span >班级管理</span>
          </el-menu-item>
          <el-menu-item index="3" >
            <i class="el-icon-document"></i>
            <span slot="title">班级分配</span>
          </el-menu-item>
          <el-menu-item index="4">
            <i class="el-icon-setting"></i>
            <span slot="title">毕业生问题</span>
          </el-menu-item>
<!--          <el-submenu index="5">-->
<!--            <template slot="title">-->
<!--              <i class="el-icon-location"></i>-->
<!--              <span>用户管理</span>-->
<!--            </template>-->
<!--            <el-menu-item index="5-1">-->
<!--              <router-link to="/admin/userManage/master">-->
<!--                <i class="el-icon-guide"></i>校长用户</router-link>-->
<!--              </el-menu-item>-->
<!--            <el-menu-item index="5-2">-->
<!--              <i class="el-icon-coin"></i>教师用户</el-menu-item>-->
<!--            <el-menu-item index="5-3">-->
<!--              <i class="el-icon-connection"></i>学生用户</el-menu-item>-->
<!--            <el-menu-item index="5-4">-->
<!--              <i class="el-icon-wallet"></i>家长用户</el-menu-item>-->
<!--          </el-submenu>-->
        </el-menu>
      </el-aside>
      <el-container>
        <el-main class="main">
          <router-view/>
        </el-main>
        <el-footer class="footer">
          <p>Copyrights©2020-{{CurrentYear}} by @zhouqing.</p>
        </el-footer>
      </el-container>
      </el-container>
  </el-container>
</template>

<script>
    export default {
        name: "AdminHome",
      data(){
        var copyright=new Date();
        var update=copyright.getFullYear()
        return {
          CurrentYear:update,
          Height:0,
          username:this.$store.getters.getsName
        }
      },
      methods:{
        logout:function () {
          let suserid = this.$store.getters.getsId
          console.log(suserid)
          let that = this
          this.$confirm("是否退出？", "提示", {
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            type: "warning"
          }).then(function (res) {
            that.$store.dispatch('slogout')
            alert("退出成功！")
            that.$router.push({path: '/login'})
          }).catch(function (err) {
            console.log(err)
          })
        }
      }
    }
</script>

<style scoped>
@import "../../common/css/home.css";
</style>
