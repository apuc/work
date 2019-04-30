<template>
  <v-app>
    <v-layout
      wrap
    >
      <v-container>
        <v-layout justify-start>
          <v-btn
            color="pink"
            dark
            @click.stop="drawer = !drawer"
          >
            Меню
          </v-btn>
        </v-layout>
      </v-container>

      <v-navigation-drawer
        v-model="drawer"
        absolute
        temporary
      >
        <v-list class="pa-1">
          <v-list-tile avatar>
            <v-list-tile-avatar>
              <img src="https://randomuser.me/api/portraits/men/85.jpg">
            </v-list-tile-avatar>

            <v-list-tile-content>
              <v-list-tile-title>John Leider</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>

        <v-list class="pt-0" dense>
          <v-divider></v-divider>

          <v-list-tile
            v-for="link in linkMenu"
            :key="link.title"
            :to="link.url"
            @click=""
          >
            <!--<v-list-tile-action>-->
              <!--<v-icon>{{ item.icon }}</v-icon>-->
            <!--</v-list-tile-action>-->

            <v-list-tile-content>
              <v-list-tile-title>{{ link.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-navigation-drawer>
    </v-layout>
    <v-container>
      <!--<ul class="nav-menu">-->
        <!--<li v-for="link in linkMenu" :key="link.title">-->
          <!--<router-link :to="link.url">{{ link.title }}</router-link>-->
        <!--</li>-->
      <!--</ul>-->
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
      drawer: null,
      linkMenu: [
        {
          title: 'Добавить вакансию',
          url: '/personal-area/add-vacancy'
        },
        {
          title: 'Добавить резюме',
          url: '/personal-area/add-resume'
        },
        {
          title: 'Добавить компанию',
          url: '/personal-area/add-company'
        },
        {
          title: 'Все вакансии',
          url: '/personal-area/all-vacancy'
        },
        {
          title: 'Все резюме',
          url: '/personal-area/all-resume'
        },
        {
          title: 'Все компании',
          url: '/personal-area/all-company'
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
  .v-list__tile__title a {
    color: inherit;
    text-decoration: none;
  }
</style>