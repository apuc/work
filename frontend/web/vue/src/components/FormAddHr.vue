<template>
  <form class="registration" name="register-form" @submit.prevent="validate">
    <p class="registration__title">Добавить HR менеджера:</p>
    <input type="hidden" name="_csrf" :value="csrf">
    <div class="form-group ">
      <input v-model="first_name"
             @focus="showFirstNameError = false"
             class="input-style"
             type="text"
             name="first_name"
             placeholder="Имя"
      >
      <span v-if="showFirstNameError" class="help-block">Необходимо заполнить поле Имя.</span>
    </div>
    <div class="form-group">
      <input
          v-model="second_name"
          @focus="showSecondNameError = false"
          class="input-style"
          type="text"
          name="second_name"
          placeholder="Фамилия"
      >
      <span v-if="showSecondNameError" class="help-block">Необходимо заполнить поле Фамилия.</span>
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
    <div class="d-flex">
      <v-btn class="form-submit" color="success" type="submit">
        Сохранить
      </v-btn>
      <v-btn class="form-submit" color="primary" type="button"
        @click="$router.go(-1)"
      >
        Вернуться
      </v-btn>
    </div>

  </form>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: 'FormAddHr',
  data(){
    return {
      first_name: '',
      second_name: '',
      email: '',
      password: '',
      showPasswordError: false,
      showFirstNameError: false,
      showSecondNameError: false,
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
    },
    ...mapGetters([
      "allCompany"
    ])
  },
  methods: {
    async validate () {
      if(this.first_name.length <= 3 ){
        this.showFirstNameError = true;
        return false
      }
      if(this.second_name.length <= 3){
        this.showSecondNameError = true;
        return false
      }
      if(this.email.length === 0){
        this.showEmailError = true;
        return false
      }
      if(this.password.length > 0){
        if(this.allCompany.id === undefined) await this.$store.dispatch('getAllCompany');
        this.submitAction( {
          first_name: this.first_name,
          second_name: this.second_name,
          email: this.email,
          password: this.password,
          company_id: this.allCompany.id
        } )
      }
      else {
        this.showPasswordError = true;
      }
    },
    async submitAction (payload) {
      await this.$store.dispatch('addHr', payload).then(() => {
        this.clear();
        this.$store.dispatch('getCompanyUsers', {'company_id': this.allCompany.id })
        this.$swal({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 4000,
          type: 'success',
          title: 'Менеджер добавлен успешно',
        })
      }).catch(error => {
        this.$swal({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 4000,
          type: 'warning',
          title: error.message
        })
      });
    },
    clear () {
      this.first_name = ''
      this.email = ''
      this.second_name = ''
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