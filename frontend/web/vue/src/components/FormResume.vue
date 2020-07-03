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
			this.getCategory();
			this.getUserData();
			this.getCity();
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
			getUserData() {
				this.$store.dispatch('getUserMe', this.$route.params.id)
						.then(data => {
							this.formData.birth_date = data.birth_date;
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
			},
            saveData() {
                let data = {
					phone: this.formData.phone,
					birth_date: this.formData.birth_date,
					city_id: this.formData.resumeCity,
                    image: this.formData.image_url,
                    title: this.formData.careerObjective,
                    category: this.formData.categoriesResume,
                    min_salary: this.formData.salaryFrom.replace(",", "."),
                    max_salary: this.formData.salaryBefore.replace(",", "."),
                    description: this.formData.aboutMe,
                    vk: this.formData.addSocial.vkontakte,
                    facebook: this.formData.addSocial.facebook,
                    instagram: this.formData.addSocial.instagram,
                    skype: this.formData.addSocial.skype,
                    education: this.formData.educationBlock,
                    work: this.formData.workBlock,
                    // skills: [],
                    skills: this.formData.dutiesSelect,
					status: 1
                };
                if (this.formData.hideResume == true) {
                	data.status = 2;
				}
                let res;
				this.$store.dispatch('addResume', data)
						.then(data => {
							gtag('event', 'rezumeAdd', {'event_category': 'form', 'event_action': 'rezumeAdd',});
							yaCounter53666866.reachGoal('rezumeAdd');
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
            getCategory() {
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
            },
            valHandler(val) {
                this.valid = val;
            },
        },

		computed: {
			...mapGetters([
				'userMe',
			])
		},
		watch: {
			menu (val) {
				val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
			}
		},

        beforeRouteLeave(to, from, next) {
            if ((this.formData.careerObjective.length > 0 || this.formData.categoriesResume.length > 0) && !this.valid) {
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
    .input-file {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    #fileInput {
        display: none;
    }

    .input-file label {
        margin-top: 20px;
        color: rgba(0, 0, 0, 0.54);
        cursor: pointer;
    }

    .showRemoveBtn {
        display: inline-flex !important;
    }

    .upload-caption {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .upload-caption svg {
        width: 20px;
        margin-left: 10px;
    }

    .my-avatar {
        width: 200px;
    }

    .hide {
        display: none;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    .work-block, .education-block {
        margin-top: 30px;
        padding: 10px;
        border: 1px solid rgba(0, 0, 0, 0.42);
    }

    .item-block {
        margin-bottom: 20px;
    }
</style>