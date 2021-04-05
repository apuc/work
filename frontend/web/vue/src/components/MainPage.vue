<template>
    <div class="main-block">
        <template v-for="(items, index) in allRecords">
            <template v-if="items === allRecords.Resume && user.status===10">
                <v-subheader class="main-head">Резюме</v-subheader>
                <hr class="hr">
                <v-subheader  v-if="allRecords.Resume.length === 0">У вас нет резюме</v-subheader>
            </template>

            <template v-else-if="items === allRecords.Vacancy && user.status>=20">
                <v-subheader class="main-head">Вакансии</v-subheader>
                <hr class="hr">
                <v-subheader v-if="allRecords.Vacancy.length === 0">У вас нет вакансий</v-subheader>
            </template>

            <template v-else-if="items === allRecords.Company">
                <v-subheader class="main-head">Компании</v-subheader>
                <hr class="hr">
                <v-subheader v-if="allRecords.Company.length === 0">У вас нет компаний</v-subheader>
            </template>
          <div class="card__statistic__wrapper" >
            <template v-if="user.status===10">
            <div v-for="(item, itemIndex) in items" class="vacancy__wrapper">
              <v-card
                      class="main-card"
                      :class="selectBg(index)"
                      color="#26c6da"
                      dark
                      :style="items === allRecords.Vacancy ? {backgroundColor: '#26c6da !important'} : items === allRecords.Company ? {backgroundColor: '#1772cc !important'} : {backgroundColor:'#1772cc !important'}"
              >
  <!--              :style="{ items === allRecordes.Vacancy ? backgroundColor : '#26c6da' : items=== allRecords.Resume ? backgroundColor: '#1772cc': backgroundColor: ''}"-->
                <v-card-text class="headline font-weight-bold card-text" style="word-break: break-all;">
                      <template v-if="items === allRecords.Resume">
                        <p class="card__statistic_title">
                        <img :src="vacancyIcon" alt="">
                          <a :href="domen + '/resume/view/' + item.id" target="_blank" class="statistics-link">
                              {{ item.name }}
                          </a>
                        </p>
                      </template>
                  </v-card-text>
              </v-card>
              <v-list-tile class="grow">
                <v-layout
                    class="icons__wrapper"
                    align-center
                    justify-end
                >
                  <div class="ellipsis__wrapper">
                  <div class="icon__ellipsis">
                    <v-icon class="mr-1">remove_red_eye</v-icon>
                  </div>
                  <span class="subheading mr-2">{{ item.views }}</span>
                  </div>
                  <div class="ellipsis__wrapper">
                    <div class="icon__ellipsis">
                      <v-icon class="mr-1">phone</v-icon>
                    </div>
                    <span class="subheading mr-2">{{ item.click_phone_count }}</span>
                  </div>
                  <router-link to="/personal-area/my-message" class="statistics-link">
                  <div class="ellipsis__wrapper">
                    <div class="icon__ellipsis">
                      <v-icon class="mr-1">message</v-icon>
                    </div>
                    <span class="subheading mr-2">{{ item.responses }}</span>
                  </div>
                  </router-link>
                </v-layout>
              </v-list-tile>
              <div class="card__about">
                <p class="mb-0">Обновлено 30 июля 2020 в 15:51</p>
                <p class="mb-0">Доступно только по <a href="">прямой ссылке</a></p>
              </div>
            </div>
            </template>
            <template v-else-if="items!==allRecords.Resume">
              <div v-for="(item, itemIndex) in items" class="vacancy__wrapper">
                <v-card
                    class="main-card"
                    :class="selectBg(index)"
                    color="#26c6da"
                    dark
                    :style="items === allRecords.Vacancy ? {backgroundColor: '#26c6da !important'} : items === allRecords.Company ? {backgroundColor: '#1772cc !important'} : {backgroundColor:'#1772cc !important'}"
                >
                  <!--              :style="{ items === allRecordes.Vacancy ? backgroundColor : '#26c6da' : items=== allRecords.Resume ? backgroundColor: '#1772cc': backgroundColor: ''}"-->
                  <v-card-text class="headline font-weight-bold card-text" style="word-break: break-all;">
                    <template v-if="items === allRecords.Vacancy">
                      <p class="card__statistic_title">
                        <img :src="vacancyIcon" alt="">
                        <a :href="domen + '/vacancy/view/' + item.id" target="_blank" class="statistics-link">
                          {{ item.name }}
                        </a>
                      </p>
                    </template>
                    <template v-else-if="items === allRecords.Company">
                      <p class="card__statistic_title">
                        <img :src="companyIcon" alt="">
                        <a :href="domen + '/company/view/' + item.id" target="_blank" class="statistics-link">
                          {{ item.name }}
                        </a>
                      </p>
                    </template>
                  </v-card-text>
                </v-card>
                <v-list-tile class="grow">
                  <v-layout
                      class="icons__wrapper"
                      align-center
                      justify-end
                  >
                    <div class="ellipsis__wrapper">
                      <div class="icon__ellipsis">
                        <v-icon class="mr-1">remove_red_eye</v-icon>
                      </div>
                      <span class="subheading mr-2">{{ item.views }}</span>
                    </div>
                    <div class="ellipsis__wrapper">
                      <div class="icon__ellipsis">
                        <v-icon class="mr-1">phone</v-icon>
                      </div>
                      <span class="subheading mr-2">{{ item.click_phone_count }}</span>
                    </div>
                    <router-link to="/personal-area/my-message" class="statistics-link">
                      <div class="ellipsis__wrapper">
                        <div class="icon__ellipsis">
                          <v-icon class="mr-1">message</v-icon>
                        </div>
                        <span class="subheading mr-2">{{ item.responses }}</span>
                      </div>
                    </router-link>
                  </v-layout>
                </v-list-tile>
                <div class="card__about"><p class="mb-0">Обновлено 30 июля 2020 в 15:51</p>
                  <p class="mb-0">Доступно только по <a href="">прямой ссылке</a></p></div>
              </div>
            </template>
        </template>

    </div>
