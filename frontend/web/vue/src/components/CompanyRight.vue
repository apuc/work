<template>
    <div>
        <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" @val="valHandler">
        </FormTemplate>


        <v-subheader class="all-head">Учасники: </v-subheader>
        <template v-if="allUsers.length === 0">
            <v-subheader>Нет добавленных </v-subheader>
        </template>

        <template v-else>
            <div>
                <div class="all-resume">

                    <v-list two-line>

                        <v-list-tile
                                v-for="(item, index) in allUsers"
                                :key="index"
                                style="margin-top: 20px;"
                        >

                            <v-list-tile-content>
                                <v-list-tile-title class="mt-auto mb-auto"> {{ item.employer.first_name }} {{ item.employer.second_name }}</v-list-tile-title>
                                <v-list-tile-title  class="mt-auto mb-auto"> {{ item.email }}</v-list-tile-title>
                                <v-divider style="width: 100%;"></v-divider>
                            </v-list-tile-content>

                            <v-btn outline small fab
                                   class="edit-btn"
                                   type="button"
                                   @click="removeUser(index, item.id)"
                            >
                                <v-icon>delete</v-icon>
                            </v-btn>
                        </v-list-tile>
                    </v-list>

                </div>

            </div>
        </template>


    </div>
</template>

<script>
    import CompanyRight from '../lk-form/company-right';
    import FormTemplate from "./FormTemplate";

    export default {
        name: "CompanyRight",
        components: {FormTemplate},
        data() {
            return {
                formData: {
                    companyRight: ''
                },
                allUsers: []
            };
        },
        mounted(){
            document.title = this.$route.meta.title;
            this.$http.get(`${process.env.VUE_APP_API_URL}/request/company/` + this.$route.params.id + `?expand=users.employer`)
                .then(response => {
                      this.allUsers = response.data[0].users;
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
                )
        },
        methods: {
            saveData() {
                let data = {
                    email: this.formData.companyRight,
                    company_id: this.$route.params.id
                };
                this.$http.post(`${process.env.VUE_APP_API_URL}/request/company/add-user`, data)
                    .then(response => {
                        this.formData.companyRight = '';
                        let mainBtn = document.querySelector('#main-btn');
                        mainBtn.disabled = false;
                        this.$http.get(`${process.env.VUE_APP_API_URL}/request/company/` + this.$route.params.id + `?expand=users.employer`)
                            .then(response => {
                                    this.allUsers = response.data[0].users;
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
            getFormData() {
                return CompanyRight;
            },
            valHandler(val) {
                this.valid = val;
            },
            removeUser(index, userId) {
                this.allUsers.splice(index, 1);
                let data = {
                        user_id: userId,
                        company_id: this.$route.params.id
                };
                this.$http.post(`${process.env.VUE_APP_API_URL}/request/company/delete-user`, data)
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
        }
    }
</script>

<style scoped>

</style>