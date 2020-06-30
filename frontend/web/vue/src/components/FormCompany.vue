<template>
    <div v-if="companiesCount < 1">
        <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveCheck" @val="valHandler">

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
    </div>
</template>

<script>
    import FormCompany from '../lk-form/company-form';
    import FormTemplate from "./FormTemplate";
    import Company from "../mixins/company";
	import myUpload from 'vue-image-crop-upload';

    export default {
        name: "FormCompany",
        components: {FormTemplate, myUpload},
        mixins: [Company],
        created() {
            document.title = this.$route.meta.title;
        },
        mounted() {
            Object.assign(FormCompany.nameCompany.rules, [v => !!v || 'Название компании обязательно к заполнению']);
            Object.assign(FormCompany.scopeOfTheCompany.rules, [v => !!v || 'Сфера деятельности компании обязателена к заполнению']);
            this.inputsDisabled();
            this.getUserData();
            this.companiesCount = localStorage.companiesCount;
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
            saveCheck() {
                if (this.image === null) {
                    this.$swal({
                        title: 'Вы уверены что хотите сохранить (компанию/частное лицо) без логотипа? ' +
                            'Логотип увеличит количество просмотров вакансии и поможет найти сотрудниковы быстрее! ' +
                            'А так же, повысит узнаваемость компании.',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Продолжить без лого',
                        cancelButtonText: 'Добавить лого'
                    }).then((result) => {
                        if (result.value) {
                        	this.saveData();
                        } else {
                            let btn = document.getElementById('main-btn');
                            btn.disabled = false;
                        }
                    });
                } else {
					this.saveData();
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
                let res;
                this.$http.post(`${process.env.VUE_APP_API_URL}/request/company`, data)
                    .then(response => {
                            this.$router.push('/personal-area/all-company');
                            res = response;
                            gtag('event', 'companyAdd', {
                                'event_category': 'form',
                                'event_action': 'companyAdd',
                            });
                            yaCounter53666866.reachGoal('companyAdd');
                            return true;
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
            getUserData() {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index?expand=phone,user`)
                    .then(response => {
                            this.formData.contactPerson = response.data[0].first_name + ' ' + response.data[0].second_name;
                            if (response.data[0].phone != null) {
                                this.formData.companyPhone = response.data[0].phone.number;
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
                return FormCompany;
            },
            setImage: function (output) {
                this.hasImage = true;
                this.image = output;
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
                        this.$forceUpdate();
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
            },
            valHandler(val) {
                this.valid = val;
            },
        },
        beforeRouteLeave(to, from, next) {
            if ((this.formData.nameCompany.length > 0 || this.formData.scopeOfTheCompany.length > 0) && !this.valid) {
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
    .opacity {
        opacity: 0.5;
    }
</style>