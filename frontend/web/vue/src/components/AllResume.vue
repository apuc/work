<template>
    <div>
        <v-subheader class="all-head">
            Ваши резюме
            <span v-if="userMe.audit_count > 0" class="audit">( Вы можете заказать аудит резюме <span class="hint" title="Наши специалисты просмотрят ваше резюме и внесут корректировки">?</span>)</span>
            <router-link class="vacancy__link" to="/personal-area/add-resume">
                <v-btn class="vacancy__link">
                    Добавить резюме
                </v-btn>
            </router-link>
        </v-subheader>
        <template v-if="getAllResume.length === 0">
            <v-subheader>У вас нет резюме</v-subheader>
        </template>

        <template v-else>
            <div>
                <div class="all-resume">

                    <v-list two-line>

                        <v-list-tile
                                v-for="(item, index) in getAllResume"
                                :key="index"
                                style="margin-top: 20px;"
                        >
                            <v-list-tile-avatar>
                                <img :src="item.image_url" alt="">
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title class="mt-auto mb-auto">
                                    <a :href="domen + '/resume/view/' + item.id" target="_blank">
                                        {{ item.title | capitalize }}
                                    </a>
                                </v-list-tile-title>
                                <v-list-tile-sub-title class="mt-auto mb-auto">Последнее обновление: {{ item.update_time
                                    }} <span v-if="item.audit_status === 1">Ожидает аудита</span>
                                    <span v-if="item.audit_status === 2">Аудит пройден</span>
                                </v-list-tile-sub-title>
                                <v-divider style="width: 100%;"></v-divider>
                                <span v-if="item.status == 2" class="all-resume-hide">скрыто</span>
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
                                               v-bind:disabled="item.can_update == false"
                                               class="edit-btn"
                                               type="button"
                                               title="Поднять в ТОП"
                                               @click="resumeUpdate(index, item.id)"
                                        >
                                            Поднять в ТОП
                                        </v-btn>
                                    </v-list-tile>
                                    <v-list-tile v-if="userMe.audit_count > 0">
                                        <v-btn
                                               class="edit-btn"
                                               type="button"
                                               title="Заказать аудит"
                                               @click="purchaseAudit(item.id)"
                                        >
                                            Заказать аудит
                                        </v-btn>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-btn
                                               class="edit-btn"
                                               type="button"
                                               title="Удалить"
                                               @click="resumeRemove(index, item.id)"
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
                                @input="getResume"
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
                editLink: '/personal-area/edit-resume',
                getAllResume: [],
                paginationPageCount: 1,
                paginationCurrentPage: 1,
                domen: ''
            }
        },
        created() {
            document.title = this.$route.meta.title;
            this.getResume(1);
        },
        methods: {
            purchaseAudit(id) {
                this.$store.dispatch('purchaseAudit', {id: id})
                    .then(data => {
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
                        title: error
                    })
                })
            },
            getResume(page) {
                this.$store.dispatch('getAllResume', page)
                    .then(data => {
                        this.paginationCurrentPage = data.pagination.current_page;
                        this.paginationPageCount = data.pagination.page_count;
                        this.domen = `${process.env.VUE_APP_API_URL}`;
                        this.getAllResume = data.models;
                        this.getAllResume.forEach((element) => {
                            let timestamp = element.update_time;
                            let date = new Date();
                            date.setTime(timestamp * 1000);
                            let options = {
                                year: 'numeric',
                                month: 'numeric',
                                day: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                            };
                            element.update_time = date.toLocaleString("ru", options);
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
            resumeUpdate(index, resumeId) {
                this.$store.dispatch('updateResume', resumeId)
                    .then(data => {
                        this.getResume(this.paginationCurrentPage);
                        ym(53666866,'reachGoal','resume_to_top');
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
            resumeRemove(index, resumeId) {
                this.$swal({
                    title: 'Вы точно хотите удалить резюме?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        this.$store.dispatch('removeResume', resumeId)
                            .then(data => {
                                this.getResume(this.paginationCurrentPage);
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

        computed: {
            ...mapGetters([
                'userMe',
            ])
        }
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
    .v-list__tile__content {
        position: relative;
    }
    .all-resume-hide {
        position: absolute;
        right: 40px;
        padding: 3px;
        font-size: 13px;
        color: rgba(0,0,0,0.62);
        line-height: 1;
        border-radius: 6px;
        border: 1px solid rgba(0,0,0,0.12);
    }
    .audit {
        display: flex;
        align-items: center;
    }
    .hint {
        width: 20px;
        height: 20px;
        background: #5055ef;
        border-radius: 50%;
        border: 1px solid #000000;
        cursor: pointer;
        font-size: 12px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
    }
</style>