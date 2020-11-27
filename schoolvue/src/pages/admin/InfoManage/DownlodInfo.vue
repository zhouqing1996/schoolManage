<template>
    <!--信息附件下载-->
  <div>
    <div>
      <el-breadcrumb separator-class="el-icon-arrow-right">
        <el-breadcrumb-item :to="{ path: '/admin/index' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>通知管理</el-breadcrumb-item>
        <el-breadcrumb-item>附件下载</el-breadcrumb-item>
      </el-breadcrumb>
      <el-divider></el-divider>
    </div>
    <div v-if="file.length>0" >
      <div v-for="x,index in currentPageData" v-if="index%4==0">
        <el-row :gutter="20">
          <el-col :span="5" >
            <a :href="x.dir">{{x.name}}</a>
          </el-col>
          <el-col :span="5" v-if="index+1<currentPageData.length">
            <a :href="currentPageData[index+1].dir">{{currentPageData[index+1].name}}</a>
          </el-col>
          <el-col :span="5" v-if="index+2<currentPageData.length" >
            <a :href="currentPageData[index+2].dir">{{currentPageData[index+2].name}}</a>
          </el-col>
          <el-col :span="5" v-if="index+3<currentPageData.length">
            <a :href="currentPageData[index+3].dir">{{currentPageData[index+3].name}}</a>
          </el-col>
          <el-divider></el-divider>
        </el-row>
      </div>
    </div>
    <div v-else>
      暂无文件可供下载
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
        name: "DownlodInfo",
      data() {
        return{
          file:[],
          // 翻页相关
          currentPage: 1,
          totalPage: 1,
          pageSize: 40,
          currentPageData:[]
        }
      },
      created() {
        this.getFileList()
      },
      methods:{
        getFileList:function () {
          let that = this
          that.$http.post('/admin/info/getfile').then(function (res) {
            console.log(res.data)
            that.file =  res.data.data
            that.totalPage =Math.ceil(that.file.length/that.pageSize)
            that.totalPage=that.totalPage==0?1:that.totalPage
            that.setCurrentPageDate()
          })
        },
        //分页
        setCurrentPageDate: function () {
          let begin = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          this.currentPageData = this.file.slice(begin, end)
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
