<template>
    <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" @val="valHandler">

		<div class="work-image-uploader">
			<v-btn @click="toggleShow">
				Выбрать фото
			</v-btn>
			<my-upload field="img"
					   @crop-success="cropSuccess"
					   v-model="show"
					   :width="100"
					   :height="100"
					   img-format="png"
					   lang-type="ru"
			>
			</my-upload>
			<img class="my-avatar" :src="formData.image_url">
		</div>

		<template slot="bottom">
			<vue-tel-input :placeholder="'Номер телефона'"
						   :defaultCountry="defaultCountry.iso2"
						   v-model="formData.companyPhone"
						   :allCountries="allCountries"
						   :validCharactersOnly="true"
						   :required="true"
						   :inputOptions="{ showDialCode: true, tabindex: 0 }"
						   @country-changed="changeCountry"
						   @input="onInput"
			></vue-tel-input>
			<p class="custom-error">{{ phone.text }}</p>
		</template>

    </FormTemplate>
</template>

<script>
    import FormCompany from '../lk-form/company-form';
    import FormTemplate from "./FormTemplate";
    import Company from "../mixins/company";
	import myUpload from 'vue-image-crop-upload';

    export default {
        name: 'FormResume',
        mixins: [Company],
        components: {FormTemplate, myUpload},
        mounted() {
            document.title = this.$route.meta.title;
			this.$store.dispatch('getCompany', this.$route.params.id)
					.then(data => {
						this.dataCompany = data;
						if (data.image_url) {
							this.formData.image_url = data.image_url;
						}
						this.formData.nameCompany = data.name;
						this.formData.site = data.website;
						this.formData.scopeOfTheCompany = data.activity_field;
						this.formData.addSocial.vkontakte = data.vk;
						this.formData.addSocial.facebook = data.facebook;
						this.formData.addSocial.instagram = data.instagram;
						this.formData.addSocial.skype = data.skype;
						this.formData.aboutCompany = data.description;
						this.formData.contactPerson = data.contact_person;
						if(data.phone === null) {
							this.formData.companyPhone = '';
						} else {
							this.formData.companyPhone = data.phone.number;
							this.formData.phoneValid = true;
						}
						if (data.vk.length > 0 || data.facebook.length > 0 || data.instagram.length > 0 || data.instagram.length > 0) {
							document.querySelector('.social-block button').click();
						}
						Object.assign(FormCompany.nameCompany.rules, [v => !!v || 'Название компании обязательно к заполнению']);
						Object.assign(FormCompany.scopeOfTheCompany.rules, [v => !!v || 'Сфера деятельности компании обязателена к заполнению']);
						this.inputsDisabled();
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
					if (this.formData.companyPhone.length === 16) {
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
					if (this.formData.companyPhone.length === 16) {
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
                    image: this.formData.image_url,
                    name: this.formData.nameCompany,
                    website: this.formData.site,
                    activity_field: this.formData.scopeOfTheCompany,
                    vk: this.formData.addSocial.vkontakte,
                    facebook: this.formData.addSocial.facebook,
                    instagram: this.formData.addSocial.instagram,
                    skype: this.formData.addSocial.skype,
                    description: this.formData.aboutCompany,
                    contact_person: this.formData.contactPerson,
                    phone: this.formData.companyPhone,
                };
				let dataObj = {
					id: this.$route.params.id,
					data: data
				}
				this.$store.dispatch('editCompany', dataObj)
						.then(data => {
							this.$router.push('/personal-area/all-company');
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
                return FormCompany;
            },
            setImage: function (output) {
                this.hasImage = true;
                this.image = output;
                let img = document.querySelector('.my-avatar');
                if (img != null) {
                    img.classList.add('hide');
                }
            },
            inputsDisabled() {
                let check = document.querySelector('.privatePerson .v-input__slot');
                let inputCheck = check.querySelector('input');
                let allInputs = document.querySelectorAll('.jsCompanyInput');
                let nameCompany = document.getElementById('nameCompany');
                let site = document.getElementById('site');
                let scopeOfTheCompany = document.getElementById('scopeOfTheCompany');
                let aboutCompany = document.getElementById('aboutCompany');

                check.addEventListener('click', () => {

                    let attrCheck = inputCheck.getAttribute('aria-checked');
                    if (attrCheck == 'true') {
                        this.formData.nameCompany = '';
                        this.formData.site = '';
                        this.formData.scopeOfTheCompany = '';
                        this.formData.aboutCompany = '';

                        for (let i = 0; i < allInputs.length; i++) {
                            allInputs[i].classList.add('opacity');
                        }
                        nameCompany.disabled = true;
                        site.disabled = true;
                        scopeOfTheCompany.disabled = true;
                        aboutCompany.disabled = true;
                        FormCompany.nameCompany.rules = [];
                        FormCompany.scopeOfTheCompany.rules = [];
                        let elem = document.getElementById('main-btn');
                        elem.disabled = false;
                        elem.classList.remove('v-btn--disabled');
                        elem.classList.remove('success--text');
                        elem.classList.add('success');
                    } else {
                        for (let i = 0; i < allInputs.length; i++) {
                            allInputs[i].classList.remove('opacity');
                        }
                        nameCompany.disabled = false;
                        site.disabled = false;
                        scopeOfTheCompany.disabled = false;
                        aboutCompany.disabled = false;
                        Object.assign(FormCompany.nameCompany.rules, [v => !!v || 'Название компании обязательно к заполнению']);
                        Object.assign(FormCompany.scopeOfTheCompany.rules, [v => !!v || 'Сфера деятельности компании обязателена к заполнению']);
                        let elem = document.getElementById('main-btn');
                        elem.disabled = false;
                        elem.classList.remove('v-btn--disabled');
                        elem.classList.remove('success--text');
                        elem.classList.add('success');
                    }
                });
                if (!this.formData.nameCompany.length) {
                    let inputSlot = document.querySelector('.v-input--selection-controls__ripple');
                    inputSlot.click();
                    setTimeout(function () {
                        check.click();
                    }, 1);
                }
            },
			valHandler(val) {
				this.valid = val;
			},
        },
        beforeRouteLeave(to, from, next) {
			const tmpResume = {
				'name': this.dataCompany.name,
				'website': this.dataCompany.website,
				'activity_field': this.dataCompany.activity_field,
				'vk': this.dataCompany.vk,
				'facebook': this.dataCompany.facebook,
				'instagram': this.dataCompany.instagram,
				'skype': this.dataCompany.skype,
				'description': this.dataCompany.description,
				'contact_person': this.dataCompany.contact_person,
				'number': this.dataCompany.phone.number
			};
			const tmpFormData = {
				'name': this.formData.nameCompany,
				'website': this.formData.site,
				'activity_field': this.formData.scopeOfTheCompany,
				'vk': this.formData.addSocial.vkontakte,
				'facebook': this.formData.addSocial.facebook,
				'instagram': this.formData.addSocial.instagram,
				'skype': this.formData.addSocial.skype,
				'description': this.formData.aboutCompany,
				'contact_person': this.formData.contactPerson,
				'number': this.formData.companyPhone
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
