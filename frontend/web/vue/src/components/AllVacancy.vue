<template>

  <div>
    <v-subheader class="all-head">
      <div class="vacancy__block__wrapper">
        <div class="vacancy__title">Ваши вакансии</div>
        <span class="vacancy__wrapper__bracket">(</span>Осталось поднятий: {{ vacancyRenew }}
        <v-btn small color="primary"
               class="buy-vacancy-renew"
               type="button"
               title="Купить поднятие"
               @click="buyVacancyRenew"
        >
          <v-icon dark>add</v-icon>
        </v-btn>
      </div>
      <span class="comma">,</span>
      <div class="vacancy__block__wrapper">
        <div v-if="timestemp !== null && timestemp > Date.now()/1000" class="wrapp_tarif_block">
            Бесконечные вакансии до {{ new Date (timestemp * 1000).getDate() }} {{ mnth[new Date (timestemp * 1000).getMonth() + 1] }}
          <div title="Вам подключен тариф стандартный">
            <v-btn small color="primary"
              class="buy-vacancy-renew"
              type="button"
              @click="buyVacancyCreate"
              :disabled="isButtonDisabled"
            >
              <v-icon dark>add</v-icon>
            </v-btn>
          </div>
        </div>

        <div v-else>
          Осталось вакансий: {{ vacancyCreate }}
          <v-btn small color="primary"
               class="buy-vacancy-renew"
               type="button"
               title="Купить вакансию"
               @click="buyVacancyCreate"
               :disabled="!isButtonDisabled"
               >
              <v-icon dark>add</v-icon>
          </v-btn>
        </div>
        
        <span class="vacancy__wrapper__bracket">)</span>
      </div>

      <router-link class="vacancy__link" to="/personal-area/add-vacancy" v-if="vacancyCreate > 0 || (timestemp !== null && timestemp > Date.now()/1000)">
        <v-btn class="vacancy__link">
          Создать вакансию
        </v-btn>
      </router-link>
    </v-subheader>
    <template v-if="getAllVacancy.length === 0">
      <div class='vacancy__container_empty' v-if="getAllVacancy.length === 0">
        <div class="resume__item free__vacancy" v-if="getAllVacancy.length<2 && (timestemp === null && timestemp < Date.now()/1000)">
          <div class="resume__actions" style="margin-top: 74px;">
            <div class="resume__actions_group">
              <div class="resume__actions__item"><img :src="crownIcon" alt="" class="actions_icons">Сделать <b> вакансией дня</b></div>
              <div class="resume__actions__item"><img :src="topLeftIcon" alt="" class="actions_icons"><span>Поднять</span> <span style="font-weight: bold;"> в топ</span></div>
            </div>
            <!--            <div>-->
            <div class="resume__actions__item">
              <img :src="editIcon" alt="" class="actions_icons"> <span>Редактировать вакансию</span>
            </div>
            <div class="resume__actions__item">
              <img :src="deleteIcon" alt="" class="actions_icons"> <span>Удалить вакансию</span>
            </div>
            <!--            </div>-->
          </div>
          <div class="hover__vacancy" v-if="timestemp === null || timestemp < Date.now()/1000">
            <h2 class="hover__vacancy__title">+ БЕСПЛАТНАЯ ВАКАНСИЯ</h2>
            <router-link class="vacancy__link" to="/personal-area/add-vacancy">
              <v-btn round color="#dd3d34" dark class="hover__vacancy_btn my-btn">Создать вакансию</v-btn>
            </router-link>
          </div>
        </div>
        <div class="resume__item add__vacancy" v-if="timestemp === null || timestemp < Date.now()/1000">
          <h2 class="add__vacancy__title">ДОБАВИТЬ ЕЩЁ ВАКАНСИЮ</h2>
          <div v-if="vacancyCreate===0"><span style="color:#dd3d34;font-weight: 600;">Лимит вакансий исчерпан.</span>
            <span style="font-weight: 600;" v-if="servicePrice[2]">Цена дополнительной вакансии {{ servicePrice[2].price }} руб.</span>
            <div >
              <v-btn round color="#dd3d34" dark class="add__vacancy_btn mt-0 ml-0 my-btn" @click="buyVacancyCreate">Купить вакансию</v-btn>
              <p class="add__vacancy_text" style="margin-top: 30px;">* В месяц пользователям система даёт 1 бесплатную вакансию</p>
            </div>
          </div>
          <div style="margin-top: 30px;" v-if="vacancyCreate > 0 || (timestemp !== null && timestemp > Date.now()/1000)">
            <router-link class="vacancy__link" to="/personal-area/add-vacancy" >
              <v-btn round color="#dd3d34" dark class="add__vacancy_btn mt-0 ml-0 my-btn">Создать вакансию</v-btn>
            </router-link>
            <p class="add__vacancy_text">* В месяц пользователям система даёт 1 бесплатную вакансию</p>
          </div>
        </div>
      </div>
    </template>

    <template v-else>
      <div class="resume__container">
        <div class="resume__item" v-for="(item, index) in getAllVacancy" :key="index" :style="isVacancyActive(item.active_until)? {backgroundColor: 'initial'} : {backgroundColor: '#e1ecf6'}">
          <a class="resume__title" :href="domen + '/vacancy/view/' + item.id" target="_blank">
            {{ item.post | capitalize }}
          </a>
          <h4 class="resume__subtitle">
            Последнее поднятие: <span class="subtitle__last-up">{{ item.update_time }} </span>
          </h4>
          <span v-if="item.day_vacancy_until !== 0">Вакансия дня до: {{ item.day_vacancy_until }}</span>
          <hr style="margin-right: 30px;margin-top: 5px;">
          <div class="resume__actions">
            <div class="resume__actions_group">
              <div class="resume__actions__item" @click="vacancyDay(item.id)" :class="{disabled__item: dateNow < item.vacancy_day_timestamp}">
                <img :src="crownIcon" alt="" class="actions_icons">Сделать <b> вакансией дня</b>
              </div>
              <div v-if="item.can_update && vacancyRenew > 0" @click="vacancyUpdate(index, item.id)" class="resume__actions__item">
                <img :src="topLeftIcon" alt="" class="actions_icons">Поднять <b> в топ</b>
              </div>
              <div v-else class="resume__actions__item disabled__item" >
                <img :src="topLeftIcon" alt="" class="actions_icons">Поднять <b> в топ</b>
              </div>
              <template v-if="canBeFixing">
                <div class="resume__actions__item fixing_item" @click="onAnchor(item.id, item)"
                     v-if="canBeAnchored(item.anchored_until)">
                  <img :src="fixIcon" alt="" class="actions_icons">Закрепить <b> вакансию</b>
                </div>
                <div class="resume__actions__item fixing_item" v-else>
                  <img :src="fixIcon" alt="" class="actions_icons">Вакансия <b> закреплена</b>
                </div>
              </template>
            </div>
            <!--            <div>-->
            <router-link :to="`${editLink}/${item.id}`">
              <div class="resume__actions__item">
                <img :src="editIcon" alt="" class="actions_icons"> <span>Редактировать вакансию</span>
              </div>
            </router-link>
            <div class="resume__actions__item" @click="vacancyRemove(index, item.id)">
              <img :src="deleteIcon" alt="" class="actions_icons"> <span>Удалить вакансию</span>
            </div>
            <!--            </div>-->
          </div>
          <div class="mt-6" style="font-weight: 600;">
            Ваша вакансия
            <div v-if="isVacancyActive(item.active_until)">
              <span style="font-weight: 800"> Активна до: <span class="subtitle__active">{{ item.active_until }}</span></span>
              <v-btn round color="#dd3d34" dark class="hover__vacancy_btn my-btn mt-0" style="background-color: rgb(189 189 189);; font-size: 11px; font-weight: 600;margin-left: 30px;">
                ПРОДЛИТЬ ВАКАНСИЮ
              </v-btn>
            </div>
            <div v-else>
              <span class="vacancy__inactive">НЕ активна</span>
              <div v-if="(timestemp == null || timestemp < Date.now()/1000) && vacancyCreate == 0">
                <v-btn round color="#dd3d34" dark class="hover__vacancy_btn my-btn mt-0" style="background-color: #1976d2; font-size: 11px; font-weight: 600;margin-left: 30px;" @click="buyVacancyCreate">
                  ПРОДЛИТЬ ВАКАНСИЮ
                </v-btn>
              </div>
              <div v-else>
                <v-btn round color="#dd3d34" dark class="hover__vacancy_btn my-btn mt-0" style="background-color: #1976d2; font-size: 11px; font-weight: 600;margin-left: 30px;" @click="prolongVacancyCreate(item.id)">
                  ПРОДЛИТЬ ВАКАНСИЮ
                </v-btn>
              </div>
            </div>
          </div>
        </div>
        <div class="resume__item free__vacancy" v-if="getAllVacancy.length<2 && (timestemp === null && timestemp < Date.now()/1000)">
          <div class="resume__actions" style="margin-top: 74px;">
            <div class="resume__actions_group">
              <div class="resume__actions__item"><img :src="crownIcon" alt="" class="actions_icons">Сделать <b> вакансией дня</b></div>
              <div class="resume__actions__item"><img :src="topLeftIcon" alt="" class="actions_icons"><span>Поднять</span> <span style="font-weight: bold;"> в топ</span></div>
            </div>
            <!--            <div>-->
            <div class="resume__actions__item">
              <img :src="editIcon" alt="" class="actions_icons"> <span>Редактировать вакансию</span>
            </div>
            <div class="resume__actions__item">
              <img :src="deleteIcon" alt="" class="actions_icons"> <span>Удалить вакансию</span>
            </div>
            <!--            </div>-->
          </div>
          <div class="hover__vacancy" v-if="timestemp === null || timestemp < Date.now()/1000">
            <h2 class="hover__vacancy__title">+ БЕСПЛАТНАЯ ВАКАНСИЯ</h2>
            <router-link class="vacancy__link" to="/personal-area/add-vacancy">
              <v-btn round color="#dd3d34" dark class="hover__vacancy_btn my-btn">Создать вакансию</v-btn>
            </router-link>
          </div>
        </div>
        <div class="resume__item add__vacancy" v-if="timestemp === null && timestemp < Date.now()/1000">
          <h2 class="add__vacancy__title">ДОБАВИТЬ ЕЩЁ ВАКАНСИЮ</h2>
          <div v-if="vacancyCreate===0"><span style="color:#dd3d34;font-weight: 600;">Лимит вакансий исчерпан.</span>
            <span style="font-weight: 600;" v-if="servicePrice[2]">Цена дополнительной вакансии {{ servicePrice[2].price }} руб.</span>
            <div >
            <v-btn round color="#dd3d34" dark class="add__vacancy_btn mt-0 ml-0 my-btn" @click="buyVacancyCreate">Купить вакансию</v-btn>
            <p class="add__vacancy_text" style="margin-top: 30px;">* В месяц пользователям система даёт 1 бесплатную вакансию</p>
            </div>
          </div>
          <div style="margin-top: 30px;" v-if="vacancyCreate > 0 || (timestemp !== null && timestemp > Date.now()/1000)">
            <router-link class="vacancy__link" to="/personal-area/add-vacancy" >
              <v-btn round color="#dd3d34" dark class="add__vacancy_btn mt-0 ml-0 my-btn">Создать вакансию</v-btn>
            </router-link>
            <p class="add__vacancy_text">* В месяц пользователям система даёт 1 бесплатную вакансию</p>
          </div>
        </div>
      </div>
      <div>

        <template v-if="paginationPageCount > 1">
          <div class="text-xs-center">
            <v-pagination
                v-model="paginationCurrentPage"
                :length="paginationPageCount"
                @input="getVacancy"
            ></v-pagination>
          </div>
        </template>

      </div>
    </template>
  </div>

