<template>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
    >
        <slot/>
        <v-text-field
            v-model="formData.promocode"
            name="promocode"
            label="Промо код"
            :rules="[v => !!v || 'Промо код обязателен к заполнению']"
        ></v-text-field>

        <v-btn
            :disabled="!valid"
            color="success"
            id="main-btn-pass"
            @click="validate"
            type="button"
        >
            Сохранить
        </v-btn>

    </v-form>
</template>

<script>
export default {
    name: "AddPromo",
    data: () => ({
        formData: {
            promocode: ''
        },
        showImage: false,
        showLogo: false,
        valid: false,
        cityArray: [],
        categoryArray: [],
    }),
    methods: {
        savePromocode() {
            this.$store.dispatch('addPromocode', this.formData)
                .then(data => {
                    this.$swal({
                        title: 'Промокод успешно принят'
                    }).then((result) => {
                        return result;
                    });
                    return data;
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
        validate() {
            let btn = document.getElementById('main-btn-pass');
            btn.disabled = true;
            let valid = this.$refs.form.validate();
            this.$emit('val', valid);
            if (valid) {
                this.snackbar = true;
                btn.disabled = false;
                this.savePromocode();
            }
        },
    },
}
</script>

<style scoped>

</style>