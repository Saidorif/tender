<template>
  <div class="card lognCard">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="card-body login-card-body">
      <div class="form_content jv_login_block">
        <div class="flagbg">
          <h6>{{$t('Tender platformasiga kirish.')}} </h6>
          <p> {{$t('Agar siz roʼyxatdan oʼtmagan boʼlsangiz iltimos, roʼyxatdan oʼting.')}}</p>
        </div>
        <div class="jv_form_block">
          <div class="logo_login">
            <img  src="img/logoUz.png" alt="">
          </div>
          <form enctype="multipart/form-data">
            <div  class="input-group input_group_with_label">
              <input
              type="number"
              class="form-control"
              v-model="form.inn"
              :class="isRequired(form.inn) ? 'isRequired' : ''"
              v-mask="'999999999'"
              @input="checkUser"
              id="STIR">
              <label  for="STIR">{{$t('INN')}}</label>
            </div>
            <div  class="form-group" v-if="showBtn">
              <label for="file" class="form-control-label">{{$t('Fayl')}}</label>
              <input
                type="file"
                class="form-control"
                @change="changePhoto($event)"
              >
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn_register_block">
                  <button type="button" class="btn_bd_blue" @click.prevent="back">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{$t('Orqaga')}}
                  </button>
                </div>
                <button type="button" class="btn_login" v-if="showBtn" @click.prevent="send">
                  <i class="fas fa-envelope-open-text"></i>
                  {{$t('Joʼnatish')}}
                </button>
            </div>
          </form>
        </div>
      </div>
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
        inn: "",
        file: "",
      },
      info:[],
      showBtn:false,
      fileName: '',
      errorFile: false,
      requiredInput: false,
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
    ...mapGetters('apply',['getApplyMessage','getCheckInn'])
  },
  async mounted() {
    this.laoding = false
  },
  methods: {
    ...mapActions('apply',['actionSendApply','actionCheckInn']),
    ...mapActions(["login", "register"]),
    ...mapActions("user", ["ActionRegisterUser"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async checkUser(){
      if(this.form.inn.length == 9){
        await this.actionCheckInn({inn:this.form.inn});
        if(this.getCheckInn.success){
          this.showBtn = true
          this.info = this.getCheckInn.result
        }else{
          toast.fire({
            type: 'error',
            icon: 'error',
            title: 'Не найден!',
          })
        }
      }else if(this.form.inn.length > 9){
        this.form.inn = this.form.inn.slice(0,9);
      }
    },
    changePhoto(event){
      let file = event.target.files[0];
      if(event.target.files[0]['type'] ==='image/png' || event.target.files[0]['type'] ==='image/jpeg' || event.target.files[0]['type'] ==='image/jpg'){
        if (file.size > 1048576){
            swal.fire({
              type: 'error',
              title: 'Ошибка',
              text:'Размер изображения не должно быть больше 1мб',
            })
        }else{
            let reader = new FileReader();
            reader.onload = event=> {
              this.form.file = event.target.result;
              this.fileName = file.name;
              this.errorFile = false
            };
            reader.readAsDataURL(file);
        }
      }
    },
    back(){
      this.$router.go(-1)
    },
    async send() {
      if (this.form.inn.length == 9 && this.getCheckInn.success && this.form.file != '') {
        await this.actionSendApply(this.form);
        if (this.getApplyMessage.success) {
          swal.fire({
            type: 'success',
            title: 'Спасибо ваша заявка принята!'
          })
          this.$router.push("/login");
        }
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
