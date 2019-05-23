<template>
    <template v-if="messages.length === 0">
        <v-subheader>У вас нет сообщений</v-subheader>
    </template>

    <template v-else>
        <v-list two-line class="message-block">
            <template v-for="(item, index) in messages">
                <v-list-tile
                        :key="item.id"
                        avatar
                        ripple
                        @click="toggle(index)"
                >
                    <v-list-tile-content>
                        <v-list-tile-title>{{ item.subject }}</v-list-tile-title>
                        <v-list-tile-sub-title class="text--primary">{{ item.receiver.employer.first_name }} {{
                            item.receiver.employer.second_name }} - {{ item.receiver.employer.email }}
                        </v-list-tile-sub-title>
                        <v-list-tile-sub-title>{{ item.text }}</v-list-tile-sub-title>
                    </v-list-tile-content>

                    <v-list-tile-action>
                        <v-list-tile-action-text>{{ item.created_at }}</v-list-tile-action-text>
                    </v-list-tile-action>

                </v-list-tile>
                <v-divider></v-divider>
            </template>
        </v-list>
    </template>

    <template v-if="paginationPageCount > 1">
        <div class="text-xs-center">
            <v-pagination
                    v-model="paginationCurrentPage"
                    :length="paginationPageCount"
                    @input="changePage"
            ></v-pagination>
        </div>
    </template>
</template>

<script>
    export default {
        name: "MyMessage",
        data() {
            return {
                messages: [],
                paginationPageCount: 1,
                paginationCurrentPage: 1,
            }
        },
        created() {
            document.title = this.$route.meta.title;
            this.$http.get(`${process.env.VUE_APP_API_URL}/request/message?expand=receiver.employer,subject0`)
                .then(response => {
                        this.messages = response.data;
                        this.messages.forEach((element) => {
                            if (element.subject === 'Resume') {
                                element.subject = 'Отклик на резюме ' + element.subject0.title;
                            }
                            if (element.subject === 'Vacancy') {
                                element.subject = 'Отклик на вакансию ' + element.subject0.title;
                            }
                            let timestamp = element.created_at;
                            let date = new Date();
                            date.setTime(timestamp * 1000);
                            element.created_at = date.getDate() + '.' + date.getMonth() + '.' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
                        });
                        this.paginationPageCount = response.headers.map['x-pagination-page-count'][0];
                    }, response => {
                    }
                );

        },
    }
</script>

<style>
    .message-block .v-list__tile--link {
        user-select: auto !important;
    }

    .message-block .v-list--two-line .v-list__tile:hover {
        background: none !important;
    }

    .message-block a {
        cursor: default !important;
    }

    .message-block .v-ripple__container {
        display: none !important;
    }
</style>