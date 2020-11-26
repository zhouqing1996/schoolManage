<template>
    <!--校长用户-->
  <div>
    <div class="search">
      <span>【校长用户】</span>
      <input value="搜索内容" v-model="searchname"/><button @click="searchName">搜索</button>
      <button @click="dialogFormVisibleadd=true">添加用户</button>
      <!--<button class="btn3 el-icon-circle-plus-outline" @click="dialogFormVisibleadd = true">添加</button>-->
      <el-dialog title="添加用户" :visible.sync="dialogFormVisibleadd">
        <el-form :model="ADDPerson">
          <el-form-item label="用户工号" >
            <el-input style="width: 350px;" v-model="ADDPerson.no" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="用 户 名" >
            <el-input style="width: 350px;" v-model="ADDPerson.username" auto-complete="off"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" style="align-content: center" class="dialog-footer">
          <el-button type="primary" @click="AddPerson">提交</el-button>
          <el-button @click="AddReset">重置</el-button>
        </div>
      </el-dialog>
      <button @click="addP">批量导入</button>
      <input type="file" @change="importExcel(this)" id="inputExcel"
             accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="display: none"/>
      <button>批量导出</button>
    </div>
    <div class="divTable">
      <table>
        <th>序号</th>
        <th>工号</th>
        <th>姓名</th>
        <th>密码</th>
        <th>操作</th>
        <tr v-for="(x,i) in currentPageData">
          <td style="width: 5%">{{i+1}}</td>
          <td style="width: 10%">{{x.no}}</td>
          <td style="width: 10%">{{x.username}}</td>
          <td style="width: 10%">{{x.password}}</td>
          <td style="width: 20%">
            <span class="delete" v-if="x.status==1" @click="deletePerson(x.userid,x.role)"><i class="el-icon-delete"></i>删除</span>
            <span class="delete" v-if="x.status==0" style="color: #FF0000" @click="deletePerson(x.userid,x.role)"><i class="el-icon-delete"></i>(删除)</span>
            <span class="change" @click="PasswordReset(x.userid,x.role)"><i class="el-icon-mouse"></i> 重置密码</span>
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
        name: "master",
      data(){
          return{
            masterList:[],
            //添加用户
            dialogFormVisibleadd:false,
            ADDPerson:{
              username:'',
              no:''
            },
            searchname:'',
            // 翻页相关
            currentPage: 1,
            totalPage: 1,
            pageSize: 10,
            currentPageData:[]
        }
      },
      created(){
          this.getMasterList()
      },
      mounted(){
        this.inputExcel = document.getElementById('inputExcel')
      },
      methods:{
          searchName:function(){
            let that =this
            if(that.searchname=='')
            {
              that.$alert('搜索内容为空！','警告',{
                confirmButtonText:'确定'
              })
            }
            else
            {
              that.$http.post('/admin/user/search',{
                flag:2,
                name:that.searchname
              }).then(function (res) {
                console.log(res.data)
                that.masterList = res.data.data
                that.totalPage =Math.ceil(that.masterList.length/that.pageSize)
                that.totalPage=that.totalPage==0?1:that.totalPage
                that.setCurrentPageDate()
              })
            }

          },
        getMasterList:function ()
          {
            let that = this
            this.$http.post('/admin/user/queryuser',{
              flag:2
            }).then(function (res) {
              console.log(res.data)
              that.masterList = res.data.data
              that.totalPage =Math.ceil(that.masterList.length/that.pageSize)
              that.totalPage=that.totalPage==0?1:that.totalPage
              that.setCurrentPageDate()
            })
          },
        //重置密码
        PasswordReset:function(id,role)
        {
            let that = this
          this.$http.post('/admin/user/resetpassword',{
            flag:role,
            userid:id
          }).then(function (res) {
            console.log(res.data.data)
            that.getMasterList()
          })
        },
        deletePerson:function(id,role)
        {
          this.$confirm('确定删除？',"提示", {
            confirmButtonText: '确定',
            cancelButtonText:'取消'
          }).then(()=>{
            let that =this
            this.$http.post('/admin/user/deleteperson',{
              flag:role,
              userid:id
            }).then(function (res) {
              console.log(res.data.data)
              that.getMasterList()
            })
          })

        },
        AddPerson:function()
        {
          let that =this
          if(that.ADDPerson.no==''||that.ADDPerson.username=='')
          {
            that.$alert('请输入完整添加信息', '警告', {
              confirmButtonText: '确定',})
          }
          else{
            that.$http.post('/admin/user/addperson',{
              flag:2,
              no:that.ADDPerson.no,
              username:that.ADDPerson.username
            }).then(function (res) {
              console.log(res.data)
              alert(res.data.message)
              if(res.data.message=="添加成功！")
              {
                that.dialogFormVisibleadd =false
                that.AddReset()
                that.getMasterList()
              }
            })
          }

        },
        AddReset:function()
        {
          let that =this
          that.ADDPerson.no=''
          that.ADDPerson.username=''
        },
        //批量添加
        addP:function()
        {
          this.inputExcel.click()
        },
        importExcel:function (obj) {
          let _this = this
          let inputDOM = this.$refs.inputer   // 通过DOM取文件数据
          this.file = event.currentTarget.files[0]
          var rABS = false // 是否将文件读取为二进制字符串
          var f = this.file
          var reader = new FileReader()
          // if (!FileReader.prototype.readAsBinaryString) {
          FileReader.prototype.readAsBinaryString = function (f) {
            var binary = ''
            var rABS = false // 是否将文件读取为二进制字符串
            var pt = this
            var wb // 读取完成的数据
            var outdata
            var reader = new FileReader()
            reader.onload = function (e) {
              var bytes = new Uint8Array(reader.result)
              var length = bytes.byteLength
              for (var i = 0; i < length; i++) {
                binary += String.fromCharCode(bytes[i])
              }
              var XLSX = require('xlsx')
              if (rABS) {
                wb = XLSX.read(btoa(fixdata(binary)), { // 手动转化
                  type: 'base64'
                })
              } else {
                wb = XLSX.read(binary, {
                  type: 'binary'
                })
              }
              // outdata就是你想要的东西 excel导入的数据
              outdata = XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]])
              console.log(outdata)
              // excel 数据再处理
              let arr = []
              for(let i=0;i<outdata.length;i++)
              {
                arr.push({
                  no:outdata[i]['工号'],
                  name:outdata[i]['用户名']
                })
              }
              let data = JSON.stringify(arr)
              console.log(data)
              _this.$http.post('/admin/user/importexcel', {
                sdata:data,
                flag:2
              }).then(body => {
                console.log(body.data.data)
                alert(body.data.message)
                _this.getMasterList()
              })
            }
            reader.readAsArrayBuffer(f)
          }
          if (rABS) {
            reader.readAsArrayBuffer(f)
          } else {
            reader.readAsBinaryString(f)
          }
        },
        //分页
        setCurrentPageDate: function () {
          let begin = (this.currentPage - 1) * this.pageSize;
          let end = this.currentPage * this.pageSize;
          this.currentPageData = this.masterList.slice(begin, end)
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
@import "../../../common/css/user.css";
</style>
