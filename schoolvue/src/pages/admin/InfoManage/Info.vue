<template>
    <!--通知管理-->
  <div>
    <div>
      <el-breadcrumb separator-class="el-icon-arrow-right">
        <el-breadcrumb-item :to="{ path: '/admin/index' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>通知管理</el-breadcrumb-item>
        <el-breadcrumb-item>通知列表</el-breadcrumb-item>
      </el-breadcrumb>
      <el-divider></el-divider>
    </div>
    <div v-if="info.length>0" >
      <div v-for="x,index in currentPageData" >
        <span class="infoall">
          <el-row :gutter="20">
            <el-col :span="2"></el-col>
            <el-col :span="16">
              <span @click="LookInfo(x.id)">
              <span class="infotime">{{x.ctime}}</span>
              <span class="infotitle">{{x.name}}</span>
            </span>
            </el-col>
            <el-col :span="2">
              <span class="delInfo" v-if="x.status==1" @click="delInfo(x.id)">删除</span>
              <span  v-else>
                <span class="cgeInfo" @click="changeInfo(x.id)">修改</span>
                <span class="delInfo" @click="del(x.id)">删除</span>
              </span>
            </el-col>
          </el-row>
        </span>
        <el-divider></el-divider>
      </div>
    </div>
    <div v-else>
      暂无通知
    </div>
    <div class="page">
      <ul class="pagination pagination-sm"><!--分页-->
        <li class="page-item" v-if="currentPage!=1">
          <span class="page-link" v-on:click="prePage">上一页</span>
        </li>
        <li class="page-item" >
          <span class="page-link" >第{{ currentPage }}页/共{{totalPage}}页</span>
        </li>
        <li class="page-item" v-if="currentPage!=totalPage">
          <span class="page-link" v-on:click="nextPage">下一页</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
    export default {
        name: "Info",
      data() {
        return{
          info:[],
          // 翻页相关
          currentPage: 1,
          totalPage: 1,
          pageSize: 10,
          currentPageData:[]
        }
      },
      created() {
          this.getInfoList()
      },
      methods:{
          del:function(id)
          {
            let that =this
            that.$http.post('/admin/info/del',{
              id:id
            }).then(function (res) {
              console.log()
              that.getInfoList()
            })
          },
        delInfo:function(id)
        {
          let that =this
          that.$http.post('/admin/info/delinfo',{
            id:id
          }).then(function (res) {
            console.log()
            that.getInfoList()
          })
        },
        changeInfo:function(id)
        {
          let that =this
          that.$http.post('/admin/info/changeinfo',{
            id:id
          }).then(function (res) {
            console.log()
            that.getInfoList()
          })
        },
          getInfoList:function () {
            let that = this
            that.$http.post('/admin/info/getinfo').then(function (res) {
              console.log(res.data)
              that.info =  res.data.data
              that.totalPage =Math.ceil(that.info.length/that.pageSize)
              that.totalPage=that.totalPage==0?1:that.totalPage
              that.setCurrentPageDate()
            })
          },
        LookInfo:function (id) {
          this.$router.push({
            path:'/admin/InfoManage/lookinfo',
            query:{
              id:id
            }
          })
        },
        //分页
        setCurrentPageDate: function () {
          let begin = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          this.currentPageData = this.info.slice(begin, end)
        },
        prePage() {
          console.log(this.currentPage)
          if (this.currentPage == 1)
            return
          this.currentPage--;
          this.setCurrentPageDate()
        },
        nextPage() {
          if (this.currentPage == this.totalPage) return
          this.currentPage++;
          this.setCurrentPageDate()
        },
      }
    }
</script>

<style scoped>
@import "../../../common/css/info.css";
</style>
