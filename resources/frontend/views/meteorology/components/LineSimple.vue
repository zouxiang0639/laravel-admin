<template>
  <div :class="className" :style="{height:height,width:width}"/>
</template>

<script>
  import echarts from 'echarts'

  require('echarts/theme/macarons') // echarts theme
  import resize from './mixins/resize'

  const animationDuration = 6000
  import {getMeteorology} from '@f/api/meteorology/meteorology'

  export default {
    name:"LineSimple",
    mixins: [resize],
    props: {
      equipmentId: {
        type: String|Number,
        default: ''
      },
      typeName: {
        type: String,
        default: ''
      },
      time: {
        type: String,
        default: ''
      },
      className: {
        type: String,
        default: 'chart'
      },
      width: {
        type: String,
        default: '100%'
      },
      height: {
        type: String,
        default: '4.2rem'
      }
    },
    watch: {
      equipmentId(newV,oldV) {
        // do something
        if(newV != oldV) {
          this.getList()

        }
      },
      typeName(newV,oldV) {
        // do something
        if(newV != oldV) {
          this.getList()
          this.getSeries()
          this.initChart()
        }
      },
      time(newV,oldV) {
        // do something
        if(newV != oldV) {
          this.getList()
        }
      }
    },
    data() {
      return {
        chart: null,
        series: [{
          data: [],
          name: '气压',
          type: 'line'
          },
          {
            name: '温度',
            type: 'line',
            data: [],
          },
          {
            name: '湿度',
            type: 'line',
            data: [],
          },
          {
            name: '风速',
            type: 'line',
            data: [],
          }, {
            name: '风向',
            type: 'line',
            data: [],
          }, {
            name: '降雨量',
            type: 'line',
            data: [],
          }, {
            name: '总辐射',
            type: 'line',
            data: [],
          }
        ],
        seriesAll:[],
        date: []
      }
    },
    mounted() {
      this.$nextTick(() => {
        this.getList()
      })
    },
    beforeDestroy() {

      if (!this.chart) {
        return
      }
      this.chart.dispose()
      this.chart = null
    },
    created() {
      //this.getList()
      self.setInterval(this.getList,1000*60*4);
    },
    methods: {
      initChart() {

        let chart = echarts.init(this.$el, 'macarons')
        chart.setOption({
          tooltip: {
            trigger: 'axis',
            axisPointer: { // 坐标轴指示器，坐标轴触发有效
              type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
            }
          },
          grid: {
            top: 10,
            left: '2%',
            right: '2%',
            bottom: '3%',
            containLabel: true
          },
          xAxis: {
            boundaryGap: true,
            type: 'category',
            data: this.date
          },
          yAxis: {
            type: 'value'
          },
          series: this.series
        })

      },
      getList() {
        getMeteorology({
          meteorologyEquipmentId: this.equipmentId,
          time: this.time,
          typeName: this.typeName
        }).then(response => {
          this.series = response.data.series
          this.date = response.data.date
          this.getSeries()
          this.initChart()
        })
      },
      getSeries() {
        if(this.typeName) {
          for(var item in this.series) {
            if (this.series[item].name == this.typeName) {
              this.seriesAll = [this.series[item]]
            }
          }
        } else {
          this.seriesAll = this.series;

        }

      }

    }
  }
</script>
