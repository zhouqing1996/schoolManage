<template>
  <!--管理员主页-->
  <el-container >
    <el-header class="header">
      <el-row :gutter="20">
        <el-col :span="6">
          <span class="logo">
            <img src="../../assets/image/linggan.png" style="width: 30px;height: 30px;"/>
            中学学生档案管理系统
          </span>
        </el-col>
        <el-col :span="16">
          <div style="margin-top: 20px;margin-right:30px;margin-left:30px;float: right">
            <span>新的</span>
            <span>技术支持</span>
            <el-dropdown>
              <el-button type="primary">
                {{username}}
              </el-button>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item>
                  <span>个人信息</span>
                </el-dropdown-item>
                <el-dropdown-item>
                  <span @click="logout">注销</span>
                </el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </div>
        </el-col>
        <el-col :span="2">

        </el-col>
      </el-row>
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
              <span>班级管理</span>
            </template>
            <el-menu-item index="1-1">
              <router-link to="">
                <i class="el-icon-guide"></i>
                目前班级
              </router-link>
            </el-menu-item>
            <el-menu-item index="1-2">
              <router-link to="">
                <i class="el-icon-coin"></i>
                以前班级
              </router-link>
            </el-menu-item>
            <!--<el-menu-item index="1-3">-->
              <!--<router-link to="/admin/userManage/student">-->
                <!--<i class="el-icon-connection"></i>学生用户-->
              <!--</router-link>-->
            <!--</el-menu-item>-->
            <!--<el-menu-item index="1-4">-->
              <!--<router-link to="/admin/userManage/parents">-->
                <!--<i class="el-icon-wallet"></i>家长用户-->
              <!--</router-link>-->
            <!--</el-menu-item>-->
            <!--<el-menu-item index="1-5">-->
              <!--<router-link to="/admin/userManage/useran">-->
                <!--<i class="el-icon-guide"></i>用户数据分析-->
              <!--</router-link>-->
            <!--</el-menu-item>-->
          </el-submenu>
          <el-submenu index="2">
            <template slot="title">
              <i class="el-icon-location"></i>
              <span>学生管理</span>
            </template>
            <el-menu-item index="2-1">
              <router-link to="">
                <i class="el-icon-guide"></i>
                学生信息
              </router-link>
            </el-menu-item>
            <el-menu-item index="2-2">
              <router-link to="">
                <i class="el-icon-coin"></i>
                个性化数据分析
              </router-link>
            </el-menu-item>
          </el-submenu>
          <el-submenu index="3">
            <template slot="title">
              <i class="el-icon-location"></i>
              <span>考试管理</span>
            </template>
            <el-menu-item index="2-1">
              <router-link to="">
                <i class="el-icon-guide"></i>
                新建考试
              </router-link>
            </el-menu-item>
            <el-menu-item index="2-2">
              <router-link to="">
                <i class="el-icon-coin"></i>
                考试信息
              </router-link>
            </el-menu-item>
          </el-submenu>
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
    name: "teacherHome",
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
