<template>
  <div class="add_employee">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i  class="peIcon pe-7s-users"></i></i>Добавить перевозчик
        </h3>
        <button
          type="button"
          @click="changeStatus()"
          class="btn"
          :class="statusClass"
        >
          <i :class="statusFont" class="fas"></i>
          {{statusText}}
        </button>
        <router-link class="btn btn-primary back_btn" to="/crm/client">
          <span class="peIcon pe-7s-back"></span> Назад
        </router-link>
      </div>
      <form role="form" @submit.prevent.enter="sendEmployee" enctype="multipart/form-data">
        <div class="card-body d-flex flex-wrap">
            <div class="form-group col-lg-6">
              <label for="surname">Фамилия</label>
              <input
                type="text"
                class="form-control input_style"
                id="surname"
                placeholder="Фамилия"
                v-model="form.surname"
                disabled
              />
            </div>
            <div class="form-group col-lg-6">
              <label for="name">Имя</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                placeholder="Имя"
                v-model="form.name"
                disabled
              />
            </div>
            <div class="form-group col-lg-6">
              <label for="middlename">Отчество</label>
              <input
                type="text"
                class="form-control input_style"
                id="middlename"
                placeholder="Отчество"
                v-model="form.middlename"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="company_name">Название компании</label>
              <input
                type="text"
                class="form-control input_style"
                id="company_name"
                placeholder="Название компании"
                v-model="form.company_name"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="region">Область</label>
              <input
                type="text"
                class="form-control input_style"
                id="region"
                placeholder="Область.."
                v-model="form.region.name"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="area">Регион/Город</label>
              <input
                type="text"
                class="form-control input_style"
                id="area"
                placeholder="Регион/Город.."
                v-model="form.area.name"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="trusted_person">Уполномоченное лицо</label>
              <input
                type="text"
                class="form-control input_style"
                id="trusted_person"
                placeholder="Уполномоченное лицо"
                v-model="form.trusted_person"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="email">E-mail</label>
              <input
                type="text"
                class="form-control input_style"
                id="email"
                placeholder="E-mail.."
                v-model="form.email"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="inn">ИНН</label>
              <input
                type="text"
                class="form-control input_style"
                id="inn"
                placeholder="ИНН.."
                v-model="form.inn"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="bank_number">Р/счет</label>
              <input
                type="text"
                class="form-control input_style"
                id="bank_number"
                placeholder="Р/счет.."
                v-model="form.bank_number"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="mfo">МФО</label>
              <input
                type="text"
                class="form-control input_style"
                id="mfo"
                placeholder="МФО.."
                v-model="form.mfo"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="oked">ОКЕД</label>
              <input
                type="text"
                class="form-control input_style"
                id="oked"
                placeholder="ОКЕД.."
                v-model="form.oked"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="city">Адрес банка</label>
              <input
                type="text"
                class="form-control input_style"
                id="city"
                placeholder="Адрес банка.."
                v-model="form.city"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="license_number">Номер лицензии</label>
              <input
                type="text"
                class="form-control input_style"
                id="license_number"
                placeholder="Номер лицензии.."
                v-model="form.license_number"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="phone">Телефон</label>
              <input
                type="text"
                class="form-control input_style"
                id="phone"
                placeholder="Телефон.."
                v-model="form.phone"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="license_type">Тип лицензии</label>
              <input
                type="text"
                class="form-control input_style"
                id="license_type"
                placeholder="Тип лицензии.."
                v-model="form.license_type"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="address">Адрес</label>
              <textarea
                class="form-control input_style"
                id="address"
                placeholder="Адрес.."
                v-model="form.address"
                disabled
              ></textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="license_date">Дата лицензии</label>
              <input
                type="text"
                class="form-control input_style"
                id="license_date"
                placeholder="Дата лицензии.."
                v-model="form.license_date"
                disabled
              />
            </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapActions, mapGetters } from "vuex";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Loader
  },
  data() {
    return {
      form: {},
      requiredInput: false,
      checkPassword: false,
      emailError: false,
      laoding: true,
      statusText:'Активировать',
      statusClass:' btn-success',
      statusFont:' fa-check',
    };
  },
  async mounted() {
    await this.actionClientEdit(this.$route.params.clientId);
    this.form = this.getClient
    this.laoding = false
  },
  watch:{
    getClient:{
      handler(){
        this.form = this.getClient
        if (this.form.status == 'inactive') {
          this.statusText = 'Заблокировать'
          this.statusClass = ' btn-danger'
          this.statusFont = ' fa-lock'
        }else{
          this.statusText = 'Активировать'
          this.statusClass = ' btn-success'
          this.statusFont = ' fa-check'
        }
      }
    }
  },
  computed: {
    ...mapGetters("client", ["getMassage","getClient"]),
  },
  methods: {
    ...mapActions("client", ["actionClientEdit",'actionClientUpdate']),
    async changeStatus(){
      let status = ''
      if (this.form.status == 'active') {
        status = 'inactive'
      }else{
        status = 'active'
      }
      let data ={
        id:this.$route.params.clientId,
        status:  status
      }
      this.laoding = true
      await this.actionClientUpdate(data)
      if (this.getMassage.success){
        toast.fire({
          type: 'success',
          icon: 'success',
          title: this.getMassage.message,
        })
        await this.actionClientEdit(this.$route.params.clientId);
      }
        this.laoding = false
    },
    // confirmPassword() {
    //   if (this.form.password && this.form.confirm_password) {
    //     if (this.form.password != this.form.confirm_password) {
    //       this.checkPassword = true;
    //     } else {
    //       this.checkPassword = false;
    //     }
    //   }
    // },
    // isRequired(input) {
    //   if (input != null) {
    //     return this.requiredInput && input === "";
    //   }
    // },
    // async checkEmailInput() {
    //   await this.actionCheckEmail({ email: this.form.email });
    //   if (
    //     this.getMassage.error &&
    //     this.getMassage.message.email == "Почта уже занята."
    //   ) {
    //     this.emailError = true;
    //   } else {
    //     this.emailError = false;
    //   }
    // },
  }
};
</script>
<style scoped>
</style>

