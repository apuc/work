<template>
    <div>
        <v-subheader class="all-head">
            Ваши компании
            <router-link v-if="companiesCount < 1" class="vacancy__link" to="/personal-area/add-company">
                <v-btn class="vacancy__link">
                    Добавить компанию или частное лицо
                </v-btn>
            </router-link>
        </v-subheader>
        <template v-if="getAllCompany.length === 0">
            <v-subheader>У вас нет компаний</v-subheader>
        </template>

        <template v-else>
            <div>
                <div class="all-resume">

                    <v-list two-line>

                        <v-list-tile
                                v-for="(item, index) in getAllCompany"
                                :key="index"
                                style="margin-top: 20px;"
                        >
                            <v-list-tile-avatar>
                                <img :src="item.image_url" alt="">
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title v-if="item.name.length > 0" class="mt-auto mb-auto"> {{ item.name }}</v-list-tile-title>
                                <v-list-tile-title v-else class="mt-auto mb-auto"> {{ item.contact_person }}</v-list-tile-title>
                                <v-list-tile-sub-title class="mt-auto mb-auto">Последнее обновление: {{ item.updated_at }}
                                </v-list-tile-sub-title>
                                <v-divider style="width: 100%;"></v-divider>
                            </v-list-tile-content>
                            <router-link :to="`${companyTransfer}/${item.id}`" v-if="companiesCount > 1">
                                <v-btn class="vacancy__link">
                                    Передать компанию
                                </v-btn>
                            </router-link>
                            <router-link :to="`${editLink}/${item.id}`">
                                <v-btn outline small fab
                                       class="edit-btn"
                                       type="button"
                                       title="Редактировать"
                                >
                                    <v-icon>edit</v-icon>

                                </v-btn>
                            </router-link>
                            <router-link :to="`${companyRight}/${item.id}`" v-if="item.user_id == userID">
                                <v-btn outline small fab
                                       class="edit-btn"
                                       type="button"
                                       title="Доступ к компании"
                                >
                                    <v-icon>how_to_reg</v-icon>

                                </v-btn>
                            </router-link>
                            <v-btn outline small fab
                                   class="edit-btn"
                                   type="button"
                                   title="Удалить"
                                   @click="companyRemove(index, item.id)"
                            >
                                <v-icon>delete</v-icon>
                            </v-btn>
                        </v-list-tile>
                    </v-list>

                </div>

                <template v-if="paginationPageCount > 1">
                    <div class="text-xs-center">
                        <v-pagination
                                v-model="paginationCurrentPage"
                                :length="paginationPageCount"
                                @input="getCompany"
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
                editLink: '/personal-area/edit-company',
                companyRight: '/personal-area/company-right',
                companyTransfer: '/personal-area/company-transfer',
                getAllCompany: [],
                userID: '',
                paginationPageCount: 1,
                paginationCurrentPage: 1,
                companiesCount: 1
            }
        },
        mounted() {
            document.title = this.$route.meta.title;
            this.userID = localStorage.userId;
            this.getCompany(1);

        },
        methods: {
            getCompany(page) {
                this.$store.dispatch('getAllCompany', page)
                    .then(data => {
                        this.paginationCurrentPage = data.pagination.current_page;
                        this.paginationPageCount = data.pagination.page_count;
                        this.domen = `${process.env.VUE_APP_API_URL}`;
                        localStorage.companiesCount = data.models.length;
                        this.companiesCount = localStorage.companiesCount;
                        this.getAllCompany = data.models;
                        this.getAllCompany.forEach((element) => {
                            let timestamp = element.updated_at;
                            let date = new Date();
                            date.setTime(timestamp * 1000);
                            let options = {
                                year: 'numeric',
                                month: 'numeric',
                                day: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                            };
                            element.updated_at = date.toLocaleString("ru", options);
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
            companyRemove(index, companyId) {
                this.$swal({
                    title: 'Вы точно хотите удалить компанию?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        this.getAllCompany.splice(index, 1);
                        this.$store.dispatch('removeCompany', companyId)
                            .then(data => {
                                this.$store.dispatch('getUserMe', this.$route.params.id)
                                    .then(data => {
                                        localStorage.companiesCount = data.companiesCount;
                                        this.companiesCount = localStorage.companiesCount;
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
</style>