</template>

<script>
    export default {
        name: "MainPage",
        data() {
            return {
                allRecords: [],
                domen: '',
                imgDots: process.env.VUE_APP_API_URL + '/vue/public/lk-image/dots.png',
                vacancyIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/information.png',
                companyIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/business-and-trade.png',
            }
        },
        computed: {
        },
        async mounted() {
          this.user = (await this.$store.dispatch('getUserMe', this.$route.params.id)).user
            document.title = this.$route.meta.title;
            this.$store.dispatch('getStatistics')
                .then(data => {
                    this.allRecords = data;
                    this.domen = `${process.env.VUE_APP_API_URL}`;
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
        methods: {
            selectBg(cardType) {
                const types = {
                    resume: 'main-card_resume',
                    company: 'main-card_company',
                    vacancy: 'main-card_vacancy'
                };

                const typeLowerCase = cardType.toLowerCase();

                return types[typeLowerCase];
            }
        }
    }
</script>

<style scoped>
.hr{
  width: 100%;
  max-width: 350px;
  margin-bottom: 25px;
  height: 1px;
}
.card__about{
    line-height: 25px !important;
    margin-bottom: 0 !important;
    font-family: 'Muller Regular', sans-serif !important;
    font-size: 14px;
    font-weight: 400;
    padding: 0 16px;
    text-align: end;
}
.card__about     a{
  color: #00b4ff;
}
.card__statistic__wrapper{
  display: flex;
  flex-wrap: wrap;
  width: 100%;
}
.card__statistic_title{
  display: flex;
  align-items: center;
}
.card__statistic_title img{
  margin-right: 15px;
}
.icons__wrapper{
  //position: absolute;
  //right: -30px;
}
.ellipsis__wrapper{
  display: flex;
}
.ellipsis__wrapper span{
  align-self: flex-end;
}
.icon__ellipsis{
  width: 25px;
  justify-content: center;
  display: flex;
  /*box-shadow: 0 0 10px 0px black;*/
  align-items: center;
  height: 25px;
  margin-right: 8px;
  /*margin-top: 30px;*/
}
.icon__ellipsis .v-icon{
  width: 13px;
  margin-right: 0 !important;
  height: 8px;
  transform: scale(.6);
  align-self: center;
  color: red
}
.vacancy__wrapper{
  display: flex;
  flex-direction: column;
  padding-right: 20px;

  padding-bottom: 1rem;
}
    .main-block {
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
    }
    .main-head {
        width: 100%;
        margin-bottom: 10px;
        padding: 0;
        font-size: 20px;
        font-weight: 700;
        /*border-bottom: 1px solid rgba(0,0,0,0.54);*/
    }
    .main-card {
        width: 350px;
        //width: 100%;
        /*margin-bottom: 20px;*/
        border-radius: 10px;
        min-width: 251px;
        z-index: 2;
        //max-width: 271px;
    }
    .main-card_resume {
        display: flex;
        flex-direction: column;
        min-height: 160px;
        background-color: #0253a3 !important;
    }
    .main-card_vacancy {
        display: flex;
        flex-direction: column;
        min-height: 160px;
        background-color: #1772cc !important;
    }
    .main-card_company {
        display: flex;
        flex-direction: column;
        min-height: 160px;
        background-color: #398cdd;
    }
    .main-card_resume .v-card__actions,
    .main-card_vacancy .v-card__actions,
    .main-card_company .v-card__actions {
        margin-top: auto;
    }
    @media (max-width: 1400px) {
        .main-card {
            width: 30%;
        }
      .card__about{
        font-size: 14px;
      }
    }
    @media (max-width: 960px) {
        .main-card {
            width: 45%;
        }
    }
    @media (max-width: 600px) {
        .main-card {
            width: 100%;
            margin-right: 0;
        }
    }
    .statistics-link {
        display: flex;
        align-items: center;
        color: inherit;
        text-decoration: none;
    }
</style>
