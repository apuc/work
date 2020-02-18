<template>
    <div>
        <v-select
                v-model="value['mainCategoriesVacancy']"
                name="mainCategoriesVacancy"
                :items="itemsMain"
                item-text="name"
                item-value="id"
                label="Основная категория*"
                :rules="[v => !!v  || 'Основная категория обязателена к заполнению']"
                @change="subcategoriesShow(value)"
        ></v-select>
        <transition name="fade">
            <div v-if="show">
                <v-select
                        v-model="value['subcategories']"
                        name="subcategories"
                        :items="itemsSub"
                        item-text="name"
                        item-value="id"
                        attach
                        chips
                        label="Подкатегории"
                        multiple
                        :rules="[v => v.length < 4  || 'Не больше трех категорий']"
                ></v-select>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: "Category",
        data() {
            return {
                show: false,
                itemsMain: [
                    {
                        name: '',
                        id: ''
                    }
                ],
                itemsSub: [
                    {
                        name: '',
                        id: ''
                    }
                ],
            }
        },
        props: {
            value: {
                type: [Object, Array, String],
            }
        },
        mounted() {
            this.getCategory().then(response => {
                this.itemsMain = response.data.map(vacancy => ({
                    id: vacancy.id,
                    name: vacancy.name,
                }));
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
            console.log(this.$route.name);
            if(this.$route.name == 'edit-vacancy/id') {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/vacancy/` + this.$route.params.id + '?expand=employment-type,category')
                    .then(response => {
                            let mainCategoryId = {
                                mainCategoriesVacancy: response.data.main_category_id,
                                subcategories: []
                            };
                        this.subcategoriesShow(mainCategoryId);
                        }, response => {
                            return response;
                        }
                    );
            }
        },
        methods: {
            getCategory() {
                return this.$http.get(`${process.env.VUE_APP_API_URL}/request/category`);
            },
            subcategoriesShow(data) {
                let subArray = [...this.itemsMain];
                let indexCategory = subArray.findIndex(item => item.id == data.mainCategoriesVacancy);
                subArray.splice(indexCategory, 1);
                this.itemsSub = subArray.map(category => ({
                    id: category.id,
                    name: category.name,
                }));
                this.show = true;
                if(data.subcategories.length > 0) {
                    data.subcategories = [];
                }
            }
        }
    }
</script>

<style scoped>

</style>