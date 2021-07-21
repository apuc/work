<template>
  <div>
    <v-btn @click="$router.push('/personal-area/add-HR')">
      Добавить пользователя
    </v-btn>
    <ul class="collection">
      <div v-for="item in 10">
        <li class="collection-item avatar">
          <span class="title_email theme--light">Email</span>
          <hr class="hr">
            <p class="mail_place">
             valery.shumkov@mail.ru
            </p>
            <v-btn>
             Удалить
            </v-btn>
        </li>
      </div>
    </ul>
  </div>
</template>

<script>
export default {
  name: "UsersCompany"
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