<template>
  <div class="login-container">
    <van-form @submit="onSubmit">
      <van-search
        v-model="value"
        show-action
        placeholder="请输入搜索关键词22"
        @search="onSearch"
      />
      <van-field
        v-model="username"
        name="用户名1"
        label="用户名2"
        placeholder="用户名2"
        :rules="[{ required: true, message: '请填写用户名' }]"
      />
      <van-field
        v-model="password"
        type="password"
        name="密码"
        label="密码"
        placeholder="密码"
        :rules="[{ required: true, message: '请填写密码' }]"
      />

      <div style="margin: 16px;">
        <van-button round block type="info" native-type="submit">
          提交
        </van-button>
      </div>
    </van-form>
    <form action="/">

    </form>


  </div>
</template>

<script>
  import {
    Form,
    Button,
    Field,
    Toast,
    Search
  } from 'vant';


  export default {
    name: 'Login',
    components: {
      [Form.name]: Form,
      [Button.name]: Button,
      [Field.name]: Field,
      [Toast.name]: Toast,
      [Search.name]: Search,
    },
    data() {
      return {
        username: '',
        password: '',
        value: '',
        name: [],
      };
    },
    methods: {
      onSubmit(values) {
        console.log('submit', values);
      },
      onSearch(val) {
        Toast(val);
      },
      onCancel() {
        Toast('取消');
      },
    },
  }
</script>

<style lang="scss">

</style>
