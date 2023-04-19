<template>
  <div>
    <div class="meteorology">
      <div class="info-meteorology">
        <div class="head">
          <h1>{{getName()}}</h1>
          <div class="weather"><span> <el-button @click="goBack()">返回</el-button></span><!--<img src="picture/weather.png"><span>多云转小雨</span>--><span id="showTime"></span></div>
        </div>
        <div >
          <ul class="clearfix">
            <li>
              <div class="boxall" style="height:5rem;width: 100%">
                <div class="allnav">
                  <maps height="4.7rem" :equipmentId="equipmentId" />
                </div>
                <div class="boxfoot"></div>
              </div>
              <div class="boxall" style="height: 4.9rem;">
                <div class="alltitle" style="padding-top: 0.1rem">
                  <el-select v-model="equipmentId" filterable placeholder="请选择">
                    <el-option
                      v-for="item in meteorology.equipment"
                      :key="item.id"
                      :label="item.name"
                      :value="item.id">
                    </el-option>
                  </el-select>
                  <el-select v-model="typeName" filterable placeholder="请选择">
                    <el-option
                      v-for="item in type"
                      :key="item.id"
                      :label="item.name"
                      :value="item.key">
                    </el-option>
                  </el-select>
                  <el-date-picker
                    v-model="time"
                    type="date"
                    value-format="yyyy-MM-dd"
                    placeholder="选择日期">
                  </el-date-picker>

                </div>
                <div class="allnav">
                  <line-simple :equipmentId="equipmentId" :typeName="typeName" :time="time"/>
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
    </div>

  </div>
</template>

<script>
  import BarChart from './components/BarChart'
  import TerminalSummary from './components/TerminalSummary'
  import Information from './components/Information'
  import LineSimple from './components/LineSimple'
  import Maps from './components/Maps'
  import Vue from 'vue';
  import {Tabs,TabPane,Select,Option,DatePicker,Button,Dialog} from 'element-ui';
  import {getHome} from "@f/api/meteorology/meteorology";
  import 'element-ui/lib/theme-chalk/date-picker.css';
  import 'element-ui/lib/theme-chalk/dialog.css';
  import 'element-ui/lib/theme-chalk/button.css';
  Vue.use(Select);
  Vue.use(Dialog);
  Vue.use(Option);
  Vue.use(Tabs);
  Vue.use(TabPane);
  Vue.use(DatePicker);
  Vue.use(Button);


  export default {
    name: 'MeteorologyShow',
    components: {
      BarChart,
      TerminalSummary,
      Information,
      LineSimple,
      Maps
    },
    watch: {
      '$route' (to, from) {
        this.equipmentId = parseInt( this.$route.params && this.$route.params.id)
      }
    },
    data() {
      return {
        dialogFormVisible: false,
        equipmentId: 0,
        time: '',
        activeName: 'second',
        meteorology: {
          onLine : 0,
          count : 0,
          equipment : [],
          equipmentCity : {
            'name': [],
            'count': [],
          }
        },
        type:[
          {'name': '气压','key': 'pressure'},
          {'name': '温度','key': 'temperature'},
          {'name': '湿度','key': 'humidity'},
          {'name': '风速','key': 'wind_speed'},
          {'name': '风向','key': 'wind_direction'},
          {'name': '降雨量','key': 'rainfall'},
          {'name': '总辐射','key': 'total_radiation'},
        ],
        typeName :'pressure'
      }
    },
    created() {
      this.equipmentId = parseInt( this.$route.params && this.$route.params.id)
      this.getHome()
      var whei = document.body.clientWidth
      document.getElementsByTagName("html")[0].setAttribute("style","font-size:"+whei/20+"px")
    },
    mounted() {
      let height = window.screen.height
      document.getElementsByClassName("meteorology")[0].setAttribute("style","height:"+height+"px");
    },
    methods: {
      getHome() {
        getHome().then(response => {
          this.meteorology = response.data
        })
      },
      getName() {
        for(var item in this.meteorology.equipment) {
          if (this.meteorology.equipment[item].id == this.equipmentId) {
            return this.meteorology.equipment[item].name
          }
        }
      },
      goBack() {
        this.$router.push({
          name: 'Home',
        })
      },
    }

  }
</script>

<style lang="scss" scoped>

  @import "~@f/styles/comon0.scss";
  .bar{
    margin-bottom: 0.15rem;
  }
</style>
<style lang="scss">
  .info-meteorology {
    .el-input__inner {
      background-color: rgba(165, 165, 165, 0.1);
      border-color: #409EFF;

      color: white;

    }
    .el-button,.el-button:hover{
      display: inline-block;
      line-height: 1;
      white-space: nowrap;
      cursor: pointer;
      background-color: rgba(165, 165, 165, 0.1);
      color: white;
      border-color: #409EFF;
    }
  }

  #info-window .info p{

    line-height: 0.17rem !important;
    font-size: 0.2rem;
    font-weight: 300;
    color: #111213;

  }



</style>
