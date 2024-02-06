<script setup>
import {ref} from 'vue'
const authStore = useAuthStore();
const form = ref({
  email: '',
  name: '',
  password: '',
  phone: '',
  position_id: null,
  token: '',
  photo: null
})

const onSubmit = () =>{
  if(form.value.position_id == null ) {
    authStore.setErrMsg('The position field is not selected');
  } else {
    authStore.setErrMsg(null);
    authStore.register(form.value)
  }
}
const changeImg = (event) => {
  const fileInput = event.target;
  const files = fileInput.files;
  form.value.photo = files[0];
}
</script>
publicUrlImg
<template>
  <h1 style="margin-bottom: 25px">Registration</h1>
  <div>{{authStore.okMsg}}</div>
  <div class="alert alert-success" role="alert" v-if="authStore.okMsg">
    <ul>
      <li v-for="(okItem, key) in authStore.okMsg" :key="key">
        <template v-if="key!=='user_id'">{{key}}:{{okItem}}</template>
        <NuxtLink @click="authStore.clearVar" :to="`/users/${okItem}`" v-else>{{key}}:{{okItem}}</NuxtLink>
      </li>
    </ul>
  </div>
  <h3 class="alert alert-danger" v-if="authStore.errMsg">{{authStore.errMsg}}</h3>
  <Loader v-if="authStore.loader"/>
  <form v-else>
    <div class="form-control">
      <div class="mb-3">
        <label for="formFile" class="form-label">Upload ava</label>
        <input class="form-control" type="file" id="formFile" @change="changeImg">
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="form-control col-md-6">
          <label for="username">Username</label>
          <input type="text" v-model="form.name" id="username" class="form-control">
        </div>
        <div class="form-control col-md-6">
          <label for="email">Email</label>
          <input type="email" v-model="form.email" id="email" class="form-control">
        </div>
      </div>
      <div class="row">
        <div class="form-control col-md-6">
          <label for="password">Password</label>
          <input type="password" v-model="form.password" id="password" class="form-control">
        </div>
        <div class="form-control col-md-6">
          <label for="phone">Phone</label>
          <input type="text" v-model="form.phone" id="phone" class="form-control">
        </div>
      </div>
      <div class="row">
        <div class="form-control col-md-6">
          <label for="position">Position</label>
          <select class="form-select" v-model="form.position_id" aria-label="Default select example">
            <option selected :value="null">Open this select menu</option>
            <option :value="position.id" v-for="position of authStore.positions" :key="position.id">{{position.name}}</option>
          </select>
        </div>
        <div class="form-control">
          <label for="floatingTextarea">Token</label>
          <textarea class="form-control" v-model="form.token" placeholder="Leave a comment here" id="floatingTextarea"></textarea>

        </div>

      </div>
      <button class="btn btn-primary" @click.prevent="onSubmit">Click</button>
    </div>
  </form>
</template>

<style scoped>
  .form-control {
    display: flex;
    flex-direction: column;
  }

  .row {
    display: flex;
  }
</style>