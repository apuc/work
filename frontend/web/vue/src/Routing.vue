<template>
  <v-app>
    <v-container>
      <ul class="nav-menu">
        <li v-for="link in linkMenu" :key="link.title">
          <router-link :to="link.url">{{ link.title }}</router-link>
        </li>
      </ul>
      <router-view></router-view>
    </v-container>
  </v-app>
</template>

<script>

export default {
  name: 'App',
  components: {},
  data () {
    return {
      linkMenu: [
        {
          title: 'Главная',
          url: '/'
        },
        {
          title: 'Добавить вакансию',
          url: '/add-vacancy'
        },
        {
          title: 'Добавить резюме',
          url: '/add-resume'
        },
        {
          title: 'Добавить компания',
          url: '/add-company'
        },
        {
          title: 'Все резюме',
          url: '/all-resume'
        },
      ],
    }
  },
}
</script>
<style scoped>
  .nav-menu {
    display: flex;
    align-items: center;
    list-style: none;
  }
  .nav-menu li {
    margin-right: 30px;
  }
  .nav-menu li a {
    color: #000000;
    text-decoration: none;
  }
</style>