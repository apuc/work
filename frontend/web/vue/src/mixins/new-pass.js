const newPass = {
    data() {
        return {
            formDataNewPass: {
                old_password: '',
                new_password_1: '',
                new_password_2: ''
            },
            show1: false,
            show2: false,
            show3: false,
            password: 'Password',
            rules: {
                required: value => !!value || 'Поле обязательно для заполнения.',
                min: v => v.length >= 6 || 'Не меньше 6 символов',
                max: v => v.length <= 25 || 'Не больше 25 символов',
            },
        };
    }
};

export default newPass;
