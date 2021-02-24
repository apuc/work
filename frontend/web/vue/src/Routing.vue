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
            <v-list-tile-title v-if="first_name > 0" class="login-block">
              <img class="login-image" :src="loginImg" alt="">
              {{ userMe.first_name }} {{ userMe.second_name }}
            </v-list-tile-title>
            <v-list-tile-title v-else class="login-block">
              <img class="login-image" :src="loginImg" alt="">
              {{ sliceEmail(userMe.user.email) }}
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider></v-divider>
      </v-list>
      <v-list class="pa-1" v-if="userStatus >= 20">
        <v-list-tile avatar>
          <v-list-tile-content>
            <v-list-tile-title class="login-block" >
              Баланс: {{ userMe.user.company.balance }} ₽
              <v-btn class="btn__statistic" to="/personal-area/payment">
                <span style="font-size: 11px; color: white;">Пополнить</span>
              </v-btn>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider></v-divider>
      </v-list>
      <v-list class="pt-0" dense>
        <div class="main-page menu-hover">
          <img :src="mainImg" alt="">
          <a href="/">Главная</a>
        </div>
        <v-list-tile
            v-for="link in linkMenu"
            :key="link.title"
            v-if="link.show"
            :to="link.url"
            class="menu-hover"
            @click="getMessage(link.title)"
        >
          <v-list-tile-content>
            <img :src="link.img" alt="">
            <v-list-tile-title class="menu-text">
              {{ link.title }}
              <template v-if="link.title === 'Отклики'">
                <v-list-tile-title v-if="unreadMessages > 0"
                                   class="menu-notification">
                  {{ userMe.user.unreadMessages }}
                </v-list-tile-title>
              </template>
              <template v-if="link.title === 'Обновления'">
                <v-list-tile-title v-if="unreadUpdates > 0"
                                   class="menu-notification">
                  {{ userMe.user.unreadUpdates }}
                </v-list-tile-title>
              </template>
              <template v-if="link.addFlag">
                <router-link v-if="link.companiesCount < 1" class="menu-add-link" :to="link.addTo"
                             :title="link.addTitle">
                  <span>+</span>
                </router-link>
              </template>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <form class="logout-btn menu-hover" action="/site/logout" method="post">
          <img :src="logOutImg" alt="">
          <button type="submit">Выход</button>
        </form>
      </v-list>
    </v-navigation-drawer>
    <v-layout
        wrap
        main
    >
      <v-container  class="my__container">
        <v-alert
            dense
            :value="true"
            type="warning"
            class="main-alert"
            v-if="userMe.companiesCount > 1"
        >
          <h1>Внимание!</h1>
          Мы подготовили для Вас новые функции сайта, которые сделают поиск сотрудников комфортнее.<br>
          В связи с этим мы вынеждены с <strong>01.07.2020</strong> ввести ограничение на кол-во компаний на одном
          аккаунте.<br>
          <button type="button" @click="alertFlag = !alertFlag">Подробнее</button>
          <br>
          <transition name="fade">
            <div v-if="alertFlag">
              На аккаунте может быть только одна компания.<br>
              <span v-if="userMe.companiesCount === 2">
                                Просим Вас перенести одну из Ваших компаний на другой аккаунт. Все данные будут сохранены и доступны в указанном аккаунте.
                            </span>
              <span v-if="userMe.companiesCount > 2">
                                Просим Вас перенести все компании кроме одной на другие аккаунты. Все данные будут сохранены и доступны в указанных аккаунтах.
                            </span>
              <br>
              Для этого нажмите на кнопку "Передать права" и введите Email.<br>
              Если не будет найден аккаунт связанный с указанной почтой, он будет создан автоматически. Данные для входа
              будут отправлены на указанный email!<br>
              Если <strong>01.07.2020</strong> на Вашем аккаунте будет более 1 компании, все компании кроме одной, будут
              удалены. Останется одна случайная компания.<br>
            </div>
          </transition>
        </v-alert>
        <v-layout justify-start menu>
          <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        </v-layout>
        <router-view></router-view>
      </v-container>
    </v-layout>
  </v-app>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
  name: 'App',
  components: {},
  mounted() {
      window['yandexChatWidgetCallback'] = function() {
        try {
          window.yandexChatWidget = new Ya.ChatWidget({
            guid: '32c7f20c-e2f8-4b8e-95c6-e2c5c4b865a7',
            buttonText: 'Служба поддержки Rabota.Today',
            title: 'Чат',
            theme: 'light',
            collapsedDesktop: 'never',
            collapsedTouch: 'always'
          });
        } catch(e) {
          console.log(e,'YA routing')
        }
      };
      var n = document.getElementsByTagName('script')[0],
          s = document.createElement('script');
      s.async = true;
      s.charset = 'UTF-8';
      s.src = 'https://yastatic.net/s3/chat/widget.js';
      n.parentNode.insertBefore(s, n);
  },
  async created() {
    await this.getUser();
    if (window.innerWidth < 1265)
      this.drawer = false;
  },
  data() {
    return {
      drawer: true,
      alertFlag: false,
      first_name: 1,
      unreadMessages: 0,
      userStatus: 0,
      unreadUpdates: 0,
      loginImg: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/login.png',
      mainImg: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/main.png',
      logOutImg: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/exit.png',
      linkMenu: [
        {
          title: 'Статистика',
          url: '/personal-area/statistics',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/analysis.png',
          addFlag: false,
          show: true
        },
        {
          title: 'Отклики',
          url: '/personal-area/my-message',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/mail.png',
          addFlag: false,
          show: true
        },
        {
          title: 'Вакансии',
          url: '/personal-area/all-vacancy',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/all_vacancy.png',
          addFlag: false,
          // addTo: '/personal-area/add-vacancy',
          // addTitle: 'Добавить вакансию',
          // companiesCount: 0,
          show: true
        },
        {
          title: 'Резюме',
          url: '/personal-area/all-resume',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/all_resume.png',
          addFlag: true,
          addTo: '/personal-area/add-resume',
          addTitle: 'Добавить резюме',
          companiesCount: 0,
          show: true
        },
        {
          title: 'Компания',
          url: '/personal-area/edit-company',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/all_company.png',
          addFlag: true,
          addTo: '/personal-area/add-company',
          addTitle: 'Добавить компанию',
          companiesCount: localStorage.companiesCount,
          show: true
        },
        {
          title: 'Редактировать профиль',
          url: '/personal-area/edit-profile',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/profile.png',
          addFlag: false,
          show: true
        },
        {
          title: 'Баннеры',
          url: '/personal-area/banners',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/payban.png',
          addFlag: false,
          show: true
        },
        {
          title: 'Пополнить счет',
          url: '/personal-area/payment',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/payment.jpg',
          addFlag: false,
          show: true
        },
        {
          title: 'Промо коды',
          url: '/personal-area/promo',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/promo.png',
          addFlag: false,
          show: true
        },
        {
          title: 'Список операций',
          url: '/personal-area/operations',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/lists.png',
          addFlag: false,
          show: true
        },
        {
          title: 'Обновления',
          url: '/personal-area/updates',
          img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/updates.png',
          addFlag: false,
          show: true
        },
      ],
    }
  },
  methods: {
    sliceEmail(email) {
      email = email.match(/.+@/)[0];
      email = email.slice(0, email.length - 1);
      return email;
    },
    async getUser() {
      await this.$store.dispatch('getUserMe', this.$route.params.id)
          .then(data => {
            if (data.first_name != null) {
              this.first_name = data.first_name.length;
            } else {
              this.first_name = 0;
            }
            this.userStatus = data.user.status;
            if (data.user.status == 10) {
              this.linkMenu[2].show = false;
              this.linkMenu[4].show = false;
              this.linkMenu[6].show = false;
              this.linkMenu[7].show = false;
              this.linkMenu[9].show = false;
            }
            if (data.user.status >= 20) {
              this.linkMenu[3].show = false;
              this.linkMenu[0].show = false
            }
            localStorage.setItem('companyId', data.user.company.id);
            this.unreadMessages = data.user.unreadMessages;
            this.unreadUpdates = data.user.unreadUpdates;
          }).catch(error => {
        this.$swal({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 4000,
          type: 'error',
          title: error.message
        })
      });
    },
    getMessage(title) {
      if (title !== 'Отклики') {
        this.getUser();
      }
    },
  },

  computed: {
    ...mapGetters([
      'userMe',
    ])
  }
}
</script>
<style>
/*<!--Вместо css loaderOptions at vue.config-->*/
.swal2-bottom-end{
  z-index: 9999999999999999999 !important;
}
.swal2-actions{
  position: absolute;
  bottom: -57px;
  left: 0;
}
.swal2-confirm {
  /*height: 40px !important;*/
  border-radius: 20px !important;
  background-color: #0f477e !important;
  color: #ffffff !important;
  font-family: "Muller Extra Bold" !important;
  font-weight: 400 !important;
  font-style: normal !important;
  letter-spacing: normal !important;
  line-height: 40px !important;
  text-align: left !important;
  text-transform: uppercase !important;
  /* Text style for "П, ополнит" */
  font-style: normal !important;
  letter-spacing: 1.1px !important;
  line-height: normal !important;
  padding: 15px 37px 15px 37px !important;
  margin-right: 24px;
}
.swal2-styled{
  height: 40px !important;
  border-radius: 20px !important;
  padding: 15px 37px 15px 37px !important;
  outline: none !important;
  font-size: 11px !important;
  text-transform: uppercase;
}
.swal2-cancel{
  /*height: 40px !important;*/
  border-radius: 20px !important;
  background-color: #454242 !important;
  padding: 15px 37px 15px 37px !important;
}
</style>
<style scoped>
.my__container{
  /*padding: 0 !important;*/
  max-width: initial !important;
}
.btn__statistic {
  background-color: #dd3d34 !important;
  border-radius: 20px;
  height: 40px;
  max-width: 130px;
}
.main-alert {
  width: 100%;
  border: none;
}

