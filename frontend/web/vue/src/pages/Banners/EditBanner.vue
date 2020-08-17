<template>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
    >
        <slot/>
        <v-text-field
            v-model="formData.description"
            name="description"
            label="Описание"
            :rules="[v => !!v || 'Описание обязателено к заполнению']"
        ></v-text-field>

        <div class="work-image-uploader">
            <v-btn type="button" @click="toggleShowImage">
                Выбрать фото картинки
            </v-btn>
            <my-upload field="img"
                       @crop-success="cropSuccessImage"
                       v-model="showImage"
                       :width="300"
                       :height="120"
                       img-format="png"
                       lang-type="ru"
                       :no-circle="true"
            >
            </my-upload>
            <!--      <img class="my-avatar" :src="formData.image">-->
        </div>

        <div class="work-image-uploader">
            <v-btn type="button" @click="toggleShowLogo">
                Выбрать фото логотипа
            </v-btn>
            <my-upload field="img"
                       @crop-success="cropSuccessLogo"
                       v-model="showLogo"
                       :width="300"
                       :height="120"
                       img-format="png"
                       lang-type="ru"
                       :no-circle="true"
            >
            </my-upload>
            <!--      <img class="my-avatar" :src="formData.logo">-->
        </div>

        <div v-for="(item, index) in formData.city_category"
             :key="index"
             class="banner-city-cat"
        >
            <v-autocomplete :items="cityArray"
                            v-model="formData.city_category[index].city_id"
                            name="city"
                            label="Город"
                            item-text="name"
                            item-value="id"
                            @change="getPrice"
                            :class="{ 'disabled-banner': is_active }"
                            :readonly="is_active"
                            :rules="[v => !!v || 'Город обязателен к заполнению']"
            ></v-autocomplete>
            <span>--></span>
            <v-autocomplete :items="categoryArray"
                            v-model="formData.city_category[index].category_id"
                            name="category"
                            label="Категория"
                            item-text="name"
                            item-value="id"
                            @change="getPrice"
                            :class="{ 'disabled-banner': is_active }"
                            :readonly="is_active"
                            :rules="[]"
            ></v-autocomplete>
            <v-btn type="button"
                   @click="removeCityCategory(index)"
                   v-if="formData.city_category.length > 1 && is_active === false">
                Удалить
            </v-btn>
        </div>
        <v-btn type="button"
               class="city-category"
               @click="addCityCategory()"
               v-if="formData.city_category.length < 10 && is_active === false"
        >
            Добавить связь
        </v-btn>

        <div class="banner-advertising">
            <img :src="formData.image" alt="">
            <div class="banner-advertising__right">
                <h3>{{ formData.description }}</h3>
                <div class="banner-advertising__right-bottom">
                    <img :src="formData.logo" alt="">
                    <a href="/secure/company/default/view" class="btn-card btn-red">
                        Посмотреть полностью
                    </a>
                </div>
            </div>
        </div>

        <div class="banner-city-cat">
            <v-btn
                :disabled="!valid"
                color="success"
                id="main-btn-pass"
                @click="validate"
                type="button"
            >
                Сохранить
            </v-btn>

            <template>
                <v-btn type="button"
                       @click="activateBanner()"
                       :disabled="cityCategoryFlag"
                       v-if="is_active === false"
                >
                    $ Активировать на месяц ({{ price }} ₽)
                </v-btn>
                <v-subheader class="widthMC" v-if="is_active === true">Активен до: {{ active_until }}</v-subheader>
                <v-btn type="button"
                       @click="activateBanner()"
                       v-if="is_active === true"
                >
                    $ Продлить на месяц ({{ price }} ₽)
                </v-btn>
            </template>
        </div>

    </v-form>
</template>

<script>
import myUpload from 'vue-image-crop-upload';

