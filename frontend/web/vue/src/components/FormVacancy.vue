<template>
    <div>
        <template v-if="lengthCompany === 0">
            <v-subheader>У вас нет не одной компании</v-subheader>
        </template>
        <template v-else>
            <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData">
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
            this.getCategory().then(response => {
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
                this.lengthCompany = response.data.length;
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
                this.$http.post(`${process.env.VUE_APP_API_URL}/request/vacancy`, data)
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
            async getCategory() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/category`);
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

<style scoped>
</style>