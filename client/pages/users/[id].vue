<script setup lang="ts">

const userStore = useUsersStore();
const appConfig = useAppConfig()
const route = useRoute();
userStore.getUserOne(route.params.id)
const normalizeDate = (timestamp:number)=> {
  const date = new Date(timestamp * 1000);

  const day = ('0' + date.getDate()).slice(-2);
  const month = ('0' + (date.getMonth() + 1)).slice(-2);
  const year = date.getFullYear();

  return  `${day}-${month}-${year}`;
}
</script>

<template>
  <Loader v-if="userStore.loader"/>
  <template v-else>
    <h3 class="alert alert-danger" v-if="userStore.errMsg">{{userStore.errMsg}}</h3>
    <div v-else class="card mb-3" >
    <div class="row no-gutters">
      <div class="col-md-4">
        <img :src="appConfig['publicUrlImg']+userStore.user.photo" class="card-img" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">{{ userStore.user.name }}</h5>
          <p class="card-text">
            <ul>
              <li>email: {{userStore.user.email}}</li>
              <li>phone: {{userStore.user.phone}}</li>
              <li>position: {{userStore.user.position}}</li>
            </ul>
          </p>
          <p class="card-text"><small class="text-muted">Created:
            {{normalizeDate(userStore.user.registration_timestamp) }}
          </small></p>
        </div>
      </div>
    </div>
  </div>
  </template>
</template>

<style scoped>

</style>