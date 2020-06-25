<template>
    <div>
        <template v-if="lengthCompany === 0">
            <v-subheader>Для создания вакансии добавьте компанию или частное лицо </v-subheader>
            <router-link class="vacancy__link" to="/personal-area/add-company">
                <v-btn class="vacancy__link">
                    Создать
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

    export default {
        name: "FormVacancy",
        components: {FormTemplate},
        mixins: [Vacancy],

        created() {
            this.getEmploymentType();
            this.getCompanyName();
            this.getExperience();
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
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index?expand=phone,user`)
                    .then(response => {
                            if (response.data[0].phone != null) {
                                this.formData.phone = response.data[0].phone.number;
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
            saveData() {
                let data = {
                    phone: this.formData.phone,
                    city_id: this.formData.vacancyCity,
                    company_id: this.formData.companyName,
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
                let res;
                this.$http.post(`${process.env.VUE_APP_API_URL}/request/vacancy`, data)
                    .then(response => {
                            this.$router.push('/personal-area/all-vacancy');
                            res = response;
                            gtag('event', 'vacancyAdd', { 'event_category': 'form', 'event_action': 'vacancyAdd', });
                            yaCounter53666866.reachGoal('vacancyAdd');
                            return true;
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
                return FormVacancy;
            },
            getEmploymentType() {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/employment-type`).then(response => {
                    FormVacancy.typeOfEmployment.items = response.data;
                    for (let i = 0; i < response.data.length; i++) {
                        this.$set(FormVacancy.typeOfEmployment.items, i, response.data[i]);
                    }
                }, response => {
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 4000,
                        type: 'error',
                        title: response.data.message
                    })
                });
            },
            getCompanyName() {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/company/my-index`).then(response => {
                    this.lengthCompany = response.data.length;
                    FormVacancy.companyName.items = [];
                    for (let i = 0; i < response.data.length; i++) {
                        if(response.data[i].name) {
                            FormVacancy.companyName.items.push(response.data[i]);
                        } else {
                            FormVacancy.companyName.items.push({name: response.data[i].contact_person, id: response.data[i].id});
                        }
                    }
                }, response => {
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 4000,
                        type: 'error',
                        title: response.data.message
                    })
                });
            },
            getExperience() {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/get-experiences`).then(response => {
                    FormVacancy.experience.items = response.data;
                    for (let i = 0; i < response.data.length; i++) {
                        this.$set(FormVacancy.experience.items, i, response.data[i]);
                    }
                }, response => {
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 4000,
                        type: 'error',
                        title: response.data.message
                    })
                });
            },
            getCity() {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/city`).then(response => {
                    FormVacancy.vacancyCity.items = response.data.map(vacancyCity => ({
                        id: vacancyCity.id,
                        name: vacancyCity.name,
                    }));
                    this.$forceUpdate();
                }, response => {
                    this.$swal({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 4000,
                        type: 'error',
                        title: response.data.message
                    })
                });
            },
            valHandler(val) {
                this.valid = val;
            },
        },
        beforeRouteLeave(to, from, next) {
            if ((this.formData.vacancyCity.length > 0 || this.formData.companyName.length > 0 || this.formData.post.length > 0 || this.formData.duties.length > 0) && !this.valid) {
                next(false);
                this.$swal({
                    title: 'Вы точно не хотите сохранить резюме?',
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