</template>

<script>

export default {
  name: "AllResume",
  data() {
    return {
      isButtonDisabled: true,
      mnth: [null, "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"],
      timestemp: null,
      editLink: '/personal-area/edit-vacancy',
      getAllVacancy: [],
      onAnchorFlag: false,
      paginationPageCount: 1,
      paginationCurrentPage: 1,
      domen: '',
      vacancyRenew: 0,
      vacancyCreate: 0,
      servicePrice: [],
      dateNow: 0,
      raiseWithAnchorCount: null, // оставшееся ко-во закрепов
      editIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/pencil.svg',
      deleteIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/remove.svg',
      crownIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/crown.svg',
      topLeftIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/top-left.svg',
      fixIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/anchoring.svg',
    }
  },
  created() {
    document.title = this.$route.meta.title;
    this.getVacancy(1);
    this.getCompany();
    this.getPrice();
    this.getUser();
    this.dateNow = Math.floor(Date.now() / 1000);
  },
  computed: {
    /**
     *  Проверка на возможность пользователя закреплять вакансии
     */
    canBeFixing(){
      return this.timestemp !== null && this.timestemp > Date.now()/1000 && this.raiseWithAnchorCount !== null && this.raiseWithAnchorCount > 0
    }
  },
  methods: {
    async getUser() {
      await this.$store.dispatch('getUserMe')
          .then(data => {
            this.timestemp = data.user.company.unlimited_vacancies_until;
            this.raiseWithAnchorCount = data.user.company.raise_with_anchor_count;
          })
    },
    getPrice() {
      this.$store.dispatch('getServicePrice')
      .then(data => {
        this.servicePrice = data;
      }).catch(error => {
        this.$swal({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 4000,
          type: 'error',
          title: error
        })
      });
    },
    buyVacancyRenew() {
      let price = 0;
      this.servicePrice.forEach((item) => {
        if (item.alias === 'vacancy_renew') {
          price = item.price
        }
      });
      this.$swal({
        title: 'Цена ' + price + ' ₽. Вы уверены?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('buyRenew')
          .then(data => {
            this.getCompany();
            this.$store.dispatch('getUserMe', this.$route.params.id)
            .then(data => {
              return data;
            }).catch(error => {
              this.$swal({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 4000,
                type: 'error',
                title: error
              })
            });
            return data;
          }).catch(error => {
            if (error === 'У вас недостаточно средств на счету') {
              this.$swal({
                title: 'У вас недостаточно средств на счету',
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Пополнить счет',
                cancelButtonText: 'Отмена'
              }).then((result) => {
                if (result.value) {
                  this.$router.push({name: 'payment',query: { price: price }});
                }
              });
            }
          });
        }
      });
    },
    prolongVacancyCreate(vacancyId) {
      let price = 0;
      this.servicePrice.forEach((item) => {
        if (item.alias === 'vacancy_create') {
          price = item.price
        }
      });
      this.$swal({
        title: 'У вас будет списана вакансия. Вы уверены ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('prolongVacancy', vacancyId)
              .then(data => {
                this.getCompany();
                this.$store.dispatch('getUserMe', this.$route.params.id)
                    .then(data => {
                      return data;
                    }).catch(error => {
                  this.$swal({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    type: 'error',
                    title: error
                  })
                });
                return data;
              }).catch(error => {
            if (error === 'У вас недостаточно средств на счету') {
              this.$swal({
                title: 'У вас недостаточно средств на счету',
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Пополнить счет',
                cancelButtonText: 'Отмена'
              }).then((result) => {
                if (result.value) {
                  this.$router.push({name: 'payment',query: { price: price }});
                }
              });
            }
          });
        }
      });
    },
    buyVacancyCreate() {
      let price = 0;
      this.servicePrice.forEach((item) => {
        if (item.alias === 'vacancy_create') {
          price = item.price
        }
      });
      this.$swal({
        title: 'Хотите купить вакансию ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('buyCreate')
          .then(data => {
            this.getCompany();
            this.$store.dispatch('getUserMe', this.$route.params.id)
            .then(data => {
              return data;
            }).catch(error => {
              this.$swal({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 4000,
                type: 'error',
                title: error
              })
            });
            return data;
          }).catch(error => {
            if (error === 'У вас недостаточно средств на счету') {
              this.$swal({
                title: 'У вас недостаточно средств на счету',
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Пополнить счет',
                cancelButtonText: 'Отмена'
              }).then((result) => {
                if (result.value) {
                  this.$router.push({name: 'payment',query: { price: price }});
                }
              });
            }
          });
        }
      });
    },
    getCompany() {
      this.$store.dispatch('getAllCompany')
      .then(data => {
        this.vacancyRenew = data.vacancy_renew_count;
        this.vacancyCreate = data.create_vacancy;
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
    getVacancy(page) {
      this.$store.dispatch('getAllVacancy', page)
      .then(data => {
        this.paginationCurrentPage = data.pagination.current_page;
        this.paginationPageCount = data.pagination.page_count;
        this.domen = `${process.env.VUE_APP_API_URL}`;
        this.getAllVacancy = data.models;
        this.getAllVacancy.forEach((element) => {
          let timestamp = element.update_time;
          let timestampDay = element.day_vacancy_until;
          element.vacancy_day_timestamp = timestampDay;
          let timestampActive = element.active_until;
          let date = new Date();
          let dateDay = new Date();
          let dateActive = new Date();
          date.setTime(timestamp * 1000);
          dateDay.setTime(timestampDay * 1000);
          dateActive.setTime(timestampActive * 1000);
          let options = {
            year: 'numeric',
            month: 'numeric',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
          };
          element.update_time = date.toLocaleString("ru", options);
          element.active_until = dateActive.toLocaleString("ru", options);
          if (element.day_vacancy_until != 0) {
            element.day_vacancy_until = dateDay.toLocaleString("ru", options);
          }
        });
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
    vacancyDay(vacancyId) {
      let price = 0;
      this.servicePrice.forEach((item) => {
        if (item.alias === 'day_vacancy') {
          price = item.price
        }
      });
      this.$swal({
        title: 'Цена ' + price + ' ₽. Вы уверены?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('vacancyDay', vacancyId)
          .then(data => {
            this.getVacancy(this.paginationCurrentPage);
            this.getCompany();
            return data;
          }).catch(error => {
            this.$swal({
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Пополнить счет',
              cancelButtonText: 'Отмена',
              showConfirmButton: true,
              type: 'error',
              title: error
            })
          });
        }
      });
    },
    /**
     * Закрепление вакансии по айди
     * @param vacancyId
     */
    onAnchor(vacancyId) {
      this.$store.dispatch('onAnchor', vacancyId).then(() => {
        this.getVacancy(this.paginationCurrentPage);
      })
    },
    canBeAnchored(anchored_until) {
      return anchored_until === null || anchored_until < Date.now()/1000
    },
    vacancyUpdate(index, vacancyId) {
      this.$swal({
        title: 'Вы уверены, что хотите использовать поднятие?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
      }).then((result) => {
            if (result.value) {
              this.$store.dispatch('updateVacancy', vacancyId)
              .then(data => {
                this.getVacancy(this.paginationCurrentPage);
                ym(53666866, 'reachGoal', 'vacancy_to_top');
                this.getCompany();
                return data;
              }).catch(error => {
                this.$swal({
                  toast: true,
                  position: 'bottom-end',
                  showConfirmButton: false,
                  timer: 4000,
                  type: 'error',
                  title: error
                })
              });
            }
          }
      )


    },
    vacancyRemove(index, vacancyId) {
      this.$swal({
        title: 'Вы точно хотите удалить вакансию?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('removeVacancy', vacancyId)
          .then(data => {
            this.getVacancy(this.paginationCurrentPage);
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
    isVacancyActive(itemDate) {
      return this.parseDate(new Date().toLocaleString().slice(0, -3)) < this.parseDate(itemDate)
    },
    async vacancyAddTime(item, index) {
      console.log(item,index,'itemindex')
      let date = this.parseDate(item.active_until)
      let price = 0;
      this.servicePrice.forEach((item) => {
        if (item.alias === 'vacancy_create') {
          price = item.price
        }
      });
      try {
        await this.$store.dispatch('prolongVacancy', {
          id: item.id,
          index: index,
          item: item,
          active_until: new Date(date.setMonth(date.getMonth() + 1)).toLocaleString().slice(0, -3)
        })
      } catch (e) {
        this.$swal({
          title: 'У вас недостаточно средств на счету',
          type: 'error',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Пополнить счет',
          cancelButtonText: 'Отмена'
        }).then((result) => {
          if (result.value) {
            this.$router.push({name: 'payment',query: { price: price }});
          }
        });
        console.log(e)
        return
      }
      this.vacancyCreate--
    },
    parseDate(dateString) {
      //"17.01.2021, 16:39" ожидается на ввод
      if (!dateString) return new Date();
      const regexp = /(\d+).(\d+).(\d+),\s(\d+):(\d+)/;
      if (!regexp.test(dateString)) throw new Error('date string format error');
      const d = regexp.exec(dateString);
      if (d[3].length == 2) d[3] = `20${d[3]}`;
      return new Date(d[3], d[2] - 1, d[1], d[4], d[5]);
    },
  },
  filters: {
    capitalize(val) {
      if (!val) {
        return '';
      }

      val = val.toString();

      return val.charAt(0).toUpperCase() + val.slice(1);
    },
  },
}
</script>

<style scoped>
.vacancy__container_empty {
  display: flex;
  flex-direction: column;
}

.disabled__item {
  filter: opacity(0.5);
  cursor: initial !important;
}

.my-btn {
  max-width: 192px !important;
  height: 40px;
  width: 192px;
}

.add__vacancy_text {
  width: 234px !important;
  display: inline-block;
  margin: 0;
  font-weight: 500;
  font-family: 'Muller', sans-serif;
}

.add__vacancy {
  padding-top: 45px !important;
  padding-left: 40px !important;
}

.add__vacancy__title {
  color: #1976d2;
  margin-bottom: 20px;
  font-family: 'Muller', sans-serif;
  font-weight: 800;
}

.add__vacancy_btn {
  text-transform: initial;
  margin-bottom: 24px !important;
  margin-right: 31px;
  /*margin-top: 25px;*/
  /*margin-top: 30px;*/
}

.free__vacancy {
  position: relative;
}

.hover__vacancy {
  padding-top: 35px;
  padding-left: 40px;
  position: absolute;
  width: 100%;
  /*background-color: #eaeaea;*/
  background-color: rgba(234, 234, 234, .8);
  max-width: 591px;
  height: 100%;
  top: 0;
  left: 0;
}

.hover__vacancy_btn {
  text-transform: initial;
  margin-top: 25px;
  font-family: 'Muller', sans-serif;
}

.hover__vacancy__title {
  color: #dd3d34;
  font-family: 'Muller', sans-serif;
}

/*.free__vacancy:before{*/
/*  content: '';*/
/*  position: absolute;*/
/*  width: 100%;*/
/*  background-color: #eaeaea;*/
/*  !*max-width: 591px;*!*/
/*  !*height: 100%*!*/

/*}*/
.resume__container {
  display: flex;
  flex-wrap: wrap;
}

.resume__actions_group {
  width: 50%;
}

.resume__actions__item {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  white-space: pre-wrap;
  color: initial;
  /*font-family: 'Muller', sans-serif;*/
}

.resume__actions__item:hover {
  cursor: pointer;
}

.resume__actions__item span {
  font-weight: 500;
}

.resume__actions__item img {
  margin-right: 15px;
}

.resume__actions {
  display: flex;
  /*justify-content: center;*/
  align-items: center;
  margin-top: 30px;
}

.resume__title {
  margin-bottom: 10px;
  color: #3c8ad8;
  font-size: 18px;
  font-family: 'Muller', sans-serif;
}

.resume__subtitle {
  margin-bottom: 6px;
  font-size: 15px;
  font-weight: 400;
  margin-top: 8px;
  /*color: #989898;*/
  color: #9aa4ae;
  /*font-family: 'Muller', sans-serif;*/
}

.resume__item {
  width: 100%;
  max-width: 591px;
  min-height: 215px;
  border: 1px solid #e8e8e8;
  padding-top: 21px;
  padding-left: 27px;
  margin-bottom: 23px;
  margin-right: 27px;
}

.actions_icons {
  width: 31px;
  height: 31px;
}

.all-resume .theme--light.v-list {
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
  display: flex;
  flex-wrap: wrap;
  height: auto;

}

.all-head a {
  margin-left: 15px;
}

.all-head a button {
  text-transform: none !important;
}

.buy-vacancy-renew {
  max-width: 28px;
  min-width: 28px;
}

.vacancy__inactive {
  color: red;
}

.vacancy__block__wrapper {
  display: flex;
  align-items: center;
  flex-wrap: inherit;
}

.wrapp_tarif_block {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 5px;

}

@media (max-width: 560px) {
  .resume__actions {
    flex-wrap: wrap
  }

  .resume__actions__item:first-child {
    width: max-content;
  }

  .resume__item {
    padding-right: 27px;
  }
}

@media (max-width: 425px) {
  .comma {
    display: none;
  }

  .vacancy__wrapper__bracket {
    display: none;
  }

  .vacancy__block__wrapper {
    display: flex;
    flex-wrap: wrap;
  }
}
</style>
