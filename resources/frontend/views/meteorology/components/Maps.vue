<template>

  <div id="app">
    <div class="amap-page-container">
      <div class="toolbar">当前坐标: {{ lng }}, {{ lat }}</div>
      <el-amap
        vid="amapDemo"
        :center="center"
        :zoom="zoom"
        :plugin="plugin"
        :style="{height:height}"
        :events="events"
        pitch-enable="false"
      >
        <el-amap-marker
          v-for="(marker,index) in markers"
          :key="index"
          :events="marker.events"
          :position="marker.position"
        />
        <el-amap-info-window
          v-if="window"
          :position="window.position"
          :visible="window.visible"
          :content="window.content"
          :offset="window.offset"
          :close-when-click-map="true"
          :is-custom="true"
        >
          <div id="info-window">
            <div class="info">
              <h4 >{{window.name}}</h4><hr>

              <p>
                <el-row type="flex" class="row-bg">
                  <el-col :span="9">气&nbsp&nbsp&nbsp&nbsp压：</el-col>
                  <el-col :span="8"><span class="actual" id="pressure"></span></el-col>
                  <el-col :span="7"><span class="forecast" id="pressures">12</span></el-col>
                </el-row>
              </p>
              <p>
                <el-row type="flex" class="row-bg">
                  <el-col :span="9">温&nbsp&nbsp&nbsp&nbsp度：</el-col>
                  <el-col :span="8"><span class="actual" id="temperature"></span></el-col>
                  <el-col :span="7"><span class="forecast" id="temperatures">12</span></el-col>
                </el-row>
              </p>
              <p>
                <el-row type="flex" class="row-bg">
                  <el-col :span="9">湿&nbsp&nbsp&nbsp&nbsp度：</el-col>
                  <el-col :span="8"><span class="actual" id="humidity"></span></el-col>
                  <el-col :span="7"><span class="forecast" id="humiditys">12</span></el-col>
                </el-row>
              </p>
              <p>
                <el-row type="flex" class="row-bg">
                  <el-col :span="9">风&nbsp&nbsp&nbsp&nbsp速：</el-col>
                  <el-col :span="8"><span class="actual" id="windSpeed"></span></el-col>
                  <el-col :span="7"><span class="forecast" id="windSpeeds">12</span></el-col>
                </el-row>
              </p>
              <p>
                <el-row type="flex" class="row-bg">
                  <el-col :span="9">风&nbsp&nbsp&nbsp&nbsp向：</el-col>
                  <el-col :span="8"><span class="actual" id="windDirection"></span></el-col>
                  <el-col :span="7"><span class="forecast" id="windDirections">12</span></el-col>
                </el-row>
              </p>
              <p>
                <el-row type="flex" class="row-bg">
                  <el-col :span="9">降雨量：</el-col>
                  <el-col :span="8"><span class="actual" id="rainfall"></span></el-col>
                  <el-col :span="7"><span class="forecast" id="rainfalls">12</span></el-col>
                </el-row>
              </p>
              <p>
                <el-row type="flex" class="row-bg">
                  <el-col :span="9">总辐射：</el-col>
                  <el-col :span="8"><span class="actual" id="totalRadiation"></span></el-col>
                  <el-col :span="7"><span class="forecast" id="totalRadiations">12</span></el-col>
                </el-row>
              </p>
            </div>
            <div class="detail" @click="checkDetail(window.id)">查看详情</div>
          </div>
        </el-amap-info-window>
      </el-amap>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue';
  import VueAMap from 'vue-amap';
  import {Row, Col} from 'element-ui';
  Vue.use(VueAMap);
  Vue.use(Row);
  Vue.use(Col);
  import 'element-ui/lib/theme-chalk/row.css';
  import 'element-ui/lib/theme-chalk/col.css';
  import {getMapEquipment,getMeteorologyEquipment} from '@f/api/meteorology/meteorology'

  VueAMap.initAMapApiLoader({
    key: '155ecbe90daf83c1de5fcaa1218092dc',
    plugin: ['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MapType', 'AMap.PolyEditor', 'AMap.CircleEditor'],
    uiVersion: '1.0'
  });
  export default {
    name: "AmapPage",
    props: {
      equipmentId: {
        type: String|Number,
        default: ''
      },
      height: {
        type: String,
        default: '7.2rem'
      }
    },
    watch: {
      equipmentId(newV,oldV) {
        // do something
        if(newV != oldV) {
          this.getCenter()

        }
      }
    },
    data: function () {
      const self = this;
      return {
        data: [
          {
            center: ['113.645422', '34.730936'],
            name: "上海",
            id: 1,
          }
        ],
        zoom: 10,
        center: ['113.645422', '34.730936'],
        markers: [],
        windows: [],
        window: "",
        events: {
          click(e) {
            const { lng, lat } = e.lnglat;
            self.lng = lng;
            self.lat = lat;
          },
        },
        lng: 0,
        lat: 0,

        /*一些工具插件*/

        plugin: [

        ],
      };
    },
    mounted() {
      this.getMapEquipment()
    },
    methods: {
      point() {
        const markers = [];
        const windows = [];
        const that = this;
        this.data.forEach((item, index) => {
          markers.push({
            position: item.center,
            // icon:item.url, //不设置默认蓝色水滴
            events: {
              click() {
                getMeteorologyEquipment(item.id).then(response => {
                  document.getElementById("pressure").innerText = response.data.pressure;
                  document.getElementById("humidity").innerText = response.data.humidity;
                  document.getElementById("temperature").innerText = response.data.temperature;
                  document.getElementById("windSpeed").innerText = response.data.windSpeed;
                  document.getElementById("windDirection").innerText = response.data.windDirection;
                  document.getElementById("rainfall").innerText = response.data.rainfall;
                  document.getElementById("totalRadiation").innerText = response.data.totalRadiation;
                  document.getElementById("pressures").innerText = response.data.pressures;
                  document.getElementById("humiditys").innerText = response.data.humiditys;
                  document.getElementById("temperatures").innerText = response.data.temperatures;
                  document.getElementById("windSpeeds").innerText = response.data.windSpeeds;
                  document.getElementById("windDirections").innerText = response.data.windDirections;
                  document.getElementById("rainfalls").innerText = response.data.rainfalls;
                  document.getElementById("totalRadiations").innerText = response.data.totalRadiations;
                })
                // 方法：鼠标移动到点标记上，显示相应窗体
                that.windows.forEach((window) => {
                  window.visible = false; // 关闭窗体
                });
                that.window = that.windows[index];
                that.$nextTick(() => {
                  that.window.visible = true;
                });
              },
            },
          });
          windows.push({
            position: item.center,
            isCustom: true,
            offset: [115, 55], // 窗体偏移
            showShadow: false,
            visible: false, // 初始是否显示
            name: item.name,
            id: item.id,
            info:this.info
          });
        });

        //  加点
        this.markers = markers;
        // 加弹窗
        this.windows = windows;
      },
      checkDetail(id) {
        this.$router.push({
          name: 'Show',
          params: {id: id}
        })
      },
      getMapEquipment() {
        getMapEquipment().then(response => {
          this.center = response.data.center
          this.data = response.data.equipment
          this.point();
        })
      },
      getCenter() {
        for(let item in this.data) {
          if (this.data[item].id == this.equipmentId) {
            this.center =  this.data[item].center
          }
        }
      },

    },
  };
</script>

<style lang="scss" scoped>
  $menuText:#bfcbd9;
  .amap-demo {

  }

  .amap-page-container {
    position: relative;
  }

  #info-window {
    width: 211px;
    margin-left: 30px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 4px;
    position: relative;
    overflow: hidden;
    font-size: 0.18rem;
    .info {

      padding: 0.1rem 0.2rem 0 0.2rem;
      border-width: 0;
      hr {
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, .1);
        margin-right: 0;
        margin-left: 0;
        border-top-color: grey;
      }
      h4 {
        font-size: 0.2rem;
        font-family: inherit;
        line-height: 1;
        font-weight: 300;
        color: inherit;
        margin-top: 0;
        margin-bottom: 0;
      }
      p {
        line-height: 0.1rem;
        font-size: 0.2rem;
        font-weight: 300;
        color: #111213;
      }
      .forecast {
        color: red;
      }
      .actual {
        padding-right:10px ;
      }
    }

  }

  .detail {
    width: 100%;
    height: 24px;
    color: #fff;
    background-color: #1a73e8;
    /*position: absolute;*/
    bottom: 0;
    font-size: 12px;
    line-height: 24px;
    text-align: center;
    cursor: pointer;
  }
</style>
