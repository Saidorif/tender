<template>
  <div class="contacts_page">
    <header class="main_header">
      <div class="container">
          <a href="/" class="logo"><img src="img/logoUz.png" alt=""></a>
          <ul class="menu_list">
              <li ><a href="#">Bosh sahifa</a></li>
              <li><a href="#">Tender haqida</a></li>
              <li><a href="#">O'tkazilgan tenderlar</a></li>
              <li class="active"><a href="/contact">Biz bilan aloqa</a></li>
          </ul>
          <a href="/login" class="btn_login"><i class="fas fa-sign-in-alt"></i>Tizimga kirish</a>
      </div>
    </header>
    <div class="container">
      <div class="contact_block">
        <div class="col-md-6">
          <h2 class="title">Bizga o'z <span>taklif</span> va <span>e'trozlaringizni </span> qoldiring!</h2>
          <p class="sub_title">Taklif va e'torlaringizni formada qoldiring, biz sizning takliflarinigzni va e'trozlarinigzni o'rganib chiqib pochtangiz orqali batafsil ma'lumot beramiza yoki qo'ng'iroq qilamiz agar raqamingizni qoldirsangiz   </p>
        </div>
        <div class="col-md-6">
          <form @submit.enter.prevent="send">
            <div class="col-md-12">
                <div class="input-group input_group_with_label">
                  <select 
                    class="form-control input_style" 
                    v-model="form.complaint_category_id" 
                    :class="isRequired(form.complaint_category_id) ? 'isRequired' : ''"  
                  >
                    <option value="" selected disabled>Tanlang</option>
                    <option :value="item.id" v-for="(item,index) in getComplaintList">{{item.name}}</option>
                  </select>
                  <label for="#">Murojat turi</label>
                </div>
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.surname"
                    placeholder="Фамилия"
                    :class="isRequired(form.surname) ? 'isRequired' : ''"
                  />
                </div>
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.name"
                    placeholder="Имя"
                    :class="isRequired(form.name) ? 'isRequired' : ''"
                  />
                </div>
                <div class="input-group"> 
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.middlename"
                    placeholder="Отчество"
                  />
                </div>
                <div class="input-group">
                  <input
                    type="text"
                    v-mask="'(99)999-99-99'"
                    class="form-control"
                    v-model="form.phone"
                    placeholder="Телефон"
                    :class="isRequired(form.phone) ? 'isRequired' : ''"
                  />
                </div>
                <div class="input-group">
                  <input
                    type="file"
                    id="file"
                    class="form-control"
                    @change="changeFile($event)"
                  />
                </div>
                <div class="input-group">
                  <textarea
                    class="form-control"
                    v-model="form.text"
                    placeholder="Сообщение"
                    :class="isRequired(form.text) ? 'isRequired' : ''"
                  ></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group mt-4">
                  <button type="submit" class="btn btn-primary btn-block">Отправить</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex"
import DatePicker from "vue2-datepicker";
import Multiselect from 'vue-multiselect';
import { TokenService } from "./../../services/storage.service";
export default {
  components: {
    DatePicker,
    Multiselect,
  },
  data() {
    return {
      form: {
        name: "",
        surname: "",
        middlename: "",
        phone: '',
        text: '',
        file: '',
        // direction_id: '',
        complaint_category_id: '',
      },
      requiredInput: false,
      isLoading:false,
    };
  },
  computed: {
    ...mapGetters('complaint',['getComplaintList','getMassage'])
  },
  async mounted() {
    await this.actionComplaintList();
  },
  methods: {
    ...mapActions('complaint',['actionComplaintList','actionSendContact']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    // async filterVariantList(value){
    //   if(value != ''){
    //     this.isLoading = true
    //     setTimeout(()=>{
    //       this.actionComplaintList({name: value})
    //     this.isLoading = false
    //     },1000)
    //   }
    // },
    changeFile(event) {
      let file = event.target.files[0];
      if (file.size > 1048576) {
        swal.fire({
          type: "error",
          icon: "error",
          title: "Ошибка",
          text: "Размер файл не должно быть больше 1мб"
        });
      } else {
        this.form.file = event.target.files[0];
      }
    },
    dispatchAction(data){
      // this.form.direction_id =  data.id;
    },
    async send(){
      if (this.form.name && this.form.surname &&  this.form.phone &&  this.form.text){
        let formData = new FormData();
        formData.append('name', this.form.name);
        formData.append('surname', this.form.surname);
        formData.append('middlename', this.form.middlename);
        formData.append('phone', this.form.phone);
        formData.append('text', this.form.text);
        formData.append('file', this.form.file);
        formData.append('complaint_category_id', this.form.complaint_category_id);
        await this.actionSendContact(formData)
        if (this.getMassage.success){
          this.form.name = ''
          this.form.surname = ''
          this.form.middlename = ''
          this.form.phone = ''
          this.form.text = ''
          this.form.file = ''
          this.form.complaint_category_id = ''
          swal.fire({
            type: "success",
            icon: "success",
            title: "Сообщение",
            text: this.getMassage.message
          }); 
        }else{
          swal.fire({
            type: "error",
            icon: "error",
            title: "Ошибка",
            text: "Ошибка"
          });
        }
        this.requiredInput = false
      }else{
        this.requiredInput = true
      }
    }
  }
};
</script>
<style scoped>
  .pas_confirm_frame .input-group{
    margin-bottom: 0px;
  }
  .input-group.register_date .mx-datepicker .mx-input-wrapper .mx-icon-calendar, .mx-icon-clear {
    color: #acf1c1 !important;
  }
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>