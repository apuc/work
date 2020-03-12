<template>
    <div>

        <v-tabs
                centered
                light
                icons-and-text
        >
            <v-tabs-slider color="black"></v-tabs-slider>

            <v-tab href="#tab-1" @click="getIncoming()">
                Входящие
            </v-tab>

            <v-tab href="#tab-2" @click="getOutgoing()">
                Исходящие
            </v-tab>

            <v-tab-item
                    value="tab-1"
            >
                <v-card flat>
                    <v-card-text>
                        <v-subheader v-if="messagesIncoming.length === 0">У вас нет сообщений</v-subheader>
                        <v-list v-else two-line class="message-block">
                            <template v-for="(incoming, index) in messagesIncoming">
                                <v-list-tile
                                        :key="incoming.id"
                                        avatar
                                        ripple
                                        class="message-item"
                                        :class="{'system-message':incoming.sender == 'Системное сообщение', 'unread-messages':incoming.is_read == 0}"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title v-if="incoming.subject !== null" v-html="incoming.subject"></v-list-tile-title>
                                        <v-list-tile-title v-if="incoming.subject_from !== null" v-html="incoming.subject_from"></v-list-tile-title>
                                        <v-list-tile-sub-title v-if="incoming.sender == 'Системное сообщение'"
                                                               :class="{'system-message__head':incoming.sender == 'Системное сообщение'}">
                                            {{ incoming.sender }}
                                        </v-list-tile-sub-title>
                                        <v-list-tile-sub-title class="text--primary" v-else>{{ incoming.sender.employer.first_name }} {{
                                            incoming.sender.employer.second_name }} - {{ incoming.sender.email }}
                                        </v-list-tile-sub-title>
                                        <v-list-tile-sub-title class="message__text">{{ incoming.text }}</v-list-tile-sub-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-list-tile-action-text class="message__data">{{ incoming.created_at }}</v-list-tile-action-text>
                                    </v-list-tile-action>

                                    <v-btn outline small fab
                                           class="remove-message"
                                           type="button"
                                           @click="removeMessage(index, incoming.id, 'incoming')"
                                    >
                                        <v-icon>clear</v-icon>
                                    </v-btn>

                                </v-list-tile>
                                <v-divider class="message__hr"></v-divider>
                            </template>
                        </v-list>
                    </v-card-text>
                    <div  class="text-xs-center">
                        <v-pagination
                                v-if="paginationPageCountIncoming > 1"
                                v-model="paginationCurrentPageIncoming"
                                :length="paginationPageCountIncoming"
                                @input="changePageIncoming"
                        ></v-pagination>
                    </div>
                </v-card>
            </v-tab-item>

            <v-tab-item
                    value="tab-2"
            >
                <v-card flat>
                    <v-card-text>
                        <v-subheader v-if="messagesOutgoing.length === 0">У вас нет сообщений</v-subheader>
                        <v-list v-else two-line class="message-block">
                            <template v-for="(outgoing, index) in messagesOutgoing">
                                <v-list-tile
                                        :key="outgoing.id"
                                        avatar
                                        ripple
                                        class="message-item"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title v-html="outgoing.subject"></v-list-tile-title>
                                        <v-list-tile-title v-html="outgoing.subject_from"></v-list-tile-title>
                                        <v-list-tile-sub-title class="text--primary">{{ outgoing.receiver.employer.first_name }} {{
                                            outgoing.receiver.employer.second_name }} - {{ outgoing.receiver.email }}
                                        </v-list-tile-sub-title>
                                        <v-list-tile-sub-title class="message__text">{{ outgoing.text }}</v-list-tile-sub-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-list-tile-action-text class="message__data">{{ outgoing.created_at }}</v-list-tile-action-text>
                                    </v-list-tile-action>

                                    <v-btn outline small fab
                                           class="remove-message"
                                           type="button"
                                           @click="removeMessage(index, outgoing.id, 'outgoing')"
                                    >
                                        <v-icon>clear</v-icon>
                                    </v-btn>

                                </v-list-tile>
                                <v-divider class="message__hr"></v-divider>
                            </template>
                        </v-list>
                    </v-card-text>
                    <div  class="text-xs-center">
                        <v-pagination
                                v-if="paginationPageCountOutgoing > 1"
                                v-model="paginationCurrentPageOutgoing"
                                :length="paginationPageCountOutgoing"
                                @input="changePageOutgoing"
                        ></v-pagination>
                    </div>
                </v-card>
            </v-tab-item>
        </v-tabs>

    </div>
