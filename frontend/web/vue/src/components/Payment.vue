<template>
  <div class="container__inner">
    <div>
    <div class="balance__container" :style="{'background-image': `url(${patternLayer})`} ">
      <h4 class="balance__title">
        <img :src="microChipIcon" alt="">
        <p>Пополнить счет</p>
      </h4>
      <form class="balance__form" method="get" action="https://www.free-kassa.ru/merchant/cash.php">
        <input type="hidden" name="m" value="214123">
        <div class="d-flex">
          <v-text-field
              v-model="formData.amount"
              name="oa"
              label="Сумма"
              @input="getHash"
              :rules="[rules.required]"
              style="width: 80%;"
              type="number"
              min="1"
          ></v-text-field>
          <v-spacer></v-spacer>
          <v-text-field prefix="₽" class="currency__char"
          ></v-text-field>
        </div>
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
            class="balance__btn"
            :disabled="hash === '' && (formData.amount === '' || formData.amount<1 || isNaN(formData.amount))"
            name="pay"
            light
            type="submit"
        >
          Перейти к оплате
        </v-btn>
      </form>
    </div>
      <a href="https://vk.com/rabotad0netsk" class="question__link">Есть вопросы? Напиши нам в соц.сетях <img :src="vkIcon" alt=""></a>
    </div>
    <div class="additional__services">
      <h5 class="services_title">Прайс услуг</h5>
      <div class="additional__services_inner">
        <div v-for="i in blocks" :key="i" class="additional__services_item" >
          <h5 class="services_item-title">{{i.title}}</h5>
          <p class="services_item-text" style="height: 30px">{{i.addInfo}}</p>
          <p class="services_item-price">Цена {{ i.price }} руб          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
  name: "Payment",
  data: () => ({
    blocks:[
      {
        title: 'Поднять вакансию в топ',
        price: '200',
        addInfo: 'Увеличить входящий поток резюме на вашу вакансию',
      },
      {
        title: 'Дополнительная вакансия',
        addInfo: 'Максимум откликов в течение месяца. Идеально подходит для сложного подбора',
        price: '100',
      },
      {
        title: 'Сделать вакансией дня',
        addInfo: 'По нашим подсчетам, количество откликов с выделением вакансии увеличивается в два раза',
        price: '150',
      },
      {
        title: 'Продлить существующую вакансию',
        addInfo: 'Вакансия будет повторно опубликована в течение месяца',
        price: '200',
      },
      // {
      //   title: 'Тариф «Стандарт+»',
      //   price: '200',
      //   list:
      // }
    ],
    rules:{
      required: (value) => !!value || "Обязательное поле.",
    },
    formData: {
      amount: ''
    },
    email: '',
    companyId: 0,
    hash: '',
    microChipIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/Micro_Chip.png',
    vkIcon: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/vk-256x256.png',
    patternLayer: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/Pattern_Layer.png',
  }),
  mounted() {
    if(this.$route.query.price){
      this.$set(this.formData,'amount',parseInt(this.$route.query.price,10))
      this.getHash(parseInt(this.$route.query.price,10))
    }
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
  created(){
    document.title = this.$route.meta.title;
  },
  methods: {
    getHash(e) {
      if(parseInt(e)===0)
        this.$set(this.formData,'amount',1)
      else
        this.$set(this.formData,'amount',parseInt(this.formData.amount,10))
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
.question__link{
  margin-top: 60px;
  display: flex;
  align-items: center;
  color: #000104;
  font-family: "Muller Medium", inherit;
  font-size: 16px;
  font-weight: 400;
  text-decoration: none;
  text-align: left;
  /* Text style for "Есть вопро" */
  font-style: normal;
  letter-spacing: normal;
  line-height: normal;
justify-content: end;
}
.question__link img{
  margin-left: 15px;
}
.container__inner {
  display: flex;
  flex-wrap: wrap;
  margin-top: 40px;
  margin-left: 20px;
}

.all-head {
  margin-top: 10px;
  margin-bottom: 15px;
  padding: 0;
  font-size: 22px;
  color: rgba(0, 0, 0, .74);
}

.balance__container {
  width: 100%;
  max-width: 534px;
  height: 337px;
  padding: 41px 37px;
  border-radius: 15px;
  border: 3px solid #dd3d34;
  position: relative;
}

.balance__title {
  color: #000000;
  font-family: "Muller Extra Bold", inherit;
  font-size: 20px;
  font-weight: 800;
  font-style: normal;
  text-align: left;
  text-transform: uppercase;
  /* Text style for "пополнить" */
  letter-spacing: 1.1px;
  line-height: normal;
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}

.balance__title p {
  margin-left: 23px;
  margin-bottom: 0;
}

.balance__form {
  padding: 23px 119px 31px 27px;
  background-color: white;
}

.balance__btn {
  position: absolute;
  width: 192px;
  height: 40px;
  font-family: "Muller Extra Bold", inherit;
  font-size: 11px;
  font-weight: 800;
  font-style: normal;
  text-transform: uppercase;
  letter-spacing: 1.1px;
  line-height: normal;
  border-radius: 20px;
  background-color: #ffffff;
  background-image: linear-gradient(to left, #dd3d34 0%, #af2a22 99%, #af2a22 100%);
  bottom: -28px;
  cursor: pointer !important;
}

.balance__btn::v-deep .v-btn__content {
  color: #ffffff !important;
}

.currency__char {
  width: 10px;
  min-width: 15px;
}

.additional__services {
  width: 52%;
  display: flex;
  flex-wrap: wrap;
  /*margin-right: 50px;*/
  margin: 13px 0 0 50px;
}

.additional__services_inner {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
}

.additional__services_item {
  position: relative;
  width: 100%;
  max-width: 355px;
  min-height: 193px;
  margin: 0 20px 20px 0;
  border: 1px solid #e8e8e8;
  padding: 29px 50px 0 50px;
}

.services_item-title {
  color: #1976d2;
  font-family: "Muller Medium", inherit;
  font-size: 20px;
  font-weight: 400;
  font-style: normal;
  text-align: left;
  font-style: normal;
  letter-spacing: 1.1px;
  line-height: normal;
  margin-bottom: 19px;
}

.services_item-text {
  font-weight: 400;
  font-style: normal;
  text-align: left;
  font-family: "Muller Regular", inherit;
  font-size: 13px;
  letter-spacing: normal;
  line-height: normal;
  margin-bottom: 32px;
}

.services_item-price {
  position: absolute;
  bottom: 0;
  color: #000000;
  font-family: "Muller Bold", inherit;
  font-size: 17px;
  font-weight: 800;
  text-align: left;
  font-style: normal;
  letter-spacing: normal;
  line-height: normal;
}

.services_title {
  color: #1976d2;
  font-family: "Muller Extra Bold", inherit;
  font-size: 20px;
  font-weight: 400;
  font-style: normal;
  text-align: left;
  text-transform: uppercase;
  font-style: normal;
  letter-spacing: 1.1px;
  line-height: normal;
  margin-bottom: 30px;
}

@media (max-width: 1584px) {
  .additional__services {
    margin-top: 2rem;
    width: 100%;
  }

}

@media (max-width: 550px) {
  .balance__form {
    padding-right: 15px;
    pading-left: 15px;
  }
  .additional__services{
    margin-left: 0;
  }
}
</style>
