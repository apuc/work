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
                    companyRight: '',
                    phoneValid: true
                },
                allUsers: []
            };
        },
        mounted(){
            document.title = this.$route.meta.title;
            this.$store.dispatch('rightCompany', this.$route.params.id)
                .then(data => {
                    this.allUsers = data.users;
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
            saveData() {
                let data = {
                    email: this.formData.companyRight,
                    company_id: this.$route.params.id,
                    phoneValid: this.formData.phoneValid
                };
                this.$store.dispatch('addRightCompany', data)
                    .then(data => {
                        this.formData.companyRight = '';
                        let mainBtn = document.querySelector('#main-btn');
                        mainBtn.disabled = false;
                        // this.$store.dispatch('rightCompany', this.$route.params.id)
                        //     .then(data => {
                        //         this.allUsers = data.users;
                        //     }).catch(error => {
                        //     this.$swal({
                        //         toast: true,
                        //         position: 'bottom-end',
                        //         showConfirmButton: false,
                        //         timer: 4000,
                        //         type: 'error',
                        //         title: error.message
                        //     })
                        // });
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
                this.$store.dispatch('removeRightCompany', data)
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
            },
        }
    }
</script>

<style scoped>

</style>
