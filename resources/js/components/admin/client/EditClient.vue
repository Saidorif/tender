<template>
  <div class="add_employee">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i  class="peIcon pe-7s-users"></i> {{$t('Tashuvchi qoʼshish')}}
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
          <span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}
        </router-link>
      </div>
      <form role="form" @submit.prevent.enter="sendEmployee" enctype="multipart/form-data">
        <div class="card-body d-flex flex-wrap">
            <div class="form-group col-lg-6">
              <label for="surname">{{$t('Familiya')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="surname"
                v-model="form.surname"
                disabled
              />
            </div>
            <div class="form-group col-lg-6">
              <label for="name">{{$t('Ism')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                v-model="form.name"
                disabled
              />
            </div>
            <div class="form-group col-lg-6">
              <label for="middlename">{{$t('Sharif')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="middlename"
                v-model="form.middlename"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="company_name">{{$t('Tashkilot nomi')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="company_name"
                v-model="form.company_name"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="region">{{$t('Viloyat')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="region"
                v-model="form.region.name"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="area">{{$t('Tuman/Shahar')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="area"
                v-model="form.area.name"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="trusted_person">{{$t('Vakolatli shaxs')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="trusted_person"
                v-model="form.trusted_person"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="email">{{$t('Email')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="email"
                v-model="form.email"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="inn">{{$t('INN')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="inn"
                v-model="form.inn"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="bank_number">{{$t('X/raqam')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="bank_number"
                v-model="form.bank_number"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="mfo">{{$t('MFO')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="mfo"
                v-model="form.mfo"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="oked">{{$t('OKED')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="oked"
                v-model="form.oked"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="city">{{$t('Bankning manzili')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="city"
                v-model="form.city"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="license_number">{{$t('Litsenziya raqami')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="license_number"
                v-model="form.license_number"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="phone">{{$t('Telefon')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="phone"
                v-model="form.phone"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="license_type">{{$t('Litsenziya turi')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="license_type"
                v-model="form.license_type"
                disabled
              />
            </div>
            <div class="form-group col-md-6">
              <label for="address">{{$t('Manzil')}}</label>
              <textarea
                class="form-control input_style"
                id="address"
                v-model="form.address"
                disabled
              ></textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="license_date">{{$t('Letsenizya sanasi')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="license_date"
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
        if (this.form.status == 'active') {
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
      if (this.form.status == 'inactive') {
        status = 'active'
      }else{
        status = 'inactive'
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

