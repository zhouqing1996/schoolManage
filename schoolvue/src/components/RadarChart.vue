<template>
    <!--雷达图-->
  <div>
    <div id="Radar" :style="{height: '400px',width:'400px'}"></div>
  </div>
</template>

<script>
    export default {
      name: "RadarChart",
      data() {
        return{
          rtitle:'得分雷达图' ,
          facts:{
            NC:0,
            NF:0,
            NJ:0,
            NP:0,
            NM:0
          },
          reals:{
            NC:0,
            NF:0,
            NJ:0,
            NP:0,
            NM:0
          },
          //数据刷新
          timer:null
        }
      },
      props:["fact","real"],
      mounted(){
        // this.init();
        let that =this
        if(that.timer)
        {
          clearInterval(that.timer)
        }
        else{
          that.timer=setInterval(()=>{
            that.init()
          },1000)
        }
        console.log(that.timer)

      },
      watch:{
        fact(oldVal, newVal) {
          this.drawRadar();
        },
        real(oldVal,newVal){
          this.drawRadar()
        }
      },
      beforeDestroy(){
        clearInterval(this.timer)
      },
      methods:{
        init() {
          this.drawRadar();
        },
        toData(f,r)
        {
          this.facts.NC = f.NC
          this.facts.NF = f.NF
          this.facts.NP = f.NP
          this.facts.NJ = f.NJ
          this.facts.NM = f.NM
          this.reals.NC = r.NC
          this.reals.NF = r.NF
          this.reals.NP = r.NP
          this.reals.NJ = r.NJ
          this.reals.NM = r.NM
        },
        //  画图
        drawRadar:function () {
          this.toData(this.fact,this.real)
          let myRadarChart = this.$echarts.init(
            document.getElementById("Radar")
          );
          myRadarChart.setOption(
            {
              title:{
                text:this.rtitle
              },
              tooltip:{},
              legend:{
                data:['选择题','填空题','判断题','多选题','程序题']
              },
              radar:{
                name:{
                  textStyle:{
                    color:'#FFF',
                    backgroundColor:'#999',
                    borderRadius:3,
                    padding:[3,4]
                  }
                },
                indicator:[
                  {name:'选择题',max:this.facts.NC},
                  {name:'填空题',max:this.facts.NF},
                  {name:'判断题',max:this.facts.NJ},
                  {name:'多选题',max:this.facts.NM},
                  {name:'程序题',max:this.facts.NP},
                ]
              },
              series:[{
                // name
                type:'radar',
                data:[
                  {
                    value:[this.reals.NC,this.reals.NF,this.reals.NJ,this.reals.NM,this.reals.NP],
                    name:'做对的题目数'
                  }
                ]
              }]
            });
        }
      }
    }
</script>

<style scoped>

</style>
