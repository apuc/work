<template>
    <v-form
            ref="form"
            v-model="valid"
            lazy-validation
    >
        <slot />
        <v-text-field
                v-model="formDataNewPass.old_password"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min, rules.max]"
                :type="show1 ? 'text' : 'password'"
                name="old_password"
                label="Старый пароль"
                hint="Не меньше 6 символов"
                counter
                @click:append="show1 = !show1"
        ></v-text-field>
        <v-text-field
                v-model="formDataNewPass.new_password_1"
                :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min, rules.max]"
                :type="show2 ? 'text' : 'password'"
                name="new_password_1"
                label="Новый пароль"
                hint="Не меньше 6 символов"
                counter
                @click:append="show2 = !show2"
        ></v-text-field>
        <v-text-field
                v-model="formDataNewPass.new_password_2"
                :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min, rules.max]"
                :type="show3 ? 'text' : 'password'"
                name="new_password_2"
                label="Повторите новый пароль"
                hint="Не меньше 6 символов"
                counter
                @click:append="show3 = !show3"
        ></v-text-field>

        <v-btn
                :disabled="!valid"
                color="success"
                id="main-btn"
                @click="validate"
                type="button"
        >
            Сохранить
        </v-btn>

    </v-form>
</template>

<script>
    import NewPass from "../mixins/new-pass";

    export default {
        name: "NewPassword",
        data: () => ({
            valid: true,
        }),
        mixins: [NewPass],
        methods: {
            saveDataNewPass() {
                let data = {
                    old_password: this.formDataNewPass.old_password,
                    new_password_1: this.formDataNewPass.new_password_1,
                    new_password_2: this.formDataNewPass.new_password_2,
                    phoneValid: this.formData.phoneValid
                };

                this.$http.post(`${process.env.VUE_APP_API_URL}/request/security/change-password`, data)
                    .then(response => {
                            this.$swal({
                                title: 'Данные сохранены'
                            }).then((result) => {
                                return result;
                            });
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
                    )
            },
            validate () {
                let btn = document.getElementById('main-btn');
                btn.disabled = true;
                let valid = this.$refs.form.validate();
                this.$emit('val', valid);
                if (valid) {
                    this.snackbar = true;
                    this.saveDataNewPass();
                }
            },
        }
    }
</script>

<style scoped>

</style>