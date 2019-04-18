<template>
	<FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData">

		<image-uploader
			class="input-file"
			:preview="true"
			:className="['fileinput', { 'fileinput--loaded': hasImage }]"
			capture="environment"
			:debug="1"
			doNotResize="gif"
			:autoRotate="true"
			outputFormat="verbose"
			@input="setImage"
		>
			<label for="fileInput" slot="upload-label">
				<span class="upload-caption">Выбрать фото <img src="../assets/login.png"></span>
			</label>
		</image-uploader>

	</FormTemplate>
</template>

<script>
  import FormResume from '../lk-form/resume-form';
  import FormTemplate from "./FormTemplate";
  import Resume from "../mixins/resume";
  export default {
    name: 'FormResume',
    mixins: [Resume],
    components: {FormTemplate},
    created() {
      document.title = this.$route.meta.title;

      this.getEmploymentType()
        .then(response => {
          FormResume.categoriesResume.items = response.data;
          for (let i = 0; i < response.data.length; i++) {
            this.$set(FormResume.categoriesResume.items, i, response.data[i]);
          }
        })

      this.$http.get(`${process.env.VUE_APP_API_URL}/request/resume/` + this.$route.params.id + '?expand=experience,education,skill,category')
        .then(response => {
					console.log(response.data);
					this.formData.careerObjective = response.data.title;
          this.formData.categoriesResume = response.data.category;
					this.formData.salaryFrom = response.data.min_salary;
					this.formData.salaryBefore = response.data.max_salary;
					this.formData.aboutMe = response.data.description;
					this.formData.addSocial.vkontakte = response.data.vk;
					this.formData.addSocial.facebook = response.data.facebook;
					this.formData.addSocial.instagram = response.data.instagram;
					this.formData.addSocial.skype = response.data.skype;
					this.formData.educationBlock = response.data.education;
					this.formData.workBlock = response.data.experience;
					this.formData.skill = response.data.skill;

          if (response.data.vk.length > 0 || response.data.facebook.length > 0 || response.data.instagram.length > 0 || response.data.instagram.length > 0) {
            document.querySelector('.social-block button').click();
          }

          let workLength = response.data.experience.length - 1;
          for (let i = 0; i < workLength; i++) {
            document.querySelector('.btnWork').click();
          }

          let educationLength = response.data.education.length - 1;
          for (let i = 0; i < educationLength; i++) {
            document.querySelector('.btnEducation').click();
          }

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
          image_url: '',
          title: this.formData.careerObjective,
          min_salary: this.formData.salaryFrom,
          max_salary: this.formData.salaryBefore,
          description: this.formData.aboutMe,
          vk: this.formData.addSocial.vkontakte,
          facebook: this.formData.addSocial.facebook,
          instagram: this.formData.addSocial.instagram,
          skype: this.formData.addSocial.skype,
          education: this.formData.educationBlock,
          work: this.formData.workBlock,
          skills: [],
        };
        let image = document.querySelector('.fileinput');
        if(image.classList.contains('fileinput--loaded')) {
          data.image_url = this.image.name;
        }

        let dutiesVal = document.querySelectorAll('.duties input');
        for (let i = 0; i < dutiesVal.length; i++) {
          if (dutiesVal[i].value !== '') {
            data.skills.push({name: dutiesVal[i].value})
          }
        }
        this.$http.patch(`${process.env.VUE_APP_API_URL}/request/resume/` + this.$route.params.id, data)
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
        return FormResume;
      },
      async getEmploymentType() {
        return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/category`)
      },
      setImage: function(output) {
        this.hasImage = true;
        this.image = output;
      },
      // setValue(data) {
      //   console.log('setValue --->', data);
      //   this.formData.careerObjective = data.title;
      // }
    },
  }
</script>

<style>

</style>