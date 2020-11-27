<template>
    <!--查看通知-->
  <div>
    <div>
      <el-breadcrumb separator-class="el-icon-arrow-right">
        <el-breadcrumb-item :to="{ path: '/admin/index' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item :to="{path:'/admin/InfoManage/info'}">通知公告</el-breadcrumb-item>
        <el-breadcrumb-item>查看通知</el-breadcrumb-item>
      </el-breadcrumb>
      <el-divider></el-divider>
    </div>
    <div>
      <h1>{{infoList.name}}</h1>
      <span style="color: #0ea0db;"><i class="el-icon-user"></i>{{infoList.auth}}
        <span style="width: 200px"></span>
        <i class="el-icon-date"></i>{{infoList.ctime}}</span>
      <button @click="download(infoId)">下载</button>
      <el-divider></el-divider>
      <div class="content">
        <span v-html="infoList.content"></span>
        <el-divider></el-divider>
      </div>
      <div v-if="infoList.type==1">
        <div class="file">
          <span style="color: #0ea0db;font-weight: bold">共{{infoList.file.length}}个附件</span><br>
            <span v-for="x ,index in infoList.file">
            <a :href="x.filedir">({{index+1}}){{x.filename}}</a>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "LookInfo",
      data(){
          return{
            infoId:'',
            infoList:[]
          }
      },
      created(){
          this.infoId = this.$route.query.id
        this.getInfo()
      },
      methods:{
          getInfo:function () {
            let that = this
            that.$http.post('/admin/info/lookinfo',{
              infoId:that.infoId
            }).then(function (res) {
              console.log(res.data)
              that.infoList = res.data.data
            })
          },
        download:function (id) {
          let that =this
          that.$http.post('/admin/info/downloadinfo',{
            id:id
          }).then(function (res) {
            console.log(res.data.data)
            window.open(res.data.data[0])
          })
        }
      }
    }
</script>

<style scoped>
@import "../../../common/css/info.css";
</style>
