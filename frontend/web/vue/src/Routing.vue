<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      fixed
      app
    >
      <v-list class="pa-1">
        <v-list-tile avatar>
          <v-list-tile-content>
            <v-list-tile-title>{{firstName}} {{secondName}}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>

      <v-list class="pt-0" dense>
        <v-divider></v-divider>
        <div class="main-page">
          <a href="/">Главная</a>
        </div>
        <v-list-tile
          v-for="link in linkMenu"
          :key="link.title"
          :to="link.url"
          @click=""
        >
          <v-list-tile-content>
            <v-list-tile-title>{{ link.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <form class="logout-btn" action="/site/logout" method="post">
          <button type="submit">Выход</button>
        </form>
      </v-list>
    </v-navigation-drawer>
    <v-layout
      wrap
      main
    >
      <v-container>
        <v-layout justify-start menu>
          <v-btn
            color="pink"
            dark
            @click.stop="drawer = !drawer"
          >
            Меню
          </v-btn>
        </v-layout>
        <router-view></router-view>
      </v-container>
    </v-layout>
  </v-app>
</template>

<script>

export default {
  name: 'App',
  components: {},
  data () {
    return {
      drawer: true,
      firstName: '',
      secondName: '',
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
        {
          title: 'Редактировать профиль',
          url: '/personal-area/edit-profile'
        },
      ],
    }
  },
  created() {
    this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index`)
      .then(response => {
          this.firstName = response.data[0].first_name;
          this.secondName = response.data[0].second_name;
        }, response => {
        }
      );
    if (window.innerWidth < 1265) {
      this.drawer = false;
    }
  }
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
  .main {
    padding-left: 300px;
  }
  .menu {
    display: none;
  }
  @media (max-width: 1265px) {
    .main {
      padding-left: 0;
    }
    .menu {
      display: flex;
    }
  }
  .logout-btn, .main-page {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: inherit;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-size: 16px;
    font-weight: 400;
    height: 48px;
    margin: 0;
    padding: 0 16px;
    position: relative;
    text-decoration: none;
    -webkit-transition: background .3s cubic-bezier(.25,.8,.5,1);
    transition: background .3s cubic-bezier(.25,.8,.5,1);
    transition: none;
    font-weight: 500;
    height: 40px;
  }
  .logout-btn button, .main-page a {
    height: 24px;
    line-height: 24px;
    position: relative;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-decoration: none;
    color: rgba(0,0,0,.87);
    -webkit-transition: .3s cubic-bezier(.25,.8,.5,1);
    transition: .3s cubic-bezier(.25,.8,.5,1);
    width: 100%;
    font-size: 13px;
    outline: none;
  }
  .logout-btn:hover, .main-page:hover {
    background: rgba(0,0,0,.04);
  }
</style>