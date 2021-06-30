<template>
    <div>
        <template v-if="companyFlag === '' || companyFlag === null">
            <v-subheader>Для создания вакансии заполните страницу компании</v-subheader>
            <router-link class="vacancy__link" to="/personal-area/edit-company">
                <v-btn class="vacancy__link">
                    Перейти к компании
                </v-btn>
            </router-link>
        </template>
        <template v-else>
            <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" @val="valHandler">

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
        </template>

    </div>
</template>

<script>
    import FormVacancy from '../lk-form/vacancy-form';
    import FormTemplate from "./FormTemplate";
    import Vacancy from "../mixins/vacancy";
    import FormResume from "../lk-form/resume-form";

    export default {
        name: "FormVacancy",
        components: {FormTemplate},
        mixins: [Vacancy],

        created() {
            this.getEmployment();
            this.getNameCompany();
            this.getExperienceArray();
            this.getUserData();
            this.getCity();
        },

        mounted() {
            document.title = this.$route.meta.title;
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
            getUserData() {
                this.$store.dispatch('getUserMe', this.$route.params.id)
                    .then(data => {
                        this.formData.birth_date = data.birth_date;
                        if (data.phone.number != null) {
                            this.formData.phone = data.phone.number;
                            if (this.formData.phone.length === 16) {
                                this.phone.text = '';
                                this.phone.valid = true;
                                this.formData.phoneValid = true;
                            } else {
                                this.phone.text = 'Вы ввели не верный номер телефона';
                                this.phone.valid = false;
                                this.formData.phoneValid = false;
                            }
                        } else {
                            this.phone.text = 'Вы ввели не верный номер телефона';
                            this.phone.valid = false;
                            this.formData.phoneValid = false;
                        }
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
            saveData() {
                let data = {
                    phone: this.formData.phone,
                    city_id: this.formData.vacancyCity,
                    main_category_id: this.formData.category.mainCategoriesVacancy,
                    category: this.formData.category.subcategories,
                    post: this.formData.post,
                    responsibilities: this.formData.duties,
                    employment_type_id: this.formData.typeOfEmployment,
                    min_salary: this.formData.salaryFrom,
                    max_salary: this.formData.salaryBefore,
                    qualification_requirements: this.formData.qualificationRequirements,
                    description: this.formData.description,
                    work_experience: this.formData.experience,
                    education: this.formData.education,
                    working_conditions: this.formData.workingConditions,
                    video: this.formData.vacancyVideo,
                    address: this.formData.officeAddress,
                    home_number: this.formData.houseNumber,
                };
                this.$store.dispatch('addVacancy', data)
                    .then(data => {
                        this.$router.push('/personal-area/all-vacancy');
                        gtag('event', 'vacancyAdd', { 'event_category': 'form', 'event_action': 'vacancyAdd', });
                        yaCounter53666866.reachGoal('vacancyAdd');
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
            getFormData() {
                return FormVacancy;
            },
            getEmployment() {
                this.$store.dispatch('getEmploymentType', this.$route.params.id)
                    .then(data => {
                        FormVacancy.typeOfEmployment.items = data;
                        for (let i = 0; i < data.length; i++) {
                            this.$set(FormVacancy.typeOfEmployment.items, i, data[i]);
                        }
                        this.$forceUpdate();
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
            getNameCompany() {
                this.$store.dispatch('getCompanyName')
                    .then(data => {
                        this.companyFlag = data.contact_person;
                        this.$forceUpdate();
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
            getExperienceArray() {
                this.$store.dispatch('getExperience', this.$route.params.id)
                    .then(data => {
                        FormVacancy.experience.items = data;
                        for (let i = 0; i < data.length; i++) {
                            this.$set(FormVacancy.experience.items, i, data[i]);
                        }
                        this.$forceUpdate();
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
            getCity() {
                this.$store.dispatch('getCity', this.$route.params.id)
                    .then(data => {
                        FormVacancy.vacancyCity.items = data.map(vacancyCity => ({
                            id: vacancyCity.id,
                            name: vacancyCity.name,
                        }));
                        this.$forceUpdate();
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
            valHandler(val) {
                this.valid = val;
                this.onInput();
            },
        },
        beforeRouteLeave(to, from, next) {
            if ((this.formData.vacancyCity.length > 0 || this.formData.post.length > 0 || this.formData.duties.length > 0) && !this.valid) {
                next(false);
                this.$swal({
                    title: 'Вы точно не хотите сохранить вакансию?',
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

<style>
    .vacancy__link {
        text-decoration: none;
        color: #1976d2 !important;
    }
</style>