export default {
    name: "EditBanner",
    data: () => ({
        formData: {
            id: '',
            description: '',
            image: '',
            logo: '',
            city_category: [
                {
                    city_id: '',
                    category_id: ''
                }
            ]
        },
        is_active: '',
        price: 0,
        showImage: false,
        showLogo: false,
        valid: false,
        active_until: '',
        cityCategoryFlag: false,
        cityArray: [],
        categoryArray: [],
    }),
    created() {
        this.$store.dispatch('getCity', this.$route.params.id)
            .then(data => {
                this.cityArray = data.map(city => ({
                    id: city.id,
                    name: city.name,
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
        this.$store.dispatch('getCategory', this.$route.params.id)
            .then(data => {
                this.categoryArray = data.map(category => ({
                    id: category.id,
                    name: category.name,
                }));
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
        this.getBanner();
    },
    methods: {
        getPrice() {
            let data = JSON.stringify(this.formData.city_category);
            this.cityCategoryFlag = true;
            this.$store.dispatch('getBannerPrice', data)
                .then(data => {
                    this.price = data;
                }).catch(error => {
                this.$swal({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    type: 'error',
                    title: error
                })
            });
        },
        activateBanner() {
            this.$store.dispatch('editBanner', this.formData)
                .then(data => {
                    this.$store.dispatch('activateBanner', this.formData.id)
                        .then(data => {
                            this.getBanner();
                            return data;
                        }).catch(error => {
                            this.$swal({
                                title: error,
                                confirmButtonText: 'Пополнить',
                            }).then((result) => {
                                if (result.value) {
                                    this.$router.push('/personal-area/payment');
                                }
                            });
                    });
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
        removeCityCategory(index) {
            this.formData.city_category.splice(index, 1);
            this.getPrice();
        },
        addCityCategory() {
            let newCityCategoryObject = {
                city_id: '',
                category_id: ''
            };
            this.formData.city_category.push(newCityCategoryObject);
        },
        getBanner() {
            this.$store.dispatch('getBanner', this.$route.params.id)
                .then(data => {
                    this.formData.id = data.id;
                    this.formData.description = data.description;
                    this.formData.image = `${process.env.VUE_APP_API_URL}` + data.image_url;
                    this.formData.logo = `${process.env.VUE_APP_API_URL}` + data.logo_url;
                    if (data.city_category.length > 0) {
                        this.formData.city_category = data.city_category.map(city_category => ({
                            city_id: city_category.city_id,
                            category_id: city_category.category_id,
                        }));
                    }
                    this.is_active = data.is_active;
                    this.cityCategoryLength = data.city_category.length;
                    let timestamp = data.active_until;
                    let date = new Date();
                    date.setTime(timestamp * 1000);
                    let options = {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                    };
                    this.active_until = date.toLocaleString("ru", options);
                    this.getPrice();
                    this.cityCategoryFlag = false;
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
        toggleShowImage() {
            this.showImage = !this.showImage;
        },
        toggleShowLogo() {
            this.showLogo = !this.showLogo;
        },
        cropSuccessImage(imgDataUrl, field) {
            this.formData.image = imgDataUrl;
        },
        cropSuccessLogo(imgDataUrl, field) {
            this.formData.logo = imgDataUrl;
        },
        saveBanner() {
            this.$store.dispatch('editBanner', this.formData)
                .then(data => {
                    this.$router.push('/personal-area/banners');
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
        validate() {
            let btn = document.getElementById('main-btn-pass');
            btn.disabled = true;
            let valid = this.$refs.form.validate();
            this.$emit('val', valid);
            if (valid) {
                this.snackbar = true;
                btn.disabled = false;
                this.saveBanner();
            }
        },
    },
    components: {myUpload},
}
</script>

<style scoped>
.banner-advertising {
    display: flex;
    align-items: center;
    width: 650px;
    margin: 15px 10px;
    padding: 30px 51px 13px 25px;
    border-radius: 10px;
    background-color: #ddf0fb;
    box-sizing: inherit;
}

.banner-advertising > img {
    margin-right: 30px;
    max-width: 148px;
}

.banner-advertising__right {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.banner-advertising__right h3 {
    margin: 0 0 5px;
    color: #0f0000;
    font-size: 20px;
    font-weight: 700;
    font-family: "Muller", sans-serif;
}

.banner-advertising__right-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.banner-advertising__right-bottom > img {
    width: 140px;
    height: auto;
    margin-top: 15px;
}

.banner-advertising__right-bottom .btn-card {
    margin-top: 15px;
    border: none;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 700;
}

.btn-card {
    display: inline-block;
    padding: 7px 15px 5px;
    font-weight: 500;
    font-size: 11px;
    color: #fff;
    text-decoration: none;
    letter-spacing: .43px;
    background-color: transparent;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    -webkit-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.btn-red {
    color: #fff;
    background-color: #dd3d34;
}

.banner-city-cat {
    display: flex;
    align-items: center;
}

.banner-city-cat > span {
    margin-right: 30px;
}

.banner-city-cat > div {
    width: 25%;
    flex: 0 1 auto;
    margin-right: 30px;
}
</style>
