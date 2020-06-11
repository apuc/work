<template>
    <div>
        <FormTemplate :paramsFile="getFormData()" v-model="formData" :sendForm="saveData" @val="valHandler">
        </FormTemplate>


    </div>
</template>

<script>
    import CompanyTransfer from '../lk-form/company-transfer';
    import FormTemplate from "./FormTemplate";

    export default {
        name: "CompanyTransfer",
        components: {FormTemplate},
        data() {
            return {
                formData: {
                    companyTransfer: '',
                    phoneValid: true
                }
            };
        },
        mounted(){
            document.title = this.$route.meta.title;
        },
        methods: {
            saveData() {
                let data = {
                    email: this.formData.companyTransfer,
                    company_id: this.$route.params.id,
                    phoneValid: this.formData.phoneValid
                };
                this.$http.post(`${process.env.VUE_APP_API_URL}/request/company/transfer`, data)
                    .then(response => {
                            this.$router.push('/personal-area/all-company');
                        }, response => {
                            this.$swal({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 10000,
                                type: 'error',
                                title: response.data.message
                            })
                        }
                    );

            },
            getFormData() {
                return CompanyTransfer;
            },
            valHandler(val) {
                this.valid = val;
            },
        }
    }
</script>

<style scoped>

</style>