<script setup lang="ts">
const authStore = useAuthStore();
const menu = [
  {'id': 1, 'title': 'Main', 'href': '/'},
  {'id': 2, 'title': 'Registration', 'href': '/registration'},
  {'id': 3, 'title': 'Users', 'href': '/users'},
];
</script>

<template>
  <header class="header">
    <nav class="main-nav">
      <ul class="nav-list">
        <li class="nav-item" v-for="item in menu" :key="item.id">
          <NuxtLink :to="item.href" @click="authStore.clearVar" class="nav-link">{{item.title}}</NuxtLink>
        </li>
      </ul>
    </nav>
  </header>
</template>

<style scoped lang="scss">
.header {
  background-color: deepskyblue;
  .main-nav {
    outline: 2px solid red;
    .nav-list {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: space-around;
      list-style: none;
      .nav-item {
        margin: 0;
        padding: 5px 10px;
        .nav-link {
          color: #cceeff;
          padding: 5px 10px;
          &:hover {
            color: cadetblue;
          }
        }
      }
    }
  }

}
</style>