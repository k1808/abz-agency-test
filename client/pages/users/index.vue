<script setup lang="ts">

import {useUsersStore} from "~/stores/UsersStore";
// @ts-ignore
import {ref} from "vue";
const userStore = useUsersStore();

const queryUsers = ref({
  count: 5,
  offset: null,
  page: userStore.current_page,
})
const appConfig = useAppConfig()
const loadNewUsers = ()=>{
  userStore.getUsers(queryUsers.value);
  userStore.clearShowMore();

}
const loadNewUsersWithPagination = (page:number)=>{
  queryUsers.value.page = page
  userStore.getUsers(queryUsers.value)
  userStore.clearShowMore();

}

const ShowMore = () =>{
  queryUsers.value.page = userStore.current_page + 1
  userStore.getUsers(queryUsers.value)
}
</script>

<template>
  <Loader v-if="userStore.loader"/>
  <template v-else >
    <div class="controls-block">
      <div class="form-control">
          <label for="count" class="form-label">Count</label>
          <input class="form-control" min="1" step="1"  v-model="queryUsers.count" @change="loadNewUsers" type="number" id="count">
      </div>
      <div class="form-control">
          <label for="offset" class="form-label">Offset</label>
          <input class="form-control" min="1" step="1" v-model="queryUsers.offset" @change="loadNewUsers" type="number" id="offset">
      </div>
      <div class="form-control">
        <label for="page" class="form-label">Page</label>
        <input class="form-control" type="number" :max="userStore.total_pages" @change="loadNewUsers" v-model="queryUsers.page" min="1" step="1" id="page">
      </div>
    </div>
    <table class="table">
      <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Photo</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Position</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user of userStore.usersShowMore" :key="user.id">
        <th scope="row"><NuxtLink :to="'/users/'+user.id">{{ user.id }}</NuxtLink></th>
        <td><NuxtLink :to="'/users/'+user.id">
          <img :src="appConfig['publicUrlImg']+user.photo">
        </NuxtLink></td>
        <td><NuxtLink :to="'/users/'+user.id">{{ user.name }}</NuxtLink></td>
        <td>{{ user.email }}</td>
        <td>{{ user.phone }}</td>
        <td>{{ user.position }}</td>
      </tr>
     </tbody>
    </table>
    <div class="pagination-block">
      <button type="button" @click="ShowMore" class="btn btn-info" v-if="userStore.next_link!==null">ShowMore</button>
      <nav aria-label="...">
        <ul class="pagination">
          <li class="page-item" :class="userStore.prev_link==null? 'disabled':''">
            <a class="page-link" @click="loadNewUsersWithPagination(userStore.current_page - 1)" href="#" tabindex="-1">Previous</a>
          </li>
          <li class="page-item" v-if="userStore.current_page!==1">
            <a class="page-link" @click="loadNewUsersWithPagination(userStore.current_page - 1)" href="#">{{ userStore.current_page-1 }}</a></li>
          <li class="page-item active">
            <a class="page-link" href="#">{{ userStore.current_page}}<span class="sr-only">(current)</span></a>
          </li>
          <li class="page-item" @click="loadNewUsersWithPagination(userStore.current_page + 1)" v-if="userStore.current_page!==userStore.total_pages"><a class="page-link" href="#">{{ userStore.current_page+1 }}</a></li>
          <li class="page-item" :class="userStore.next_link==null? 'disabled':''">
            <a class="page-link" @click="loadNewUsersWithPagination(userStore.current_page + 1)" href="#">Next</a>
          </li>
        </ul>
      </nav>
    </div>
  </template>
</template>

<style scoped>
.pagination-block,
.controls-block {
  display: flex;
  justify-content: space-around;
}
</style>