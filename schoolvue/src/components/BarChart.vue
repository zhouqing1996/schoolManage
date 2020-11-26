<template>
  <div>
    <div id="BarChart" :style="{height: '400px',width:'80%'}"></div>
  </div>
</template>

<script>
    export default {
        name: "BarChart",
      data(){
          return{
            Bx:[],
            By:[],
            Btitle:''
          }
      },
      props:["data","title"],
      mounted(){
        this.init()
      },
      watch:{
        data(oldVal, newVal) {
          this.drawBar();
        },
        title(oldVal, newVal) {
          this.drawBar();
        },
      },
      methods:{
          init:function () {
            this.drawBar()
          },
        ToData:function(data,t)
        {
          this.Btitle = t;
          this.Bx = [];
          this.By =[];
          if (data != null) {
            data.forEach((value, index) => {
              this.Bx.push("第"+value.num+"题");
              this.By.push(value.value);
            });
          }
        },
        drawBar:function () {
            this.ToData(this.data,this.title)
          console.log(this.Bx)
          console.log(this.By)
          let myChart = this.$echarts.init(
            document.getElementById("BarChart")
          );
          myChart.setOption({
            title:{
              text:this.Btitle,
              left:'center'
            },
            color:['#3398D8'],
            tooltip:{
              trigger:'axis',
              axisPointer:{
                type:'shadow'
              }
            },
            grid:{
              left: '3%',
              right: '4%',
              bottom: '3%',
              containLabel: true
            },
            xAxis: [
              {
                type: 'category',
                data: this.Bx,
                axisTick: {
                  alignWithLabel: true
                }
              }
            ],
            yAxis: [
              {
                type: 'value'
              }
            ],
            series: [
              {
                name: '错误频次',
                type: 'bar',
                barWidth: '60%',
                data: this.By
              }
            ]
          })
        }
      }
    }
</script>

<style scoped>

</style>
