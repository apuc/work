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
		<v-menu
				ref="menu"
				v-model="menu"
				:close-on-content-click="false"
				:nudge-right="40"
				lazy
				transition="scale-transition"
				offset-y
				full-width
				min-width="290px"
		>
			<template v-slot:activator="{ on }">
				<v-text-field
						v-model="formData.birth_date"
						label="Дата рождения"
						class="date-label"
						prepend-icon="event"
						readonly
						v-on="on"
				></v-text-field>
			</template>
			<v-date-picker
					ref="picker"
					v-model="formData.birth_date"
					:max="new Date().toISOString().substr(0, 10)"
					min="1950-01-01"
					locale="ru-ru"
			></v-date-picker>
		</v-menu>

    </FormTemplate>
</template>

<script>
    import FormResume from '../lk-form/resume-form';
    import FormTemplate from "./FormTemplate";
    import Resume from "../mixins/resume";
	import myUpload from 'vue-image-crop-upload';
	import {mapGetters} from 'vuex';

    export default {
        name: 'FormResume',
        mixins: [Resume],
        components: {FormTemplate, myUpload},
		mounted() {
            document.title = this.$route.meta.title;
			this.getEmploymentType();
			this.getCity();
			this.$store.dispatch('getResume', this.$route.params.id)
					.then(data => {
						this.dataResume = data;
						if (data.phone != null) {
							this.formData.phone = data.phone;
						} else {
							this.$store.dispatch('getUserMe', this.$route.params.id)
									.then(data => {
										if (data.phone != null) {
											this.formData.phone = data.phone.number;
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
						}
						if (this.formData.phone.length > 0) {
							this.formData.phoneValid = true;
						}
						this.formData.birth_date = data.birth_date;

						this.formData.resumeCity = data.city_id;
						if (data.image_url) {
							this.formData.image_url = data.image_url;
						}
						this.formData.careerObjective = data.title;
						this.formData.categoriesResume = data.category;
						if (data.min_salary) {
							this.formData.salaryFrom = data.min_salary;
						}
						if (data.max_salary) {
							this.formData.salaryBefore = data.max_salary;
						}
						this.formData.aboutMe = data.description;
						this.formData.addSocial.vkontakte = data.vk;
						this.formData.addSocial.facebook = data.facebook;
						this.formData.addSocial.instagram = data.instagram;
						this.formData.addSocial.skype = data.skype;
						if (data.education.length > 0) {
							this.formData.educationBlock = data.education;
						}
						if (data.experience.length > 0) {
							this.formData.workBlock = data.experience;
						}
						this.formData.dutiesSelect = data.skills;

						if (data.vk.length > 0 || data.facebook.length > 0 || data.instagram.length > 0 || data.instagram.length > 0) {
							document.querySelector('.social-block button').click();
						}

						let workLength = data.experience.length - 1;
						for (let i = 0; i < workLength; i++) {
							document.querySelector('.btnWork').click();
						}

						let educationLength = data.education.length - 1;
						for (let i = 0; i < educationLength; i++) {
							document.querySelector('.btnEducation').click();
						}
						if (data.status === 1) {
							this.formData.hideResume = false;
						} else {
							this.formData.hideResume = true;
						}
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
                	id: this.$route.params.id,
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
				this.$store.dispatch('editResume', data)
						.then(data => {
							this.$router.push('/personal-area/all-resume');
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
                return FormResume;
            },
            getEmploymentType() {
				this.$store.dispatch('getCategory', this.$route.params.id)
						.then(data => {
							FormResume.categoriesResume.items = data.map(resume => ({
								id: resume.id,
								name: resume.name,
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
            getCity() {
				this.$store.dispatch('getCity', this.$route.params.id)
						.then(data => {
							FormResume.resumeCity.items = data.map(resumeCity => ({
								id: resumeCity.id,
								name: resumeCity.name,
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

		computed: {
			...mapGetters([
				'resume',
			])
		},
		watch: {
			menu (val) {
				val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
			}
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