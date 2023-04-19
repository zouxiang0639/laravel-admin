<template>
  <div>
    <el-card class="box-card" style="font-size: 14px; height: 4.3rem;overflow-y:scroll;">

      <el-alert
        v-for="tag in tags"
        :key="tag.id"
        style="width: 4.8rem;margin-bottom: 2px;"
        :description="tag.content"
        :type="tag.type"
        effect="dark"
        @close="handleClose(tag)">

      </el-alert>


    </el-card>
  </div>
</template>

<script>
  import Vue from 'vue';
  import {Card,Alert,Icon} from 'element-ui';
  import {getInformation, destroyInformation} from '@f/api/information/information'
  Vue.use(Card);
  Vue.use(Icon);
  Vue.use(Alert);
  import 'element-ui/lib/theme-chalk/icon.css';
  import 'element-ui/lib/theme-chalk/alert.css';
  import resize from './mixins/resize'

  const animationDuration = 3000
  export default {
    mixins: [resize],
    props: {
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
        default: '300px'
      }
    },
    data() {
      return {
        tags: [
          //{ content: '标签一', type: '' },
          // { content: '标签二', type: 'success' },
          // { content: '标签三', type: 'info' },
          // { content: '标签四', type: 'warning' },
          // { content: '标签五', type: 'danger' }
        ]
      }
    },
    created() {
      this.getList()
      //self.setInterval(this.getList,1000*60*4);
    },
    methods: {

      handleClose(tag) {
        this.$messagebox.confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.tags.splice(this.tags.indexOf(tag), 1);
          destroyInformation(tag.id)
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        }).catch(() => {
          document.getElementsByClassName("el-alert")[this.tags.indexOf(tag)].setAttribute("style", "width: 4.8rem;margin-bottom: 2px;");
          this.$message({
            type: 'info',
            message: '已取消删除'
          });
        });

      },
      getList() {
        getInformation().then(response => {
          this.tags = response.data.item
        })
      },
      destroyInformation(id) {
        destroyInformation(id).then(response => {
          this.tags = response.data.item
        })
      },
    }

  }
</script>

<style lang="scss">
  .el-tag i{

  }
  .el-card {
      background-color: rgba(165, 165, 165, 0.2);
      color: white;
  }
  .el-card__body {
    padding: 0.26rem
  }

  element.style {
  }

  .el-alert .el-alert__description {
    font-size: 15px;
    margin: 5px 0 0;
  }
  .el-alert__closebtn {
    font-size: 17px;
  }

</style>
