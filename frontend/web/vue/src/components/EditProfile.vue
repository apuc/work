<template>
    <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" >
    </FormTemplate>
</template>

<script>
    import FormProfile from '../lk-form/profile-form';
    import FormTemplate from "./FormTemplate";
    import Profile from "../mixins/profile";

    export default {
        name: 'FormResume',
        mixins: [Profile],
        components: {FormTemplate},
        created() {
            document.title = this.$route.meta.title;
        },
        mounted() {
            this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index?expand=phone,user`)
                .then(response => {
                        this.formData.first_name = response.data[0].first_name;
                        this.formData.second_name = response.data[0].second_name;
                        this.formData.birth_date = response.data[0].birth_date;
                        this.formData.email = response.data[0].user.email;
                        if (response.data[0].phone != null) {
                            this.formData.phone = response.data[0].phone.number;
                        }
                        this.idEmployer = response.data[0].id;
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
                    first_name: this.formData.first_name,
                    second_name: this.formData.second_name,
                    birth_date: this.formData.birth_date,
                    email: this.formData.email,
                    phone: this.formData.phone
                };

                this.$http.patch(`${process.env.VUE_APP_API_URL}/request/employer/` + this.idEmployer, data)
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
                    )
            },
            getFormData() {
                return FormProfile;
            }
        },
    }

</script>

<style scoped>

</style>