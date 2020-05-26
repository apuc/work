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
                               :enabledCountryCode="true"
                               :validCharactersOnly="true"
                               :required="true"
                               @country-changed="changeCountry"
                               @input="onInput"
                ></vue-tel-input>
                <p>{{ phone.valid }}</p>

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
        mounted() {
            document.title = this.$route.meta.title;
            this.getEmploymentType().then(response => {
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
            this.getCompanyName().then(response => {
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
            this.getExperience().then(response => {
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
            this.getCity().then(response => {
                FormVacancy.vacancyCity.items = response.data.map(vacancyCity => ({
                    id: vacancyCity.id,
                    name: vacancyCity.name,
                }));
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
            this.getUserData();
        },
        methods: {
            phoneValid() {
                if (this.defaultCountry.iso2 === 'UA') {
                    return this.formData.phone.length === 10;
                }
                if (this.defaultCountry.iso2 === 'Ru') {
                    this.defaultCountry.iso2 = data.iso2;
                }
            },
            changeCountry(data) {
                this.formData.phone = '';
                if (data.iso2 === 'UA') {
                    this.defaultCountry.iso2 = data.iso2;
                    this.defaultCountry.dialCode = data.dialCode;
                }
                if (data.iso2 === 'Ru') {
                    this.defaultCountry.iso2 = data.iso2;
                    this.defaultCountry.dialCode = data.dialCode;
                }
            },
            onInput() {
                console.log(this.formData.phone.length)
                if (this.formData.phone.length === 12) {
                    this.phone.valid = '';
                } else {
                    this.phone.valid = 'Вы ввели не верный номер телефона';
                }
            },
            getUserData() {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index?expand=phone,user`)
                    .then(response => {
                            if (response.data[0].phone != null) {
                                this.formData.phone = response.data[0].phone.number;
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
            async getEmploymentType() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/employment-type`)
            },
            async getCompanyName() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/company/my-index`)
            },
            async getExperience() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/get-experiences`)
            },
            async getCity() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/city`);
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