<template>
    <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData">
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
            this.getCategory()
                .then(response => {
                    FormVacancy.categoriesVacancy.items = response.data;
                    for (let i = 0; i < response.data.length; i++) {
                        this.$set(FormVacancy.categoriesVacancy.items, i, response.data[i]);
                    }
                });
            this.getEmploymentType().then(response => {
                FormVacancy.typeOfEmployment.items = response.data;
                for (let i = 0; i < response.data.length; i++) {
                    this.$set(FormVacancy.typeOfEmployment.items, i, response.data[i]);
                }
            });
            this.getCompanyName().then(response => {
                FormVacancy.companyName.items = response.data;
                for (let i = 0; i < response.data.length; i++) {
                    this.$set(FormVacancy.companyName.items, i, response.data[i]);
                }
            });
            this.getExperience().then(response => {
                FormVacancy.experience.items = response.data;
                for (let i = 0; i < response.data.length; i++) {
                    this.$set(FormVacancy.experience.items, i, response.data[i]);
                }
            });
            this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/` + this.$route.params.id + '?expand=employment-type,category')
                .then(response => {
                        this.formData.city = response.data.city;
                        this.formData.companyName = response.data.company_id;
                        this.formData.categoriesVacancy = response.data.category;
                        this.formData.post = response.data.post;
                        this.formData.duties = response.data.responsibilities;
                        this.formData.typeOfEmployment = response.data.employment_type_id;
                        this.formData.salaryFrom = response.data.min_salary;
                        this.formData.salaryBefore = response.data.max_salary;
                        this.formData.qualificationRequirements = response.data.qualification_requirements;
                        this.formData.experience = response.data.work_experience;
                        this.formData.education = response.data.education;
                        this.formData.workingConditions = response.data.working_conditions;
                        this.formData.vacancyVideo = response.data.video;
                        this.formData.officeAddress = response.data.address;
                        this.formData.houseNumber = response.data.home_number;
                    }, response => {
                    this.$swal(response.data.message);
                    }
                )
        },
        methods: {
            saveData() {
                let data = {
                    city: this.formData.city,
                    company_id: this.formData.companyName,
                    category: this.formData.categoriesVacancy,
                    post: this.formData.post,
                    responsibilities: this.formData.duties,
                    employment_type_id: this.formData.typeOfEmployment,
                    min_salary: this.formData.salaryFrom,
                    max_salary: this.formData.salaryBefore,
                    qualification_requirements: this.formData.qualificationRequirements,
                    work_experience: this.formData.experience,
                    education: this.formData.education,
                    working_conditions: this.formData.workingConditions,
                    video: this.formData.vacancyVideo,
                    address: this.formData.officeAddress,
                    home_number: this.formData.houseNumber,
                };

                this.$http.patch(`${process.env.VUE_APP_API_URL}/request/vacancy/` + this.$route.params.id, data)
                    .then(response => {
                            this.$router.push('/personal-area/all-vacancy')
                        }, response => {
                        this.$swal(response.data.message);
                        }
                    )
            },
            getFormData() {
                return FormVacancy;
            },
            async getCategory() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/category`)
            },
            async getEmploymentType() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/employment-type`)
            },
            async getCompanyName() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/company/my-index`)
            },
            async getExperience() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/get-experiences`)
            }
        },
    }
</script>

<style>

</style>