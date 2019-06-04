<template>
    <div class="main-block">
        <template v-for="(items, index) in allRecords">

            <template v-if="items === allRecords.Resume">
                <v-subheader class="main-head">Резюме</v-subheader>
                <v-subheader  v-if="allRecords.Resume.length === 0">У вас нет резюме</v-subheader>
            </template>

            <template v-else-if="items === allRecords.Vacancy">
                <v-subheader class="main-head">Вакансии</v-subheader>
                <v-subheader v-if="allRecords.Vacancy.length === 0">У вас нет вакансий</v-subheader>
            </template>

            <v-card
                    class="main-card"
                    :class="selecetBg(index)"
                    color="#26c6da"
                    dark
                    v-for="(item, itemIndex) in items"
                    :key="itemIndex"
            >
                <v-card-text class="headline font-weight-bold">
                    <template v-if="items === allRecords.Vacancy">
                        <a :href="domen + '/vacancy/view/' + item.id" target="_blank" class="statistics-link">
                        {{ item.name }}
                        </a>
                    </template>
                    <template v-else-if="items === allRecords.Resume">
                        <a :href="domen + '/resume/view/' + item.id" target="_blank" class="statistics-link">
                            {{ item.name }}
                        </a>
                    </template>
                </v-card-text>

                <v-card-actions>
                    <v-list-tile class="grow">
                        <v-layout
                                align-center
                                justify-end
                        >
                            <v-icon class="mr-1">remove_red_eye</v-icon>
                            <span class="subheading mr-2">{{ item.views }}</span>
                            <span class="mr-1">·</span>
                            <v-icon class="mr-1">message</v-icon>
                            <span class="subheading">{{ item.responses }}</span>
                        </v-layout>
                    </v-list-tile>
                </v-card-actions>
            </v-card>
        </template>

    </div>
</template>

<script>
    export default {
        name: "MainPage",
        data() {
            return {
                allRecords: [],
                domen: ''
            }
        },
        computed: {
        },
        mounted() {
            document.title = this.$route.meta.title;
            this.$http.get(`${process.env.VUE_APP_API_URL}/personal_area/default/statistics`)
                .then(response => {
                        this.allRecords = response.data;
                        this.domen = `${process.env.VUE_APP_API_URL}`;
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
                );

        },
        methods: {
            selecetBg(cardType) {
                const types = {
                    resume: 'main-card_resume',
                    company: 'main-card_company',
                    vacancy: 'main-card_vacancy'
                };

                const typeLowerCase = cardType.toLowerCase();

                return types[typeLowerCase];
            }
        }
    }
</script>

<style >
    .main-block {
        display: flex;
        flex-wrap: wrap;
    }
    .main-head {
        width: 100%;
        margin-bottom: 10px;
        padding: 0;
        font-size: 20px;
        font-weight: 700;
        border-bottom: 1px solid rgba(0,0,0,0.54);
    }
    .main-card {
        width: 23%;
        margin-right: 20px;
        margin-bottom: 20px;
    }
    .main-card_resume {
        background-color: #0000FF !important;
    }
    .main-card_vacancy {
        background-color: #FF0000 !important;
    }
    @media (max-width: 1400px) {
        .main-card {
            width: 30%;
        }
    }
    @media (max-width: 960px) {
        .main-card {
            width: 45%;
        }
    }
    @media (max-width: 600px) {
        .main-card {
            width: 100%;
            margin-right: 0;
        }
    }
    .statistics-link {
        color: inherit;
        text-decoration: none;
    }
</style>