.main-alert button {
  text-decoration: underline;
  outline: none;
}

.container {
  margin: 0 auto;
}

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
  -webkit-transition: background .3s cubic-bezier(.25, .8, .5, 1);
  transition: background .3s cubic-bezier(.25, .8, .5, 1);
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
  color: rgba(0, 0, 0, .87);
  -webkit-transition: .3s cubic-bezier(.25, .8, .5, 1);
  transition: .3s cubic-bezier(.25, .8, .5, 1);
  width: 100%;
  font-size: 13px;
  outline: none;
}

.logout-btn:hover, .main-page:hover {
  background: rgba(0, 0, 0, .04);
}

.logout-btn img, .main-page img {
  min-width: 20px;
  width: 20px;
  margin-right: 10px;
}

.v-list__tile__content {
  align-items: center;
  flex-direction: row;
}

.v-list__tile__content img {
  min-width: 20px;
  width: 20px;
  margin-right: 10px;
}

.login-block {
  display: flex;
  align-items: center;
  height: 40px;
  justify-content: space-between;
}

.login-image {
  width: 25px !important;
}

.menu-text {
  display: flex;
  align-items: center;
  height: 100%;
}

.menu-hover:hover {
  background-color: #deddd9;
}

.menu-notification {
  left: 10px;
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  background: #ff0000;
  color: #ffffff !important;
  border-radius: 50%;
}

.menu-add-link {
  display: none;
  align-items: center;
  justify-content: center;
  margin-left: auto;
  width: 20px;
  height: 20px;
  transition: all ease .3s;
  border: 1px solid #19a924e3;
  color: #ffffff !important;
  border-radius: 5px;
  font-size: 20px;
  background: #19a924e3;
  margin-right: 5px;
}

.menu-hover:hover .menu-add-link {
  display: flex;
}
</style>
