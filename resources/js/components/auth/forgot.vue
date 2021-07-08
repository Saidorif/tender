<template>
  <div class="card lognCard registerCard">
    <header class="main_header">
      <div class="container">
        <a href="/" class="logo"><img src="img/logoUz.png" alt="" /></a>
        <ul class="menu_list">
          <li><a href="/">{{$t('menu.home')}}</a></li>
          <li><a href="/about">{{$t('menu.about_tender')}}</a></li>
          <li><a href="/list-tender">{{$t('menu.conducted_tenders')}}</a></li>
          <li><a href="/contact">{{$t('menu.contacts')}}</a></li>
        </ul>
        <a href="/login" class="btn_login"
          ><i class="fas fa-sign-in-alt"></i>{{$t('menu.login')}}</a
        >
      </div>
    </header>
    <div class="card-body login-card-body">
        <div class="form_content auth_request">
        </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import { TokenService } from "./../../services/storage.service";
export default {
  components: {
    DatePicker,
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
        this.laoding = true;
      await this.actionAreaByRegion({ region_id: this.signUp.region_id });
      this.laoding = false;
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
          this.laoding = false;
        await this.login(this.form);
        await this.authenticationErrorCode;
        this.laoding = true;
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
        this.laoding = true;
        await this.register(this.signUp);
        this.laoding = false;
        if (this.getRegisterError.success) {
          toast.fire({
            type: "success",
            icon: "success",
            title: this.$t("Parolingiz elektron pochtangizga yuborildi. elektron pochtangizni tekshiring"),
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
