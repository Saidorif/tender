<template>
  <div class="contacts_page">
    <Header/>
    <div class="container">
      <div class="contact_block">
        <div class="col-md-6">
          <h2 class="title">Bizga o'z <span>taklif</span> va <span>e'trozlaringizni </span> qoldiring!</h2>
          <p class="sub_title">Taklif va e'trozlaringizni formada qoldiring, biz sizning takliflarinigzni va e'trozlarinigzni o'rganib chiqib pochtangiz orqali batafsil ma'lumot beramiza yoki qo'ng'iroq qilamiz agar raqamingizni qoldirsangiz   </p>
        </div>
        <div class="col-md-5">
          <form @submit.enter.prevent="send">
            <div class="col-md-12">
                <div class="input-group input_group_with_label">
                  <select 
                    class="form-control input_style" 
                    v-model="form.complaint_category_id" 
                    :class="isRequired(form.complaint_category_id) ? 'isRequired' : ''" 
                    id="complaint_category_id" 
                  >
                    <option :value="item.id" v-for="(item,index) in getComplaintList">{{item.name}}</option>
                  </select>
                  <label for="complaint_category_id">Murojat turi</label>
                </div>
                <div class="input-group input_group_with_label">
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.surname"
                    :class="isRequired(form.surname) ? 'isRequired' : ''"
                    id="surname"
                  />
                  <label for="surname">Familiya</label>
                </div>
                <div class="input-group input_group_with_label">
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="form.name"
                    :class="isRequired(form.name) ? 'isRequired' : ''"
                  />
                  <label for="name">Ism</label>
                </div>
                <div class="input-group input_group_with_label"> 
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.middlename"
                    id="middlename"
                  />
                  <label for="middlename">Sharifi</label>
                </div>
                <div class="input-group input_group_with_label">
                  <input
                    type="text"
                    v-mask="'(99)999-99-99'"
                    class="form-control"
                    id="phone"
                    v-model="form.phone"
                    :class="isRequired(form.phone) ? 'isRequired' : ''"
                  />
                  <label for="phone">Telefon raqam</label>
                </div>
                <div class="input-group input_group_with_label input_file">
                  <input
                    type="file"
                    id="file"
                    class="form-control"
                    @change="changeFile($event)"
                  />
                  <p>{{ form.file ? form.file.name : ''}}</p>
                  <label for="file">Faylni yuklash</label>
                </div>
                <div class="input-group input_group_with_label">
                  <textarea
                    class="form-control"
                    id="text"
                    v-model="form.text"
                    :class="isRequired(form.text) ? 'isRequired' : ''"
                  ></textarea>
                  <label for="text">Xabar matni</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group mt-4">
                  <button type="submit" class="btn_blue_bd_0">Yuborish</button>
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
import Header from './Header'
import { TokenService } from "./../../services/storage.service";
export default {
  components: {
    DatePicker,
    Multiselect,
    Header,
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
      filename:'',
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
        console.log(this.form.file)
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