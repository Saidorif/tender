<template>
  <div class="contacts_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container">
      <div class="contact_block">
        <div class="col-lg-6">
          <h2 class="title" v-html="$t('contacts_page.title')"></h2>
          <p class="sub_title" > {{$t('contacts_page.sub_title')}} </p>
        </div>
        <div class="col-lg-5">
          <form @submit.enter.prevent="send">
            <div class="col-md-12">
                <div class="input-group input_group_with_label">
                  <select
                    class="form-control input_style"
                    v-model="form.category_id"
                    :class="isRequired(form.category_id) ? 'isRequired' : ''"
                    id="category_id"
                  >
                    <option :value="item.id" v-for="(item,index) in getComplaintList">{{item.name}}</option>
                  </select>
                  <label for="category_id">{{$t('contacts_page.appeal_type')}}</label>
                </div>
                <div class="input-group input_group_with_label">
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.surname"
                    :class="isRequired(form.surname) ? 'isRequired' : ''"
                    id="surname"
                  />
                  <label for="surname"> {{$t('contacts_page.surname')}}</label>
                </div>
                <div class="input-group input_group_with_label">
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="form.name"
                    :class="isRequired(form.name) ? 'isRequired' : ''"
                  />
                  <label for="name"> {{$t('contacts_page.name')}}</label>
                </div>
                <div class="input-group input_group_with_label">
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.middlename"
                    id="middlename"
                  />
                  <label for="middlename"> {{$t('contacts_page.middlename')}}</label>
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
                  <label for="phone"> {{$t('contacts_page.phone')}}</label>
                </div>
                <div class="input-group input_group_with_label input_file">
                  <input
                    type="file"
                    id="file"
                    class="form-control"
                    @change="changeFile($event)"
                  />
                  <p>{{ form.file ? form.file.name : ''}}</p>
                  <label for="file"> {{$t('contacts_page.file_upload')}}</label>
                </div>
                <div class="input-group input_group_with_label">
                  <textarea
                    class="form-control"
                    id="text"
                    v-model="form.text"
                    :class="isRequired(form.text) ? 'isRequired' : ''"
                  ></textarea>
                  <label for="text"> {{$t('contacts_page.text')}}</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group mt-4">
                  <button type="submit" class="btn_blue_bd_0"> {{$t('contacts_page.send')}}</button>
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
import Loader from '../Loader'
export default {
  components: {
    DatePicker,
    Multiselect,
    Header,
    Loader
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
        category_id: '',
      },
      requiredInput: false,
      isLoading:false,
      filename:'',
      laoding: true
    };
  },
  computed: {
    ...mapGetters('complaint',['getComplaintList','getMassage'])
  },
  async mounted() {
    await this.actionComplaintList();
    this.laoding = false
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
        formData.append('category_id', this.form.category_id);
        await this.actionSendContact(formData)
        if (this.getMassage.success){
          this.form.name = ''
          this.form.surname = ''
          this.form.middlename = ''
          this.form.phone = ''
          this.form.text = ''
          this.form.file = ''
          this.form.category_id = ''
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
