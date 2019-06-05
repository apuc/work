<template>
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
                    v-model="date"
                    label="Дата рождения"
                    class="date-label"
                    prepend-icon="event"
                    readonly
                    v-on="on"
            ></v-text-field>
        </template>
        <v-date-picker
                ref="picker"
                v-model="date"
                :max="new Date().toISOString().substr(0, 10)"
                min="1950-01-01"
                @change="save"
                locale="ru-ru"
        ></v-date-picker>
    </v-menu>
</template>

<script>

    export default {
        name: 'DatePicker',
        data() {
            return {
                date: null,
                menu: false
            }
        },
        mounted() {
            this.getDate().then(response => {
                this.date = response.data.date;
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
        },
        watch: {
            menu (val) {
                val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
            }
        },
        methods: {
            save (date) {
                this.$emit('input', date);
                this.$refs.menu.save(date);
            },
            async getDate() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index`);
            },
        }
    }

</script>

<style>
    .date-label .v-label {
        color: rgba(0,0,0,.87) !important;
    }
</style>