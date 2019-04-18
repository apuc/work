<template>
  <div>
    <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData">
    </FormTemplate>
  </div>
</template>

<script>
  import FormVacancy from '../lk-form/vacancy-form';
  import FormTemplate from "./FormTemplate";

  export default {
    name: "FormVacancy",
    components: {FormTemplate},
    data() {
       return {
         formData: {}
       }
    },
    created() {
      document.title = this.$route.meta.title;
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
    },
    methods: {
      // ...mapActions(['getItems']),
      saveData() {
        let data = {
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
              console.log(response);
              console.log('Форма успешно отправлена');
            }, response => {
              console.log(response);
              console.log('Форма не отправлена');
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
      }
    },
  }
</script>

<style scoped>
</style>