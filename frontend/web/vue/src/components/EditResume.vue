<template>
    <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" @val="valHandler">

		<div class="work-image-uploader">
			<v-btn @click="toggleShow">
				Выбрать фото
			</v-btn>
			<my-upload field="img"
					   @crop-success="cropSuccess"
					   v-model="show"
					   :width="200"
					   :height="200"
					   img-format="png"
					   lang-type="ru"
			>
			</my-upload>
			<img class="my-avatar" :src="formData.image_url">
		</div>
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
    import FormResume from '../lk-form/resume-form';
    import FormTemplate from "./FormTemplate";
    import Resume from "../mixins/resume";
	import myUpload from 'vue-image-crop-upload';

    export default {
        name: 'FormResume',
        mixins: [Resume],
        components: {FormTemplate, myUpload},
		created() {
			this.getEmploymentType();
			this.getCity();
		},
		mounted() {
            document.title = this.$route.meta.title;

            this.$http.get(`${process.env.VUE_APP_API_URL}/request/resume/` + this.$route.params.id + '?expand=experience,education,skills,category')
                .then(response => {
                        this.dataResume = response.data;

						if (response.data.phone != null) {
							this.formData.phone = response.data.phone;
						}
						if (this.formData.phone.length > 0 && response.data.phone != null) {
							this.formData.phoneValid = true;
						} else {
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

						this.formData.birth_date = response.data.birth_date;

                        this.formData.resumeCity = response.data.city_id;
                        if (response.data.image_url) {
                            this.formData.image_url = response.data.image_url;
                        }
                        this.formData.careerObjective = response.data.title;
                        this.formData.categoriesResume = response.data.category;
                        if (response.data.min_salary) {
                            this.formData.salaryFrom = response.data.min_salary;
                        }
                        if (response.data.max_salary) {
                            this.formData.salaryBefore = response.data.max_salary;
                        }
                        this.formData.aboutMe = response.data.description;
                        this.formData.addSocial.vkontakte = response.data.vk;
                        this.formData.addSocial.facebook = response.data.facebook;
                        this.formData.addSocial.instagram = response.data.instagram;
                        this.formData.addSocial.skype = response.data.skype;
                        if (response.data.education.length > 0) {
                            this.formData.educationBlock = response.data.education;
                        }
                        if (response.data.experience.length > 0) {
                            this.formData.workBlock = response.data.experience;
                        }
                        this.formData.dutiesSelect = response.data.skills;

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
                        if (response.data.status === 1) {
                        	this.formData.hideResume = false;
						} else {
							this.formData.hideResume = true;
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
        methods: {
			toggleShow() {
				this.show = !this.show;
			},
			cropSuccess(imgDataUrl, field){
				this.formData.image_url = imgDataUrl;
			},
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
					birth_date: this.formData.birth_date,
					city_id: this.formData.resumeCity,
                    image: this.formData.image_url,
                    title: this.formData.careerObjective,
                    category: this.formData.categoriesResume,
                    min_salary: this.formData.salaryFrom,
                    max_salary: this.formData.salaryBefore,
                    description: this.formData.aboutMe,
                    vk: this.formData.addSocial.vkontakte,
                    facebook: this.formData.addSocial.facebook,
                    instagram: this.formData.addSocial.instagram,
                    skype: this.formData.addSocial.skype,
                    education: this.formData.educationBlock,
                    work: this.formData.workBlock,
                    skills: this.formData.dutiesSelect,
					status: 1
                };
				if (this.formData.hideResume == true) {
					data.status = 2;
				}
                this.$http.patch(`${process.env.VUE_APP_API_URL}/request/resume/` + this.$route.params.id, data)
                    .then(response => {
                            this.$router.push('/personal-area/all-resume');
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
                return FormResume;
            },
            getEmploymentType() {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/category`).then(response => {
					FormResume.categoriesResume.items = response.data;
					for (let i = 0; i < response.data.length; i++) {
						this.$set(FormResume.categoriesResume.items, i, response.data[i]);
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
					FormResume.resumeCity.items = response.data.map(resumeCity => ({
						id: resumeCity.id,
						name: resumeCity.name,
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
            setImage: function (output) {
                this.hasImage = true;
                this.image = output;
                let img = document.querySelector('.my-avatar');
                if (img != null) {
                    img.classList.add('hide');
                }
            },
            valHandler(val) {
                this.valid = val;
            },
        },
        beforeRouteLeave(to, from, next) {
            if (this.dataResume.max_salary == null) {
                this.dataResume.max_salary = '';
            }
            if (this.dataResume.min_salary == null) {
                this.dataResume.min_salary = '';
            }
            const tmpResume = {
            	'phone': this.formData.phone,
                'city': this.dataResume.city_id,
                'title': this.dataResume.title,
                'category': this.dataResume.category,
                'min_salary': this.dataResume.min_salary,
                'max_salary': this.dataResume.max_salary,
                'description': this.dataResume.description,
                'vk': this.dataResume.vk,
                'facebook': this.dataResume.facebook,
                'instagram': this.dataResume.instagram,
                'skype': this.dataResume.skype,
                'skills': this.dataResume.skills,
            };
            const tmpFormData = {
            	'phone': this.formData.phone,
                'city': this.formData.resumeCity,
                'title': this.formData.careerObjective,
                'category': this.formData.categoriesResume,
                'min_salary': this.formData.salaryFrom,
                'max_salary': this.formData.salaryBefore,
                'description': this.formData.aboutMe,
                'vk': this.formData.addSocial.vkontakte,
                'facebook': this.formData.addSocial.facebook,
                'instagram': this.formData.addSocial.instagram,
                'skype': this.formData.addSocial.skype,
                'skills': this.formData.dutiesSelect,
            };
            let formValid = true;
            for (let i in tmpResume) {
                if (tmpResume[i] !== tmpFormData[i]) {
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