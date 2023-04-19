<template>
  <div class="meteorology">


    <div class="head">
      <h1>{{title}}</h1>
      <div class="weather"><!--<img src="picture/weather.png"><span>多云转小雨</span>--><span id="showTime"></span></div>
    </div>
    <div class="mainbox">
      <ul class="clearfix">
        <li>
          <div class="boxall" style="height: 4.6rem;">
            <div class="alltitle">终端概括</div>
            <div class="allnav">
              <terminal-summary :equipment="meteorology.equipment"/>
            </div>
            <div class="boxfoot"></div>
          </div>
          <div class="boxall" style="height: 5.2rem">
            <div class="alltitle">气象站分布情况</div>
            <div class="allnav">
              <bar-chart :equipmentCity="meteorology.equipmentCity"/>
            </div>
            <div class="boxfoot"></div>
          </div>
        </li>
        <li>
          <div class="bar">
            <div class="barbox">
              <ul class="clearfix">
                <li class="pulll_left counter">{{meteorology.count}}</li>
                <li class="pulll_left counter">{{meteorology.onLine}}</li>
              </ul>
            </div>
            <div class="barbox2">
              <ul class="clearfix">
                <li class="pulll_left">气象站总数</li>
                <li class="pulll_left">在线数</li>
              </ul>
            </div>
          </div>
          <div class="map">
            <!--            <div class="map1"><img src="picture/lbx.png"></div>-->
            <!--            <div class="map2"><img src="picture/jt.png"></div>-->
            <!--            <div class="map3"><img src="picture/map.png"></div>-->
            <div class="map4 boxall" id="map_1" style="height: 8.2rem;">
              <div class="allnav">
                <maps :equipmentId="equipmentId" height="7.9rem" lineHeight="0.01rem"/>
              </div>
              <div class="boxfoot"></div>
            </div>
          </div>
        </li>
        <li>
          <div class="boxall" style="height:4.8rem">
            <div class="alltitle">
              <el-select v-model="equipmentId" filterable placeholder="请选择">
                <el-option
                  v-for="item in meteorology.equipment"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id">
                </el-option>
              </el-select>
            </div>
            <div class="allnav">
              <line-simple :equipmentId="equipmentId"/>
            </div>
            <div class="boxfoot"></div>
          </div>
          <div class="boxall" style="height: 5rem;">
            <div class="alltitle">预警信息</div>
            <div class="allnav">
              <information/>
            </div>
            <div class="boxfoot"></div>
          </div>
          <!--          <div class="boxall" style="height: 3rem">-->
          <!--            <div class="alltitle">模块标题样式</div>-->
          <!--            <div class="allnav" id="echart6"></div>-->
          <!--            <div class="boxfoot"></div>-->
          <!--          </div>-->
        </li>
      </ul>
    </div>
    <div class="back"></div>
  </div>
</template>

<script>
  import BarChart from './components/BarChart'
  import TerminalSummary from './components/TerminalSummary'
  import Information from './components/Information'
  import LineSimple from './components/LineSimple'
  import Maps from './components/Maps'
  import {getHome} from '@f/api/meteorology/meteorology'
  import {Select, Option} from 'element-ui';
  import Vue from 'vue';

  Vue.use(Select);
  Vue.use(Option);

  export default {
    name: 'Meteorology',
    components: {
      BarChart,
      TerminalSummary,
      Information,
      LineSimple,
      Maps
    },
    data() {
      return {
        title: process.env.APP_TITLE,
        equipmentId: '',
        meteorology: {
          onLine: 0,
          count: 0,
          equipment: [],
          equipmentCity: {
            'name': [],
            'count': [],
          }
        }
      }
    },
    created() {
      let whei = document.body.clientWidth
      self.setInterval(this.getHome, 1000 * 60 * 5);
      document.getElementsByTagName("html")[0].setAttribute("style", "font-size:" + whei / 20 + "px")

      this.getHome()
    },
    mounted() {
      let height = window.screen.height
      document.getElementsByClassName("meteorology")[0].setAttribute("style", "height:" + height + "px");
    },
    methods: {
      getHome() {
        getHome().then(response => {
          this.meteorology = response.data
          this.equipmentId = response.data.equipment[0].id
        })
      },

    }

  }
</script>

<style lang="scss" scoped>
  $menuText: 11.3rem;
  @import "~@f/styles/comon0.scss";
  .bar {
    margin-bottom: 0.15rem;
  }

  .el-input__inner {
    background-color: #511111;

    border: 1px solid #DCDFE6;
    color: #606266;

  }
</style>
<style lang="scss">

  .el-input__inner {
    background-color: rgba(165, 165, 165, 0.1);
    border-color: #409EFF;

    color: white;

  }
</style>
