<template>
    <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" @val="valHandler">
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
            this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/` + this.$route.params.id + '?expand=employment-type,category')
                .then(response => {
                        this.dataVacancy = response.data;
                        this.formData.phone = response.data.phone;
                        this.formData.vacancyCity = response.data.city_id;
                        this.formData.companyName = response.data.company_id;
                        this.formData.category.mainCategoriesVacancy = response.data.main_category_id;
                        response.data.category.forEach((item) => {
                            this.formData.category.subcategories.push(item.id);
                        });
                        this.formData.post = response.data.post;
                        this.formData.duties = response.data.responsibilities;
                        this.formData.typeOfEmployment = response.data.employment_type_id;
                        if(response.data.min_salary) {
                            this.formData.salaryFrom = response.data.min_salary;
                        }
                        if(response.data.max_salary) {
                            this.formData.salaryBefore = response.data.max_salary;
                        }
                        this.formData.qualificationRequirements = response.data.qualification_requirements;
                        this.formData.description = response.data.description;
                        this.formData.experience = response.data.work_experience;
                        this.formData.education = response.data.education;
                        this.formData.workingConditions = response.data.working_conditions;
                        this.formData.vacancyVideo = response.data.video;
                        this.formData.officeAddress = response.data.address;
                        this.formData.houseNumber = response.data.home_number;
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
        },
        methods: {
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

                this.$http.patch(`${process.env.VUE_APP_API_URL}/request/vacancy/` + this.$route.params.id, data)
                    .then(response => {
                            this.$router.push('/personal-area/all-vacancy');
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
            if (this.dataVacancy.max_salary == null) {
                this.dataVacancy.max_salary = '';
            }
            if (this.dataVacancy.min_salary == null) {
                this.dataVacancy.min_salary = '';
            }
            const tmpResume = {
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