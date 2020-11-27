<template>
  <!--新建通知-->
  <div>
    <div>
      <el-breadcrumb separator-class="el-icon-arrow-right">
        <el-breadcrumb-item :to="{ path: '/admin/index' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>通知管理</el-breadcrumb-item>
        <el-breadcrumb-item>新建通知</el-breadcrumb-item>
      </el-breadcrumb>
      <el-divider></el-divider>
    </div>
    <div>
      <el-form :model="addList">
        <el-form-item>
          <input v-model="addList.title" class="inputTitle" placeholder="输入标题"></input>
        </el-form-item>
        <div class="rich-html">
          <vue-html5-editor :content="addList.content" :height="200" @change="updateData">
          </vue-html5-editor>
        </div>
        <el-form-item>
          <button type="button" class="btn2 el-icon-circle-plus-outline" @click="addFileItem">添加附件</button>
        </el-form-item>
        <el-form-item v-if="addList.fileList.length>0" v-cloak>
              <el-form-item v-for="(item,index) in addList.fileList" :key="index">
                <el-upload
                  action=""
                  :before-upload="beforeUpload"
                  :on-preview="handlePreview"
                  :on-remove="handleRemove"
                  :on-success="handleSuccess"
                  multiple
                  :limit="1"
                  :http-request="uploadfile"
                  :on-change="onchange">
                  <el-button size="small" type="primary" >上传</el-button>
                  <div slot="tip" class="el-upload__tip">最多上传1个文件</div>
                </el-upload>
                <el-button @click="deleteFileItem(index)" class="deleteItem">删除项目</el-button>
              </el-form-item>
        </el-form-item>
        <el-form-item>
          <div>
            <button class="btn2 el-icon-circle-check" @click ="Sumbit">完成</button>
          </div>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
    export default {
        name: "NewInfo",
      data()
      {
        return {
          addList:{
            title:'',
            content:'',
            fileList:[],
          },
          fileAdd:false,
          filename:[],
          filedir:[],
          uid:this.$store.getters.getsId
        }
      },
      created()
      {

      },
      methods:{
        updateData (e="") {
          console.log(e)
          let c1 = e.replace(/<img width="30%"/g, "<img");
          let c2 = c1.replace(/<img/g, '<img width="30%"');
          this.addList.content = c2
          console.log(this.addList.content)
        },
        Reset:function()
        {
          this.addList.title='';
          this.addList.content ='';
          this.addList.fileList = []
          this.filename=[]
          this.filedir=[]
        },
        Sumbit:function () {
          let that = this
          if(that.addList.title==''||that.addList.content=='')
          {
            that.$alert('通知内容不完整！','提示',{
              confirmButtonText:'确定',
              type:'warning'
            })
          }
          else {
            for(let i=0;i<that.filedir.length;i++)
            {
              that.addList.fileList[i]['filename']=that.filename[i]
              that.addList.fileList[i]['filedir']=that.filedir[i]
            }
            console.log(that.addList)
            that.$http.post('/admin/info/addinfo',{
              title:that.addList.title,
              content:that.addList.content,
              file:that.addList.fileList,
              uid:that.uid
            }).then(function (res) {
              console.log(res.data)
              if(res.data.message=="添加通知公告成功") {
                that.$alert(res.data.message,'提示',{
                  confirmButtonText:'确定',
                  type:'warning'
                })
                that.$router.push({
                  path:'/admin/InfoManage/lookinfo',
                  query:{
                    id:res.data.data
                  }
                })
                that.Reset()
              }
              else {
                that.$alert('添加失败！','提示',{
                  confirmButtonText:'确定',
                  type:'warning'
                })
              }
            })
          }
        },
        beforeUpload (file) {
          let fd = new FormData()
          fd.append('file', file)
          let that = this
          that.$http.post('/admin/info/uploadfile', fd).then(function (res) {
            console.log(res)
            that.filename.push(res.data.data[1])
            that.filedir.push(res.data.data[2])
          })
        },
        // 点击移除文件按钮触发
        handleRemove (file, fileList) {
          console.log(file,fileList)
        },
        handlePreview (file) {
          console.log(file)
        },
        handleSuccess (index) {
        },
        // 覆盖默认的提交动作
        uploadfile (id) {
        },
        // 文件上传成功可触发
        onchange (index) {
        },
        addFileItem:function () {
          this.addList.fileList.push({
            filename:'',
            filedir:''
          })
        },
        deleteFileItem:function (id) {
          this.addList.fileList.splice(id,1)
          this.filename.splice(id,1)
          this.filedir.splice(id,1)
        },
      }
    }
</script>

<style scoped>
@import "../../../common/css/info.css";
</style>
