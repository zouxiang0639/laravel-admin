<template>
  <div>
    <el-table
      :data="equipment"
      style="width: 100%;background-color: rgba(165,165,165,0.2);"
      height="250"
      :header-cell-style="{'text-align':'center'}"
      :cell-style="{'text-align':'center'}"
    >
      <el-table-column
        fixed
        prop="name"
        label="名称"
        width="150">
      </el-table-column>
      <el-table-column
        prop="cityName"
        label="地点"
        width="120">
      </el-table-column>
      <el-table-column
        prop="isLink"
        label="在线情况"
        width="120">
      </el-table-column>
    </el-table>
  </div>

</template>

<script>
  import Vue from 'vue';
  import {Table, TableColumn} from 'element-ui';

  Vue.use(Table);
  Vue.use(TableColumn)


  export default {
    props: {
      equipment: {
        type: Array,
        default: [{
          name: '王小虎',
          place: '上海',
          online: '在线',
        }, {
          name: '王小虎',
          place: '上海',
          online: '在线',
        }]
      },
      width: {
        type: String,
        default: '100%'
      },
      height: {
        type: String,
        default: '300px'
      }
    },
    data() {
      return {
      }
    },
    methods: {

    },

  }
</script>
<style lang="scss">

  .el-table {
    /*.warning-row {*/
    /*  background: oldlace;*/
    /*}*/
    /*.success-row {*/
    /*  background: #3b6125;*/
    /*}*/
    th, tr {
      background-color: rgba(165, 165, 165, 0.2);
      color: white;
    }
    .hover-row {
      background-color: rgba(165, 165, 165, 0.1);
      color: #1a1a1c;
    }

  }

</style>

