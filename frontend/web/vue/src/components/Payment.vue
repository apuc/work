<template>
    <div>
        <v-subheader class="all-head">
            Оплата
        </v-subheader>
        <form method="get" action="https://www.free-kassa.ru/merchant/cash.php">
            <input type="hidden" name="m" value="214123">
            <v-text-field
                    v-model="formData.amount"
                    name="oa"
                    label="Сумма"
                    @input="getHash"
                    :rules="[v => (v === '') || (/^\d+[\.,]{0,1}\d+$/.test(v) || 'Только цифры')]"
            ></v-text-field>
            <input type="hidden" name="o" :value="companyId">
            <input type="hidden" name="s" :value="hash">
            <input type="hidden" name="lang" value="ru">
            <v-text-field
                    v-model="email"
                    name="us_login"
                    label="Email"
                    :rules="[v => /.+@.+/.test(v) || 'Email должен быть правильным']"
            ></v-text-field>
            <v-btn
                    :disabled="hash === '' && (formData.amount === '' || formData.amount === 0)"
                    color="success"
                    name="pay"
                    type="submit"
            >
                Перейти к оплате
            </v-btn>
        </form>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "Payment",
        data: () => ({
            formData: {
                amount: ''
            },
            email: '',
            companyId: 0,
            hash: '',
        }),
        mounted() {
            this.$store.dispatch('getUserMe', this.$route.params.id)
                .then(data => {
                    this.email = data.user.email;
                    this.companyId = data.user.company.id;
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
            getHash() {
                if (this.formData.amount > 0) {
                    this.$store.dispatch('sendPayment', this.formData)
                        .then(data => {
                            this.hash = data;
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
                } else {
                    this.hash = '';
                }
            },
        },
        computed: {
            ...mapGetters([
                'userMe',
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