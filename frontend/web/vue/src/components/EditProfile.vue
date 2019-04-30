<template>
	<FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData">
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
    mounted(){
      this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index`)
        .then(response => {
            console.log(response.data);
            this.formData.first_name = response.data[0].first_name;
            this.formData.second_name = response.data[0].second_name;
            this.formData.email = response.data[0].email;
            this.formData.phone = response.data[0].phone;

            this.idEmployer = response.data[0].id;

            console.log(this.idEmployer);

            console.log('Форма успешно получена');
          }, response => {
            console.log(response);
            console.log('Форма не получена');
          }
        )
    },
    methods: {
      saveData() {
        let data = {
          first_name: this.formData.first_name,
					second_name: this.formData.second_name,
					email: this.formData.email,
					phone: this.formData.phone
        };

        this.$http.patch(`${process.env.VUE_APP_API_URL}/request/employer/` + this.idEmployer, data)
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
        return FormProfile;
      }
    },
  }

</script>

<style scoped>

</style>