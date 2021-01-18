<template>
    <div>
        <v-subheader class="all-head">
            Список операций
        </v-subheader>
        <v-card flat>
            <v-card-text>
                <v-list two-line class="message-block">
                    <template v-for="(item, index) in operations.models">
                        <v-list-tile
                            :key="index"
                            avatar
                            ripple
                            class="message-item"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{ item.name }} ({{ item.amount }} ₽)</v-list-tile-title>
                                <v-list-tile-sub-title class="message__text" v-html="item.text"></v-list-tile-sub-title>
                            </v-list-tile-content>
                            <v-list-tile-action>
                                <v-list-tile-action-text class="message__data">{{ getDateFormat(item.date) }}</v-list-tile-action-text>
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
import {mapGetters} from "vuex";

export default {
    name: "Operations",
    data() {
        return {
        }
    },
    created(){
      document.title = this.$route.meta.title;
    },
    mounted() {
        this.$store.dispatch('getOperations')
            .then(data => {
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

    methods: {
        getDateFormat(time) {
            let date = new Date();
            date.setTime(time * 1000);
            let options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
            };
            time = date.toLocaleString("ru", options);
            return time;
        }
    },

    computed: {
        ...mapGetters([
            'operations',
        ])
    }
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