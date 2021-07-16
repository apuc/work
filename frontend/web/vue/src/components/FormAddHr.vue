<template>
  <form class="registration" name="register-form" @submit.prevent="validate">
    <p class="registration__title">Добавить HR менеджера:</p>
    <input type="hidden" name="_csrf" :value="csrf">
    <div class="form-group ">
      <input v-model="name"
             @focus="showNameError = false"
             class="input-style"
             type="text"
             name="first_name"
             placeholder="Имя"
      >
      <span v-if="showNameError" class="help-block">Необходимо заполнить поле Имя.</span>
    </div>
    <div class="form-group">
      <input
          v-model="surname"
          @focus="showSurnameError = false"
          class="input-style"
          type="text"
          name="second_name"
          placeholder="Фамилия"
      >
      <span v-if="showSurnameError" class="help-block">Необходимо заполнить поле Фамилия.</span>
    </div>

    <div class="form-group ">
      <input v-model="email" @focus="showEmailError = false" type="email" class="input-style" placeholder="Электронная почта">
      <span v-if="showEmailError" class="help-block">Необходимо заполнить «Email».</span>
    </div>

    <div class="form-group ">
      <input v-model="password"
             @click="showPasswordError = false"
             type="password" class="input-style" placeholder="Пароль">
      <span v-if="showPasswordError" class="help-block">Необходимо заполнить «Пароль».</span>
    </div>

    <v-btn
        class="form-submit"
        color="success"
        type="submit"
    >
      Сохранить
    </v-btn>
  </form>
</template>

<script>
export default {
  name: 'FormAddHr',
  data(){
    return {
      name: '',
      surname: '',
      email: '',
      password: '',
      showPasswordError: false,
      showNameError: false,
      showSurnameError: false,
      showEmailError: false
    }
  },
  computed: {
    csrf() {
      const name = '_csrf';
      var matches = document.cookie.match(new RegExp(
          "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
      ))
      return matches ? decodeURIComponent(matches[1]) : undefined
    }
  },
  methods: {
    validate () {
      if(this.name.length <= 3 ){
        this.showNameError = true;
        return false
      }
      if(this.surname.length <= 3){
        this.showSurnameError = true;
        return false
      }
      if(this.email.length === 0){
        this.showEmailError = true;
        return false
      }
      if(this.password.length > 0){
        this.submitAction( { name: this.name, surname: this.surname, email: this.email, password: this.password } )
      }
      else {
        this.showPasswordError = true;
      }
    },
    submitAction (payload) {
      this.$store.dispatch('addHr', payload).then(() => {
        this.clear();
      })
    },
    clear () {
      this.name = ''
      this.email = ''
      this.surname = ''
      this.password = ''
    },
  },
}
</script>
<style scoped lang="scss">
.registration{
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  &__title{
    font-weight: 500;
    font-size: 20px;
    color: #262626;
  }
}
.input-style{
  min-width: 320px;
  margin-bottom: 25px;
  padding: 20px 0 20px 20px;
  font-size: 16px;
  font-weight: 400;
  color: #a8a8a8 !important;
  -webkit-box-shadow: 0 0 59px rgba(40, 40, 40, 0.05);
  box-shadow: 0 0 59px rgba(40, 40, 40, 0.05);
  border-radius: 10px;
  border: 1px solid #e8e8e8;
  background-color: #ffffff !important;
  outline: none;
}
.help-block{
  display: block;
}
.form-group{
  position: relative;
}
.help-block{
  position: absolute;
  bottom: 0;
  color: #FF0000FF;
}
.form-submit{
  margin-left: 0;
}
</style>