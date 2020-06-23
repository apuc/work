<template>

    <v-tabs
            centered
            light
            icons-and-text
    >
        <v-tabs-slider color="black"></v-tabs-slider>

        <v-tab href="#tab-1">
            Основное
        </v-tab>

        <v-tab href="#tab-2">
            Новый пароль
        </v-tab>

        <v-tab-item
                value="tab-1"
        >
            <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" >
                <vue-tel-input :placeholder="'Номер телефона'"
                               :defaultCountry="defaultCountry.iso2"
                               v-model="formData.phone"
                               :allCountries="allCountries"
                               :validCharactersOnly="true"
                               :required="true"
                               :inputOptions="{ showDialCode: true, tabindex: 0 }"
                               @country-changed="changeCountry"
                               @input="onInput"
                ></vue-tel-input>
                <p class="custom-error">{{ phone.text }}</p>
            </FormTemplate>
        </v-tab-item>

        <v-tab-item
                value="tab-2"
        >
                <NewPassword></NewPassword>
        </v-tab-item>
    </v-tabs>

</template>

<script>
    import FormProfile from '../lk-form/profile-form';
    import FormTemplate from "./FormTemplate";
    import Profile from "../mixins/profile";
    import NewPassword from "./NewPassword";

    export default {
        name: 'FormResume',
        mixins: [Profile],
        components: {FormTemplate, NewPassword},
        created() {
            document.title = this.$route.meta.title;
        },
        mounted() {
            this.$store.dispatch('getUserMe', this.$route.params.id)
                .then(data => {
                    this.dataProfile = data;
                    this.formData.first_name = data.first_name;
                    this.formData.second_name = data.second_name;
                    this.formData.birth_date = data.birth_date;
                    this.formData.email = data.user.email;
                    if (data.phone != null) {
                        this.formData.phone = data.phone.number;
                        this.formData.phoneValid = true;
                    }
                    this.idEmployer = data.id;
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
            this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index?expand=phone,user`)
                .then(response => {
                        this.dataProfile = response.data[0];
                        this.formData.first_name = response.data[0].first_name;
                        this.formData.second_name = response.data[0].second_name;
                        this.formData.birth_date = response.data[0].birth_date;
                        this.formData.email = response.data[0].user.email;
                        if (response.data[0].phone != null) {
                            this.formData.phone = response.data[0].phone.number;
                            this.formData.phoneValid = true;
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
            changeCountry(data) {
                if (data.iso2 === 'UA') {
                    this.defaultCountry.iso2 = data.iso2;
                    this.defaultCountry.dialCode = data.dialCode;
                }
                if (data.iso2 === 'RU') {
                    this.defaultCountry.iso2 = data.iso2;
                    this.defaultCountry.dialCode = data.dialCode;
                }
            },
            onInput() {
                this.phone.valid = false;
                if (this.defaultCountry.iso2 === 'UA') {
                    if (this.formData.phone.length === 16) {
                        this.phone.text = '';
                        this.phone.valid = true;
                        this.formData.phoneValid = true;
                    } else {
                        this.phone.text = 'Вы ввели не верный номер телефона';
                        this.phone.valid = false;
                        this.formData.phoneValid = false;
                    }
                }
                if (this.defaultCountry.iso2 === 'RU') {
                    if (this.formData.phone.length === 16) {
                        this.phone.text = '';
                        this.phone.valid = true;
                        this.formData.phoneValid = true;
                    } else {
                        this.phone.text = 'Вы ввели не верный номер телефона';
                        this.phone.valid = false;
                        this.formData.phoneValid = false;
                    }
                }
            },
            saveData() {
                let data = {
                    first_name: this.formData.first_name,
                    second_name: this.formData.second_name,
                    birth_date: this.formData.birth_date,
                    email: this.formData.email,
                    phone: this.formData.phone,
                    phoneValid: this.formData.phoneValid
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
            },
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
    .v-tabs {
        background-color: #ffffff;
        padding: 0 20px 20px;
    }
</style>