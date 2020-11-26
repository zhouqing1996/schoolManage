<template>
    <div>
      <PieChart :sdata="PieData1" :t="pieTitle1" :subt="pieStitle1"></PieChart>
      <div >
        <PieChart :sdata="PieData2" :t="pieTitle2" :subt="pieStitle2" ></PieChart>
        <PieChart :sdata="PieData3" :t="pieTitle3" :subt="pieStitle3" ></PieChart>
        <PieChart :sdata="PieData4" :t="pieTitle4" :subt="pieStitle4" ></PieChart>
      </div>
    </div>
</template>

<script>
    import PieChart from "../../../components/PieChart";
    export default {
        name: "userAnalysisi",
      components: {PieChart},
      data(){
          return{
            PieData1:[],
            pieTitle1:'系统中用户角色的数据',
            pieStitle1:'身份：管理员，校长，教师，学生，家长用户',
            PieData2:[],
            pieTitle2:'系统中用户性别的数据分析',
            pieStitle2:'身份：校长',
            PieData3:[],
            pieTitle3:'系统中用户性别的数据分析',
            pieStitle3:'身份：教师',
            PieData4:[],
            pieTitle4:'系统中用户性别的数据分析',
            pieStitle4:'身份：学生',
          }
      },
      created() {
          this.getPieData()
      },
      methods:{
          getPieData:function () {
            let that =this
            that.$http.post('/admin/useran/userrole').then(function (res) {
              console.log(res.data)
              that.PieData1 = []
              let list = res.data.data
              for(let i=0;i<list.length;i++)
              {
                that.PieData1.push({
                  num:list[i].name,
                  value:list[i].num
                })
              }
              console.log(that.PieData1)
            })

            that.$http.post('/admin/useran/usersex').then(function (res) {
              console.log(res.data)
              that.PieData2 = []
              let list2 = res.data.data[0]
              for(let i=0;i<list2.length;i++)
              {
                that.PieData2.push({
                  num:list2[i].sex,
                  value:list2[i].num
                })
              }
              that.PieData3 = []
              let list3 = res.data.data[1]
              for(let i=0;i<list3.length;i++)
              {
                that.PieData3.push({
                  num:list3[i].sex,
                  value:list3[i].num
                })
              }

              that.PieData4 = []
              let list4 = res.data.data[2]
              for(let i=0;i<list4.length;i++)
              {
                that.PieData4.push({
                  num:list4[i].sex,
                  value:list4[i].num
                })
              }
              console.log(that.PieData2)
              console.log(that.PieData3)
              console.log(that.PieData4)

            })
          }
      }
    }
</script>

<style scoped>

</style>
