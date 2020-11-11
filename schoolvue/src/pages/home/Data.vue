<template>
<div>
  <div style="margin-top: 20px">
    <h1>朔城区神头职业中学校</h1>
  </div>
  <div class="map" v-if="s==1">
    <CalenderHeatmap1 :heatmap="HMList1" :title="htitle1" ></CalenderHeatmap1>
  </div>
  <div class="map" v-if="s==2">
    <CalenderHeatmap1 :heatmap="HMList2" :title="htitle2" ></CalenderHeatmap1>
  </div>
  <div class="map" v-if="s==3">
    <CalenderHeatmap1 :heatmap="HMList3" :title="htitle3" ></CalenderHeatmap1>
  </div>
  <div>
    <BarChart :data="sdata" :title="stitle"></BarChart>
  </div>

</div>
</template>

<script>
    import CalenderHeatmap1 from "../../components/CalenderHeatmap";
    import BarChart from "../../components/BarChart";
    export default {
        name: "Data",
      components: {BarChart, CalenderHeatmap1},
      data(){
          return {
            HMList1:[],
            htitle1:'2020年问卷系统登录情况一览(人次)',
            HMList2:[],
            htitle2:'2020年校企平台登录情况一览(人次)',
            HMList3:[],
            htitle3:'2020年资源管理系统登录情况一览(人次)',
            s:3,
            sdata:[],
            stitle:"新的"
          }
      },
      methods:{
          getBarData:function () {
            var str="abcdefghijklmn";
            for(let i=0;i<100;i++){
              this.sdata.push({
                x:str[Math.floor(Math.random()*(str.length))],
                y:Math.floor(Math.random() * 100)
              })
            }
            console.log(this.sdata)
          },
          getCalHeat1:function () {
            let year = 2020
            var date = +this.$echarts.number.parseDate(year + '-01-01');
            var end = +this.$echarts.number.parseDate((+year) + '-08-27');
            var dayTime = 3600 * 24 * 1000;
            for (var time = date; time < end; time += dayTime) {
              this.HMList1.push({
                dates:this.$echarts.format.formatTime('yyyy-MM-dd', time),
                num: Math.floor(Math.random() * 100)
              });
            }
            // console.log(this.HMList1)
          },
        getCalHeat2:function () {
          let year = 2020
          var date = +this.$echarts.number.parseDate(year + '-01-01');
          var end = +this.$echarts.number.parseDate((+year) + '-08-15');
          var dayTime = 3600 * 24 * 1000;
          for (var time = date; time < end; time += dayTime) {
            this.HMList2.push({
              dates:this.$echarts.format.formatTime('yyyy-MM-dd', time),
              num: Math.floor(Math.random() * 100)
            });
          }
          // console.log(this.HMList2)
        },
        getCalHeat3:function () {
          let year = 2020
          var date = +this.$echarts.number.parseDate(year + '-01-01');
          var end = +this.$echarts.number.parseDate((+year) + '-08-20');
          var dayTime = 3600 * 24 * 1000;
          for (var time = date; time < end; time += dayTime) {
            this.HMList3.push({
              dates:this.$echarts.format.formatTime('yyyy-MM-dd', time),
              num: Math.floor(Math.random() * 100)
            });
          }
          // console.log(this.HMList3)
        }
      },
      created(){
          this.getCalHeat1()
        this.getCalHeat2()
        this.getCalHeat3()
        this.getBarData()
      }
    }
</script>

<style scoped>
.map{
  margin-left: 30px;
  margin-top: 50px;
  color: #909399;
  height: auto;
  width: auto;
  background-color: beige;
  text-align: center;

}
</style>