</template>

<script>
    export default {
        name: "MyMessage",
        data() {
            return {
                messagesIncoming: [],
                messagesOutgoing: [],
                paginationPageCountIncoming: 1,
                paginationPageCountOutgoing: 1,
                paginationCurrentPageIncoming: 1,
                paginationCurrentPageOutgoing: 1
            }
        },
        mounted() {
            document.title = this.$route.meta.title;
            this.getIncoming();
            this.$http.post(`${process.env.VUE_APP_API_URL}/request/message/read-all-messages`)
                .then(response => {
                    this.$forceUpdate();
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
                );
        },
        methods: {
            removeMessage(index, messageId, type) {
                let data = {
                    type: '',
                    id: messageId
                };
                if(type == 'incoming') {
                    this.messagesIncoming.splice(index, 1);
                    data.type = type;
                }
                if(type == 'outgoing') {
                    this.messagesOutgoing.splice(index, 1);
                    data.type = type;
                }
                this.$http.post(`${process.env.VUE_APP_API_URL}/request/message/delete-message`, data)
                    .then(response => {
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
                    );
            },
            getIncoming() {
                this.messagesIncoming = [];
                this.paginationPageCountIncoming = 1;
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/message?expand=subject0,sender.employer,subject0_from&type=incoming`,)
                    .then(response => {
                            this.messagesIncoming = response.data;
                            let domen = `${process.env.VUE_APP_API_URL}`;
                            this.messagesIncoming.forEach((element) => {
                                if(element.subject_id === null) {
                                    element.sender = 'Системное сообщение'
                                }
                                if (element.subject === 'Resume') {
                                    element.subject = 'Отклик на резюме ' + '<a href="'+domen+'/resume/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.title + '</a>';
                                    element.subject_from = 'Предлагают вакансию ' + '<span>' + element.subject0_from.post + ' ' + '</span>' + '<a href="'+domen+'/vacancy/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                                }
                                if (element.subject === 'Vacancy') {
                                    element.subject = 'Отклик на вакансию ' + '<a href="'+domen+'/vacancy/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.post + '</a>';
                                    element.subject_from = 'Прилагают резюме ' + '<span>' + element.subject0_from.title + ' ' + '</span>' + '<a href="'+domen+'/resume/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                                }
                                let timestamp = element.created_at;
                                let date = new Date();
                                date.setTime(timestamp * 1000);

                                let options = {
                                    year: 'numeric',
                                    month: 'numeric',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric',
                                };
                                element.created_at = date.toLocaleString("ru", options);
                            });
                            this.paginationPageCountIncoming = response.headers.map['x-pagination-page-count'][0];
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
            getOutgoing() {
                this.messagesOutgoing = [];
                this.paginationPageCountOutgoing = 1;
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/message?expand=subject0,receiver.employer,subject0_from&type=outgoing`,)
                    .then(response => {
                            this.messagesOutgoing = response.data;
                            let domen = `${process.env.VUE_APP_API_URL}`;
                            this.messagesOutgoing.forEach((element) => {
                                if (element.subject === 'Resume') {
                                    element.subject = 'Отклик на резюме ' + '<a href="'+domen+'/resume/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.title + '</a>';
                                    element.subject_from = 'Предлагают вакансию ' + '<span>' + element.subject0_from.post + ' ' + '</span>' + '<a href="'+domen+'/vacancy/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                                }
                                if (element.subject === 'Vacancy') {
                                    element.subject = 'Отклик на вакансию ' + '<a href="'+domen+'/vacancy/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.post + '</a>';
                                    element.subject_from = 'Прилагают резюме ' + '<span>' + element.subject0_from.title + ' ' + '</span>' + '<a href="'+domen+'/resume/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                                }
                                let timestamp = element.created_at;
                                let date = new Date();
                                date.setTime(timestamp * 1000);
                                let options = {
                                    year: 'numeric',
                                    month: 'numeric',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric',
                                };
                                element.created_at = date.toLocaleString("ru", options);                            });
                            this.paginationPageCount = response.headers.map['x-pagination-page-count'][0];
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
            changePageIncoming(paginationCurrentPageIncoming) {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/message?expand=subject0,sender.employer&type=incoming?page=` + paginationCurrentPageIncoming)
                    .then(response => {
                        this.messagesIncoming = response.data;
                        let domen = `${process.env.VUE_APP_API_URL}`;
                        this.messagesIncoming.forEach((element) => {
                            if (element.subject === 'Resume') {
                                element.subject = 'Отклик на резюме ' + '<a href="'+domen+'/resume/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.title + '</a>';
                                element.subject_from = 'Предлагают вакансию ' + '<span>' + element.subject0_from.post + ' ' + '</span>' + '<a href="'+domen+'/vacancy/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                            }
                            if (element.subject === 'Vacancy') {
                                element.subject = 'Отклик на вакансию ' + '<a href="'+domen+'/vacancy/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.post + '</a>';
                                element.subject_from = 'Прилагают резюме ' + '<span>' + element.subject0_from.title + ' ' + '</span>' + '<a href="'+domen+'/resume/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                            }
                            let timestamp = element.created_at;
                            let date = new Date();
                            date.setTime(timestamp * 1000);
                            element.created_at = date.getDate() + '.' + (date.getMonth() + 1 )  + '.' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
                        });
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
            changePageOutgoing(paginationCurrentPageOutgoing) {
                this.$http.get(`${process.env.VUE_APP_API_URL}/request/message?expand=subject0,receiver.employer&type=outgoing?page=` + paginationCurrentPageOutgoing)
                    .then(response => {
                        this.messagesOutgoing = response.data;
                        let domen = `${process.env.VUE_APP_API_URL}`;
                        this.messagesOutgoing.forEach((element) => {
                            if (element.subject === 'Resume') {
                                element.subject = 'Отклик на резюме ' + '<a href="'+domen+'/resume/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.title + '</a>';
                                element.subject_from = 'Предлагают вакансию ' + '<span>' + element.subject0_from.post + ' ' + '</span>' + '<a href="'+domen+'/vacancy/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                            }
                            if (element.subject === 'Vacancy') {
                                element.subject = 'Отклик на вакансию ' + '<a href="'+domen+'/vacancy/view/'+element.subject_id+'" class="message-link" target="_blank">' + element.subject0.post + '</a>';
                                element.subject_from = 'Прилагают резюме ' + '<span>' + element.subject0_from.title + ' ' + '</span>' + '<a href="'+domen+'/resume/view/'+element.subject_from_id+'" class="message-button" target="_blank">Посмотреть</a>';
                            }
                            let timestamp = element.created_at;
                            let date = new Date();
                            date.setTime(timestamp * 1000);
                            element.created_at = date.getDate() + '.' + (date.getMonth() + 1 )  + '.' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
                        });
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
            }
        }
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
        color: inherit;
        cursor: pointer !important;
    }

    .message-block .v-ripple__container {
        display: none !important;
    }
    .message-block.v-list--two-line .v-list__tile {
        height: auto;
    }
    .message__hr {
        margin: 10px 0;
    }
    .message__text {
        white-space: initial;
        overflow: auto;
    }
    .message-block .v-list__tile__action {
        min-width: 100px;
    }
    .message-block .message-item {
        padding: 10px 0;
    }
    .system-message .system-message__head {
        color: #b50100 !important;
    }
    .unread-messages {
        background-color: #dddddd;
    }
    .remove-message {
        position: absolute;
        top: -5px;
        right: 5px;
        width: 20px !important;
        height: 20px !important;
        margin: 0 !important;
        border: none !important;
    }
    .remove-message:active, .remove-message:focus, .remove-message:hover {
        position: absolute !important;
    }
    .message-block .v-list__tile__action {
        margin-right: 20px;
    }
    .message-button {
        padding: 3px;
        border-radius: 5px;
        background: #19a924e3;
        color: #ffffff !important;
        text-decoration: none;
    }
    @media (max-width: 550px) {
        .message-block .v-list__tile {
            flex-direction: column;
            align-items: center;
        }
        .message-block .v-list__tile__content {
            width: 100%;
        }
        .message-block .v-list__tile__action {
            margin-top: 15px;
            margin-right: 0;
        }
    }
</style>