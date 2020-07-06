<template>
    <div>
        <v-subheader class="all-head">
            Обновления
        </v-subheader>
        <v-card flat>
            <v-card-text>
                <v-list two-line class="message-block">
                    <template v-for="(item, index) in updates">
                        <v-list-tile
                                :key="index"
                                avatar
                                ripple
                                class="message-item"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{ item.head }}</v-list-tile-title>
                                <v-list-tile-sub-title class="message__text">{{ item.text }}</v-list-tile-sub-title>
                            </v-list-tile-content>
                            <v-list-tile-action>
                                <v-list-tile-action-text class="message__data">{{ item.time }}</v-list-tile-action-text>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-divider class="message__hr"></v-divider>
                    </template>
                </v-list>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    export default {
        name: "Updates",
        data() {
            return {
                updates: [
                    {
                        head: 'Вакансии',
                        text: 'С сегодняшнего дня можно добавить только 3 вакансии. Для того что бы добавить 4-ю вакансию нужно будет ее купить, как и 5-ю. Больше 5 нельзя.',
                        time: '17.06.2020'
                    },
                    {
                        head: 'Компании',
                        text: 'На аккаунте может быть только одна компания. Если у Вас их больше одной, то до 1.07.2020 вы можете перенести ее на другой аккаунт.' +
                            'На аккаунте может быть только одна компания. Если у Вас их больше одной, то до 1.07.2020 вы можете перенести ее на другой аккаунт.',
                        time: '11.06.2020'
                    },
                ]
            }
        },
    }
</script>

<style scoped>
    .all-head {
        margin-top: 10px;
        margin-bottom: 15px;
        padding: 0;
        font-size: 22px;
        color: rgba(0, 0, 0, .74);
    }
</style>