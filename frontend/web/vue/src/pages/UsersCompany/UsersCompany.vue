<template>
  <div>
    <v-btn @click="$router.push('/personal-area/add-HR')">
      Добавить пользователя
    </v-btn>
    <ul class="collection">
      <template v-for="user in companyUsers">
        <li class="collection-item avatar" :key="user.id">
          <span class="title_email theme--light">Email</span>
          <hr class="hr">
          <p class="mail_place">
            {{ user.email }}
          </p>
          <v-btn @click="deleteUser(user)">
            Удалить
          </v-btn>
        </li>
      </template>
    </ul>
  </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: "UsersCompany",
  computed: {
    ...mapGetters([
        "allCompany", "companyUsers"
    ]),
  },
  async created() {
    await this.$store.dispatch('getAllCompany')
    await this.getCompanyUsers();
  },
  methods: {
    async deleteUser(user){
      let data = {
        user_id: user.id,
        company_id: this.allCompany.id
      };
      console.log(data)
      await this.$store.dispatch('removeRightCompany', data).then(() => {
        this.$swal({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 4000,
          type: 'success',
          title: 'Пользователь успешно удален',
        })
        this.getCompanyUsers();
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
    async getCompanyUsers(){
      await this.$store.dispatch('getCompanyUsers', {'company_id': this.allCompany.id } ).catch(error => {
        this.$swal({
          toast: true,
          position: 'bottom-end',
          showConfirmButton: false,
          timer: 4000,
          type: 'error',
          title: error.message
        })
      });
    }
  }
}
</script>

<style scoped>
.collection-item {
  list-style-type: none;
}
.title_email {
  font-size: 20px;
  margin-left: 8px;
  color: rgb(169 169 169);
  }
.collection-item {
  margin-top: 15px;
  margin-left: -20px;
}
.mail_place {
  margin-left: 9px;
  font-size: 17px;
}
.hr {
  width: 20%;
}
</style>