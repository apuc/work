<template>
  <div>
    <v-subheader class="all-head">
      Ваши баннеры
      <router-link class="vacancy__link" to="/personal-area/add-banner">
        <v-btn class="vacancy__link">
          Добавить баннер
        </v-btn>
      </router-link>
    </v-subheader>
    <template v-if="allBanners.models && allBanners.models.length < 1">
      <v-subheader>У вас нет баннеров</v-subheader>
    </template>

    <template v-else>
      <div>
        <div class="all-banners">

          <v-list two-line>

            <v-list-tile
                v-for="(item, index) in allBanners.models"
                :key="index"
                style="margin-top: 20px;"
            >
              <v-list-tile-content>
                <div class="banner-advertising">
                  <img :src="domen + item.image_url" alt="">
                  <div class="banner-advertising__right">
                    <h3>{{ item.description }}</h3>
                    <div class="banner-advertising__right-bottom">
                      <img :src="domen + item.logo_url" alt="">
                      <a href="/" class="btn-card btn-red">
                        Посмотреть полностью
                      </a>
                    </div>
                  </div>
                </div>
              </v-list-tile-content>
              <router-link :to="`${editLink}/${item.id}`">
                <v-btn outline small fab
                       class="edit-btn"
                       type="button"
                       title="Редактировать"
                >
                  <v-icon>edit</v-icon>

                </v-btn>
              </router-link>
              <v-btn outline small fab
                     class="edit-btn"
                     type="button"
                     title="Удалить"
                     @click="bannerRemove(index, item.id)"
              >
                <v-icon>delete</v-icon>

              </v-btn>
            </v-list-tile>
          </v-list>

        </div>

        <template v-if="allBanners.pagination && allBanners.pagination.page_count > 1">
          <div class="text-xs-center">
            <v-pagination
                v-model="allBanners.pagination.current_page"
                :length="allBanners.pagination.page_count"
                @input="getBanners"
            ></v-pagination>
          </div>
        </template>

      </div>
    </template>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
  name: "BannerList",
  data() {
    return {
      editLink: '/personal-area/edit-banner',
      domen: ''
    }
  },
  created() {
    document.title = this.$route.meta.title;
    this.getBanners(1);
  },
  methods: {
    getBanners(page) {
      this.$store.dispatch('getAllBanners', page)
          .then(data => {
            this.domen = `${process.env.VUE_APP_API_URL}`;
            return data;
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
    bannerRemove(index, resumeId) {
      this.$swal({
        title: 'Вы точно хотите удалить баннер?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('removeBanner', resumeId)
              .then(data => {
                this.getBanners(this.paginationCurrentPage);
                return data;
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
        }
      });
    },
  },

  computed: {
    ...mapGetters([
      'allBanners',
    ])
  }
}
</script>

<style scoped>
.all-banners .theme--light.v-list {
  background-color: transparent;
}

a {
  text-decoration: none;
}

.all-head {
  margin-top: 10px;
  margin-bottom: 15px;
  padding: 0;
  font-size: 22px;
  color: rgba(0, 0, 0, .74);
}

.all-head a {
  margin-left: 15px;
}

.all-head a button {
  text-transform: none !important;
}

.v-list__tile__content {
  position: relative;
}

.all-banners-hide {
  position: absolute;
  right: 40px;
  padding: 3px;
  font-size: 13px;
  color: rgba(0, 0, 0, 0.62);
  line-height: 1;
  border-radius: 6px;
  border: 1px solid rgba(0, 0, 0, 0.12);
}

.banner-advertising {
  display: flex;
  align-items: center;
  width: 650px;
  margin: 15px 10px;
  padding: 30px 51px 13px 25px;
  border-radius: 10px;
  background-color: #ddf0fb;
  box-sizing: inherit;
}
.banner-advertising > img {
  margin-right: 30px;
  max-width: 148px;
}
.banner-advertising__right {
  display: flex;
  flex-direction: column;
    width: 100%;
}
.banner-advertising__right h3 {
  margin: 0 0 5px;
  color: #0f0000;
  font-size: 20px;
  font-weight: 700;
  font-family: "Muller",sans-serif;
}
.banner-advertising__right-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}
.banner-advertising__right-bottom > img {
  width: 140px;
  height: auto;
  margin-top: 15px;
}
.banner-advertising__right-bottom .btn-card {
  margin-top: 15px;
  border: none;
  border-radius: 30px;
  font-size: 16px;
  font-weight: 700;
}
.btn-card {
  display: inline-block;
  padding: 7px 15px 5px;
  font-weight: 500;
  font-size: 11px;
  color: #fff;
  text-decoration: none;
  letter-spacing: .43px;
  background-color: transparent;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  -webkit-transition: all 0.3s ease;
  -o-transition: all 0.3s ease;
  transition: all 0.3s ease;
}
.btn-red {
  color: #fff;
  background-color: #dd3d34;
}
</style>
