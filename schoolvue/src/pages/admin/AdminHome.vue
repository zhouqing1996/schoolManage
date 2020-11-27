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
        <el-col :span="2"><div class="grid-content bg-purple"></div></el-col>
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
            <el-menu-item index="1-5">
              <router-link to="/admin/userManage/useran">
                <i class="el-icon-guide"></i>用户数据分析
              </router-link>
            </el-menu-item>
          </el-submenu>
          <el-submenu index="2">
            <template slot="title">
              <i class="el-icon-document"></i>
              <span slot="title">教学管理</span>
            </template>
            <el-menu-item index="2-1" >
              <router-link to="/admin/JiaoXueManage/gradeInfo">
                <i class="el-icon-guide"></i>
                年级管理
              </router-link>
            </el-menu-item>
            <el-menu-item index="2-2" >
              <router-link to="/admin/JiaoXueManage/subjectInfo">
                <i class="el-icon-guide"></i>
                科目管理
              </router-link>
            </el-menu-item>
            <el-menu-item index="2-3">
              <router-link to="/admin/JiaoXueManage/classinfo">
                <i class="el-icon-menu"></i>
                班级管理
              </router-link>
            </el-menu-item>
          </el-submenu>
          <el-submenu index="3">
          <template slot="title">
            <i class="el-icon-document"></i>
            <span slot="title">档案管理</span>
          </template>
          <el-menu-item index="3-1" >
            <router-link to="">
              <i class="el-icon-setting"></i>
              学生信息
            </router-link>
          </el-menu-item>
          <el-menu-item index="3-2" >
            <router-link to="">
              <i class="el-icon-guide"></i>
              学科考试
            </router-link>
          </el-menu-item>
          <el-menu-item index="3-3">
            <router-link to="">
              <i class="el-icon-menu"></i>
              其他
            </router-link>
          </el-menu-item>
        </el-submenu>
          <el-submenu index="4">
            <template slot="title">
              <i class="el-icon-document"></i>
              <span slot="title">通知管理</span>
            </template>
            <el-menu-item index="4-1" >
              <router-link to="/admin/InfoManage/info">
                <i class="el-icon-setting"></i>
                通知公告
              </router-link>
            </el-menu-item>
            <el-menu-item index="4-2" >
              <router-link to="/admin/InfoManage/newinfo">
                <i class="el-icon-guide"></i>
                新建通知
              </router-link>
            </el-menu-item>
            <el-menu-item index="4-3">
              <router-link to="/admin/InfoManage/downloadinfo">
                <i class="el-icon-menu"></i>
                附件下载
              </router-link>
            </el-menu-item>
          </el-submenu>
          <el-submenu index="5">
            <template slot="title">
              <i class="el-icon-document"></i>
              <span slot="title">文件管理</span>
            </template>
            <el-menu-item index="5-1" >
              <router-link to="">
                <i class="el-icon-setting"></i>
                文件列表
              </router-link>
            </el-menu-item>
            <el-menu-item index="5-2" >
              <router-link to="">
                <i class="el-icon-guide"></i>
                上传文件
              </router-link>
            </el-menu-item>
            <el-menu-item index="5-3">
              <router-link to="">
                <i class="el-icon-menu"></i>
                下载专区
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
