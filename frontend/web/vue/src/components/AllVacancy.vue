<template>

    <div>
        <v-subheader class="all-head">
            Ваши вакансии (Осталось поднятий: {{ vacancyRenew }}
            <v-btn small color="primary"
                   class="buy-vacancy-renew"
                   type="button"
                   title="Купить поднятие"
                   @click="buyVacancyRenew"
            >
                <v-icon dark>add</v-icon>
            </v-btn>
            ,
            Осталось вакансий: {{ vacancyCreate }}
            <v-btn small color="primary"
                   class="buy-vacancy-renew"
                   type="button"
                   title="Купить вакансию"
                   @click="buyVacancyCreate"
            >
                <v-icon dark>add</v-icon>
            </v-btn>
            )
            <router-link class="vacancy__link" to="/personal-area/add-vacancy" v-if="vacancyCreate > 0">
                <v-btn class="vacancy__link">
                    Добавить вакансию
                </v-btn>
            </router-link>
        </v-subheader>
        <template v-if="getAllVacancy.length === 0">
            <v-subheader>У вас нет вакансий</v-subheader>
        </template>

        <template v-else>
            <div>
                <div class="all-resume">

                    <v-list two-line>

                        <v-list-tile
                                v-for="(item, index) in getAllVacancy"
                                :key="index"
                                style="margin-top: 20px;"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title class="mt-auto mb-auto">
                                    <a :href="domen + '/vacancy/view/' + item.id" target="_blank">
                                        {{ item.post | capitalize }}
                                    </a>
                                </v-list-tile-title>
                                <v-list-tile-sub-title class="mt-auto mb-auto">
                                    Последнее поднятие: {{ item.update_time }}
                                    Активна до: {{ item.active_until }}
                                    <span v-if="item.day_vacancy_until != 0">Вакансия дня до: {{ item.day_vacancy_until }}</span>
                                </v-list-tile-sub-title>
                                <v-divider style="width: 100%;"></v-divider>
                            </v-list-tile-content>
                            <v-menu offset-y>
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                        color="primary"
                                        dark
                                        v-on="on"
                                    >
                                        <v-icon>menu</v-icon>
                                    </v-btn>
                                </template>
                                <v-list>
                                    <v-list-tile>
                                        <router-link :to="`${editLink}/${item.id}`">
                                            <v-btn
                                                   class="edit-btn"
                                                   type="button"
                                                   title="Редактировать"
                                            >
                                                Редактировать
                                            </v-btn>
                                        </router-link>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-btn
                                               :disabled="dateNow < item.vacancy_day_timestamp"
                                               class="edit-btn"
                                               type="button"
                                               title="Поднять в ТОП"
                                               @click="vacancyDay(item.id)"
                                        >
                                            Сделать вакансией дня
                                        </v-btn>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-btn
                                               v-bind:disabled="item.can_update == false || vacancyRenew === 0"
                                               class="edit-btn"
                                               type="button"
                                               title="Поднять в ТОП"
                                               @click="vacancyUpdate(index, item.id)"
                                        >
                                            Поднять в ТОП
                                        </v-btn>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-btn
                                               class="edit-btn"
                                               type="button"
                                               title="Удалить"
                                               @click="vacancyRemove(index, item.id)"
                                        >
                                            Удалить
                                        </v-btn>
                                    </v-list-tile>
                                </v-list>
                            </v-menu>

                        </v-list-tile>
                    </v-list>

                </div>

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
    import {mapGetters} from 'vuex';

    export default {
        name: "AllResume",
        data() {
            return {
                editLink: '/personal-area/edit-vacancy',
                getAllVacancy: [],
                paginationPageCount: 1,
                paginationCurrentPage: 1,
                domen: '',
                vacancyRenew: 0,
                vacancyCreate: 0,
                servicePrice: [],
                dateNow: 0
            }
        },
        created() {
            document.title = this.$route.meta.title;
            this.getVacancy(1);
            this.getCompany();
            this.getPrice();
            this.dateNow = Math.floor(Date.now() / 1000);
        },
        methods: {
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
                        title: error.message
                    })
                });
            },
            buyVacancyRenew() {
                let price = 0;
                this.servicePrice.forEach( (item) => {
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
                                        title: error.message
                                    })
                                });
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
            buyVacancyCreate() {
                let price = 0;
                this.servicePrice.forEach( (item) => {
                    if (item.alias === 'vacancy_create') {
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
                                        title: error.message
                                    })
                                });
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
                this.servicePrice.forEach( (item) => {
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
            vacancyUpdate(index, vacancyId) {
                this.$store.dispatch('updateVacancy', vacancyId)
                    .then(data => {
                        this.getVacancy(this.paginationCurrentPage);
                        ym(53666866,'reachGoal','vacancy_to_top');
                        this.getCompany();
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
</style>
