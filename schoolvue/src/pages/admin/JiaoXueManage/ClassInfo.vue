<template>
    <!--班级信息-->
  <div>
    <div>
      <el-breadcrumb separator-class="el-icon-arrow-right">
        <el-breadcrumb-item :to="{ path: '/admin/index' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>班级管理</el-breadcrumb-item>
      </el-breadcrumb>
      <el-divider></el-divider>
    </div>
    <div>
      <span class="search">
        <input v-model="searchName" placeholder="班级"/>
        <button>搜索</button>
      </span>
      <button @click="dialogadd=true">添加班级</button>
      <el-dialog title="添加班级" :visible.sync="dialogadd">
        <el-form :model="ClassAdd">
          <el-form-item label="班级编号" >
            <el-input style="width: 350px;" v-model="ClassAdd.ClassId" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="班级名" >
            <el-input style="width: 350px;" v-model="ClassAdd.ClassName" auto-complete="off"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" style="align-content: center" class="dialog-footer">
          <el-button type="primary" @click="ClassSubmit">提交</el-button>
          <el-button @click="ClassReset">重置</el-button>
        </div>
      </el-dialog>
    </div>
    <div class="divTable">
      <!--内容-->
      <table>
        <th>序号</th>
        <th>班级编号</th>
        <th>班级名</th>
        <th>操作</th>
        <tr v-for="x,index in currentPageData">
          <td>{{index+1}}</td>
          <td>{{x.classid}}</td>
          <td>{{x.classname}}</td>
          <td>
            <span v-if="x.status==1" @click="delClass(x.id)" class="delete">删除</span>
            <span v-else >
              <span class="change" @click="changeClass(x.id)">
                恢复
              </span>
              <span class="delete" @click="del(x.id)">
                删除
              </span>
            </span>
          </td>
        </tr>
      </table>
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
        name: "ClassInfo",
      data()
      {
        return{
          searchName:'',
          ClassList:[],
          dialogadd:false,
          ClassAdd:{
            ClassId:'',
            ClassName:''
          },
          // 翻页相关
          currentPage: 1,
          totalPage: 1,
          pageSize: 10,
          currentPageData:[]
        }
      },
      created() {
          this.getClassInfo()
      },
      methods:{
        //  恢复班级信息
        changeClass:function(id)
        {
          let that = this
          that.$http.post('/admin/classinfo/changeclass',{
            id:id
          }).then(function (res) {
            console.log(res.data)
            that.$alert('恢复成功！', '提示', {
              confirmButtonText: '确定',
              type: 'warning'
            })
            that.getClassInfo()
          })
        },
        //  删除班级信息
        del:function(id)
        {
          let that = this
          that.$http.post('/admin/classinfo/del',{
            id:id
          }).then(function (res) {
            console.log(res.data)
            that.$alert('删除成功！', '提示', {
              confirmButtonText: '确定',
              type: 'warning'
            })
            that.getClassInfo()
          })
        },
        //  删除班级信息
        delClass:function(id)
        {
          let that = this
          that.$http.post('/admin/classinfo/delclass',{
            id:id
          }).then(function (res) {
            console.log(res.data)
            that.$alert('删除成功！', '提示', {
              confirmButtonText: '确定',
              type: 'warning'
            })
            that.getClassInfo()
          })
        },
        //  添加班级
        ClassSubmit:function()
        {
          let that =this
          let Reg = new RegExp(/^[0-9]*$/)
          if(!Reg.test(that.ClassAdd.ClassId))
          {
            that.$alert('班级编号应为数字！', '提示', {
              confirmButtonText: '确定',
              type: 'warning'
            })
          }
         else if(that.ClassAdd.ClassId==''||that.ClassAdd.ClassName=='')
          {
            that.$alert('填写完整班级的信息！', '提示', {
              confirmButtonText: '确定',
              type: 'warning'
            })
          }
          else
          {
            that.$http.post('/admin/classinfo/addclass',{
              id:that.ClassAdd.ClassId,
              name:that.ClassAdd.ClassName
            }).then(function (res) {
              console.log(res.data)
              if(res.data.data==1)
              {
                that.$alert('添加班级成功', '提示', {
                  confirmButtonText: '确定',
                  type: 'success'
                })
              }
              else
              {
                that.$alert(res.data.message, '提示', {
                  confirmButtonText: '确定',
                  type: 'info'
                })
              }
              that.getClassInfo()
              that.dialogadd=false
              that.ClassReset()
            })
          }
        },
        ClassReset:function()
        {
          this.ClassAdd.ClassName=''
          this.ClassAdd.ClassId=''
        },
        //  全部班级信息
        getClassInfo:function()
        {
          let that =this
          that.$http.post('/admin/classinfo/classinfo').then(function (res) {
            console.log(res.data)
            that.ClassList = res.data.data
            that.totalPage =Math.ceil(that.ClassList.length/that.pageSize)
            that.totalPage=that.totalPage==0?1:that.totalPage
            that.setCurrentPageDate()
          })
        },
        //分页
        setCurrentPageDate: function () {
          let begin = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          this.currentPageData = this.ClassList.slice(begin, end)
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
@import "../../../common/css/classM.css";
</style>
