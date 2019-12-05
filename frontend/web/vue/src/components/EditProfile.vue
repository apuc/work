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
                        this.dataProfile = response.data[0];
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
                            this.$swal({
                            title: 'Данные сохранены'
                        }).then((result) => {
                                if (result.value) {
                                    this.$router.go();
                                }
                            });
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
        beforeRouteLeave(to, from, next) {
            if ((this.formData.first_name != this.dataProfile.first_name) ||
                (this.formData.second_name != this.dataProfile.second_name) ||
                    (this.formData.birth_date != this.dataProfile.birth_date) ||
                        (this.formData.email != this.dataProfile.user.email) ||
                        (this.dataProfile.phone != null && this.formData.phone != this.dataProfile.phone.number) ||
                        (this.dataProfile.phone == null && this.formData.phone != ''))
            {
                next(false);
                this.$swal({
                    title: 'Вы точно не хотите сохранить изменения?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        next();
                    }
                })
            } else {
                next();
            }
        }
    }

</script>

<style scoped>

</style>