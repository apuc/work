<template>
    <div>
        <v-subheader class="all-head">Ваши компании</v-subheader>
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
                                <v-list-tile-title class="mt-auto mb-auto"> {{ item.name }}</v-list-tile-title>
                                <v-list-tile-sub-title class="mt-auto mb-auto">Последнее обновление: {{ item.updated_at
                                    }}
                                </v-list-tile-sub-title>
                                <v-divider style="width: 100%;"></v-divider>
                            </v-list-tile-content>
                            <router-link :to="`${editLink}/${item.id}`">
                                <v-btn outline small fab
                                       class="edit-btn"
                                       type="button"
                                >
                                    <v-icon>edit</v-icon>

                                </v-btn>
                            </router-link>
                            <v-btn outline small fab
                                   class="edit-btn"
                                   type="button"
                                   @click="removeResume(index, item.id)"
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
                                @input="changePage"
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
                getAllCompany: [],
                paginationPageCount: 1,
                paginationCurrentPage: 1
            }
        },
        mounted() {
            document.title = this.$route.meta.title;
            this.$http.get(`${process.env.VUE_APP_API_URL}/request/company/my-index`)
                .then(response => {
                        this.getAllCompany = response.data;
                        this.getAllCompany.forEach((element) => {
                            let timestamp = element.updated_at;
                            let date = new Date();
                            date.setTime(timestamp * 1000);
                            element.updated_at = date.getDate() + '.' + (date.getMonth() + 1) + '.' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
                        });
                        this.paginationPageCount = response.headers.map['x-pagination-page-count'][0];
                    }, response => {
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 4000,
                        type: 'error',
                        title: response.data.message
                    })
                    }
                );

        },
        methods: {
            removeResume(index, resumeId) {
                this.getAllCompany.splice(index, 1);
                this.$http.delete(`${process.env.VUE_APP_API_URL}/request/company/` + resumeId)
                    .then(response => {
                        return response;
                        }, response => {
                        this.$swal({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 4000,
                            type: 'error',
                            title: response.data.message
                        })
                        }
                    );
            },
            changePage(paginationCurrentPage) {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/company/my-index?page=` + paginationCurrentPage)
                    .then(response => {
                            this.getAllCompany = response.data;
                        }, response => {
                        this.$swal({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 4000,
                            type: 'error',
                            title: response.data.message
                        })
                        }
                    );
            }
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
</style>