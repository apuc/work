<template>
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

<script>
    import FormVacancy from '../lk-form/vacancy-form';
    import FormTemplate from "./FormTemplate";
    import Vacancy from "../mixins/vacancy";

    export default {
        name: 'FormResume',
        mixins: [Vacancy],
        components: {FormTemplate},
        created() {
            this.getEmployment();
            this.getNameCompany();
            this.getExperienceArray();
            this.getCity();
        },
        mounted() {
            document.title = this.$route.meta.title;
            this.$store.dispatch('getVacancy', this.$route.params.id)
                .then(data => {
                    this.dataVacancy = data;
                    this.formData.phone = data.phone;
                    if (this.formData.phone.length > 0) {
                        this.formData.phoneValid = true;
                    }
                    this.formData.vacancyCity = data.city_id;
                    this.formData.companyName = data.company_id;
                    this.formData.category.mainCategoriesVacancy = data.main_category_id;
                    data.category.forEach((item) => {
                        this.formData.category.subcategories.push(item.id);
                    });
                    this.formData.post = data.post;
                    this.formData.duties = data.responsibilities;
                    this.formData.typeOfEmployment = data.employment_type_id;
                    if(data.min_salary) {
                        this.formData.salaryFrom = data.min_salary;
                    }
                    if(data.max_salary) {
                        this.formData.salaryBefore = data.max_salary;
                    }
                    this.formData.qualificationRequirements = data.qualification_requirements;
                    this.formData.description = data.description;
                    this.formData.experience = data.work_experience;
                    this.formData.education = data.education;
                    this.formData.workingConditions = data.working_conditions;
                    this.formData.vacancyVideo = data.video;
                    this.formData.officeAddress = data.address;
                    this.formData.houseNumber = data.home_number;
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

                let dataObj = {
                    id: this.$route.params.id,
                    data: data
                }

                this.$store.dispatch('editVacancy', dataObj)
                    .then(data => {
                        this.$router.push('/personal-area/all-vacancy');
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
                this.$store.dispatch('getCompanyName', this.$route.params.id)
                    .then(data => {
                        this.lengthCompany = data.length;
                        FormVacancy.companyName.items = [];
                        for (let i = 0; i < data.length; i++) {
                            if(data[i].name) {
                                FormVacancy.companyName.items.push(data[i]);
                            } else {
                                FormVacancy.companyName.items.push({name: data[i].contact_person, id: data[i].id});
                            }
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
            getCity() {this.$store.dispatch('getCity', this.$route.params.id)
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
            },
        },
        beforeRouteLeave(to, from, next) {
            if (this.dataVacancy.max_salary == null) {
                this.dataVacancy.max_salary = '';
            }
            if (this.dataVacancy.min_salary == null) {
                this.dataVacancy.min_salary = '';
            }
            const tmpResume = {
                'phone': this.formData.phone,
                'city': this.dataVacancy.city_id,
                'company_id': this.dataVacancy.company_id,
                'main_category_id': this.dataVacancy.main_category_id,
                'post': this.dataVacancy.post,
                'responsibilities': this.dataVacancy.responsibilities,
                'employment_type_id': this.dataVacancy.employment_type_id,
                'min_salary': this.dataVacancy.min_salary,
                'max_salary': this.dataVacancy.max_salary,
                'qualification_requirements': this.dataVacancy.qualification_requirements,
                'work_experience': this.dataVacancy.work_experience,
                'education': this.dataVacancy.education,
                'working_conditions': this.dataVacancy.working_conditions,
                'video': this.dataVacancy.video,
                'address': this.dataVacancy.address,
                'home_number': this.dataVacancy.home_number,
            };
            const tmpFormData = {
                'phone': this.formData.phone,
                'city': this.formData.vacancyCity,
                'company_id': this.formData.companyName,
                'main_category_id': this.formData.category.mainCategoriesVacancy,
                'post': this.formData.post,
                'responsibilities': this.formData.duties,
                'employment_type_id': this.formData.typeOfEmployment,
                'min_salary': this.formData.salaryFrom,
                'max_salary': this.formData.salaryBefore,
                'qualification_requirements': this.formData.qualificationRequirements,
                'work_experience': this.formData.experience,
                'education': this.formData.education,
                'working_conditions': this.formData.workingConditions,
                'video': this.formData.vacancyVideo,
                'address': this.formData.officeAddress,
                'home_number': this.formData.houseNumber,
            };
            let formValid = true;
            for (let i in tmpResume) {
                if(tmpResume[i] !== tmpFormData[i]) {
                    formValid = false;
                    break;
                }
            }
            if (!formValid && !this.valid) {
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

<style>

</style>
