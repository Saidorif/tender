<template>
  <div class="card lognCard registerCard">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="card-body login-card-body">
      <form @submit.enter.prevent="onSignUp" class="form_content jv_login_block">
        <div class="flagbg">
          <div class="input-group input_group_with_label">
            <select id="complaint_category_id" class="form-control input_style"  v-model="signUp.region_id" :class="isRequired(signUp.region_id) ? 'isRequired' : ''" @change="selectRegion()">
              <option :value="item.id" v-for="(item, index) in getRegionList">
                {{ item.name }}
              </option>
            </select> 
            <label for="complaint_category_id">Viloyatni tanlang!</label>
          </div>
          <div class="input-group input_group_with_label">
            <select id="complaint_category_id" class="form-control input_style" 
              v-model="signUp.area_id" :class="isRequired(signUp.area_id) ? 'isRequired' : ''">
              <option
                :value="item.id"
                v-for="(item, index) in getAreaList"
              >
                {{ item.name }}
              </option>
            </select> 
            <label for="complaint_category_id">Viloyat yoki shaharni tanlang!</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              id="address"
              class="form-control"
              v-model="signUp.address"
              :class="isRequired(signUp.address) ? 'isRequired' : ''"
            />
            <label  for="address">Manzil</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="surname"
              v-model="signUp.surname"
              :class="isRequired(signUp.surname) ? 'isRequired' : ''"
            />
            <label  for="surname">Familya</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="name"
              v-model="signUp.name"
              :class="isRequired(signUp.name) ? 'isRequired' : ''"
            />
            <label  for="name">Ism</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="middlename"
               v-model="signUp.middlename"
               :class="isRequired(signUp.middlename) ? 'isRequired' : ''"
            />
            <label  for="middlename">Sharif</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              v-model="signUp.inn"
              :class="isRequired(signUp.inn) ? 'isRequired' : ''"
              v-mask="'999999999'"
              id="STIR"
            />
            <label  for="STIR">STIR</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="company_name"
              v-model="signUp.company_name"
              :class="isRequired(signUp.company_name) ? 'isRequired' : ''"
            />
            <label  for="company_name">Kompaniyani nomi</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="trusted_person"
              v-model="signUp.trusted_person"
              :class="isRequired(signUp.trusted_person) ? 'isRequired' : ''"
            />
            <label  for="trusted_person">Vakolatli shaxs</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="email"
              class="form-control"
              id="userEmail"
              v-model="signUp.email"
              :class="isRequired(signUp.email) ? 'isRequired' : ''"
            />
            <label  for="userEmail">Email</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="phone"
              v-mask="'(99)999-99-99'"
              v-model="signUp.phone"
              :class="isRequired(signUp.phone) ? 'isRequired' : ''"
            />
            <label  for="phone">Telefon</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="password"
              class="form-control"
              id="password"
              :class="isRequired(signUp.password) ? 'isRequired' : ''"
              v-model="signUp.password"
            />
            <label  for="password">Parol</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="password"
              class="form-control"
              id="license_number"
              v-model="signUp.confirm_password"
              :class="
                isRequired(signUp.confirm_password)
                  ? 'isRequired'
                  : ''
              "
              @input="confirmPassword()"
            />
            <label  for="license_number">Parolni tasdiqlang</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="city"
              v-model="signUp.city"
              :class="isRequired(signUp.city) ? 'isRequired' : ''"
            />
            <label  for="city">Bankining manzli</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="bank_number"
              v-model="signUp.bank_number"
              :class="
                isRequired(signUp.bank_number) ? 'isRequired' : ''
              "
              v-mask="'99999999999999999999'"
            />
            <label  for="bank_number">Bank hisob raqami</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="mfo"
              v-model="signUp.mfo"
              :class="isRequired(signUp.mfo) ? 'isRequired' : ''"
              v-mask="'99999'"
            />
            <label  for="mfo">MFO</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="oked"
              v-model="signUp.oked"
              :class="isRequired(signUp.oked) ? 'isRequired' : ''"
              v-mask="'99999'"
            />
            <label  for="oked">OKED</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="license_number"
              v-model="signUp.license_number"
              :class="
                isRequired(signUp.license_number) ? 'isRequired' : ''"
            />
            <label  for="license_number">Litsenziya nomeri</label>
          </div>
          <div  class="input-group input_group_with_label">
            <input
              type="text"
              class="form-control"
              id="license_number"
              v-model="signUp.license_type"
              :class="isRequired(signUp.license_type) ? 'isRequired' : ''"
            />
            <label  for="license_number">Litsenziya turi</label>
          </div>
          <div  class="input-group input_group_with_label">
            <date-picker
              lang="ru"
              type="date"
              v-model="signUp.license_date"
              valueType="format"
              :class="
                isRequired(signUp.license_date) ? 'isRequired' : ''
              "
            ></date-picker>
            <label  for="license_date">Litsenziya sanasi</label>
          </div>
          <div  class="input-group input_group_with_label">
          </div>
            <div class="btns_block">
              <div class="btn_register_block">
                <a href="/login" class="btn_bd_blue">Tizimga kirish</a>
              </div>
              <button type="submit" class="btn_login">
                Ro'yxatdan o'tish
              </button>
            </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import { TokenService } from "./../../services/storage.service";
import Header from '../pages/Header'
import Loader from '../Loader'
export default {
  components: {
    DatePicker,
    Header,
    Loader
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      signUp: {
        region_id: "",
        area_id: "",
        name: "",
        surname: "",
        middlename: "",
        city: "",
        bank_number: "",
        oked: "",
        mfo: "",
        inn: "",
        phone: "",
        address: "",
        company_name: "",
        license_number: "",
        password: "",
        confirm_password: "",
        email: "",
        license_type: "",
        license_date: "",
        trusted_person: "",
      },
      errorMsg: null,
      errorMsgSign: null,
      requiredLoginInput: false,
      requiredInput: false,
      checkPassword: false,
      laoding: true
    };
  },
  computed: {
    ...mapGetters([
      "authenticationErrorCode",
      "authenticationError",
      "getRegisterError",
    ]),
    ...mapGetters("user", ["getMessage"]),
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
  },
  async mounted() {
    await this.actionRegionList();
    this.laoding = false
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions(["login", "register"]),
    ...mapActions("user", ["ActionRegisterUser"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    isLoginRequired(input) {
      return this.requiredLoginInput && input === "";
    },
    async selectRegion() {
      await this.actionAreaByRegion({ region_id: this.signUp.region_id });
    },
    confirmPassword() {
      if (this.signUp.password && this.signUp.confirm_password) {
        if (this.signUp.password != this.signUp.confirm_password) {
          this.checkPassword = true;
        } else {
          this.checkPassword = false;
        }
      }
    },
    async onLogin() {
      this.$Progress.start();
      if (this.form.email != "" && this.form.password != "") {
        await this.login(this.form);
        await this.authenticationErrorCode;
        if (!this.authenticationErrorCode) {
          toast.fire({
            type: "success",
            icon: "success",
            title: "Вошли в систему!",
          });
          this.$Progress.finish();
          // setTimeout(()=>{
          // 	window.location = '/crm/dashboard';
          // },100)
          //   this.$router.push("/crm/dashboard");
          this.requiredLoginInput = false;
          window.location.href = "/crm/dashboard";
        } else {
          this.errorMsg = this.authenticationError;
          this.$Progress.fail();
        }
      } else {
        this.requiredLoginInput = true;
      }
    },
    async onSignUp() {
      if (
        this.signUp.name != "" &&
        this.signUp.city != "" &&
        this.signUp.bank_number != "" &&
        this.signUp.oked != "" &&
        this.signUp.mfo != "" &&
        this.signUp.inn != "" &&
        this.signUp.phone != "" &&
        this.signUp.address != "" &&
        this.signUp.company_name != "" &&
        this.signUp.license_number != "" &&
        this.signUp.password != "" &&
        this.signUp.confirm_password != "" &&
        this.signUp.region_id != "" &&
        this.signUp.area_id != "" &&
        this.signUp.email != "" &&
        this.signUp.surname != "" &&
        this.signUp.middlename != "" &&
        this.signUp.email != "" &&
        this.checkPassword == false
      ) {
        await this.register(this.signUp);
        if (this.getRegisterError.success) {
          toast.fire({
            type: "success",
            icon: "success",
            title:
              "Ваш пароль отправлен на ваш e-mail. проверьте пожалуйста свою электронную почту!",
          });
          this.signUp.region_id = "";
          this.signUp.area_id = "";
          this.signUp.name = "";
          this.signUp.city = "";
          this.signUp.bank_number = "";
          this.signUp.oked = "";
          this.signUp.mfo = "";
          this.signUp.inn = "";
          this.signUp.phone = "";
          this.signUp.address = "";
          this.signUp.company_name = "";
          this.signUp.license_number = "";
          this.signUp.password = "";
          this.signUp.confirm_password = "";
          this.signUp.email = "";
          this.signUp.license_type = "";
          this.signUp.license_date = "";
          this.signUp.trusted_person = "";
          this.signUp.surname = "";
          this.signUp.middlename = "";
        } else {
          this.errorMsgSign = this.getRegisterError.message;
        }
      } else {
        this.requiredInput = true;
      }
    },
  },
};
</script>
<style scoped>
.pas_confirm_frame .input-group {
  margin-bottom: 0px;
}
.input-group.register_date .mx-datepicker .mx-input-wrapper .mx-icon-calendar,
.mx-icon-clear {
  color: #acf1c1 !important;
}
</style>