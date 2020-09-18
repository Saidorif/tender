<template>
  <div class="card lognCard">
    <div class="card-body login-card-body">
      <div class="form_content auth_request">
        <div class="d-flex justify-content-center">
          <h3><b>Отправить жалобу!</b></h3>
        </div>
          <form @submit.enter.prevent="send">
            <div class="col-md-12">
<!--               <div class="input-group">
                <multiselect 
                :value="form.direction_id"
                :options="getComplaintList"
                @search-change="value => filterVariantList(value)"
                v-model="form.complaint_category_id" 
                placeholder="Найдите направление!"
                :searchable="true"
                track-by="id"
                label="name"
                :max="3"
                class="form-control"
                :loading="isLoading"
                selectLabel="Нажмите Enter, чтобы выбрать"
                deselectLabel="Нажмите Enter, чтобы удалить"
                :option="[{name: '', id: 1}]"
                @select="dispatchAction"
                >
                <span slot="noResult">По вашему запросу ничего не найдено</span>
                <span slot="noOptions">Cписок пустой</span>
                </multiselect>
              </div> -->
         <!--      <div class="input-group">
                <select 
                  class="form-control" 
                  v-model="form.complaint_category_id" 
                  :class="isRequired(form.complaint_category_id) ? 'isRequired' : ''"  
                >
                  <option value="" selected disabled>Выберите вариант жалобы!</option>
                  <option :value="item.id" v-for="(item,index) in getComplaintList">{{item.name}}</option>
                </select>
              </div> -->
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.surname"
                  placeholder="Фамилия"
                  :class="isRequired(form.surname) ? 'isRequired' : ''"
                />
                <div class="input-group-append">
                  <div
                    class="input-group-text"
                    :class="isRequired(form.surname) ? 'isRequired' : ''"
                  >
                    <img src="/img/user.png" alt=""/>
                  </div>
                </div>
              </div>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.name"
                  placeholder="Имя"
                  :class="isRequired(form.name) ? 'isRequired' : ''"
                />
                <div class="input-group-append">
                  <div
                    class="input-group-text"
                    :class="isRequired(form.name) ? 'isRequired' : ''"
                  >
                    <img src="/img/user.png" alt=""/>
                  </div>
                </div>
              </div>
              <div class="input-group"> 
                <input
                  type="text"
                  class="form-control"
                  v-model="form.middlename"
                  placeholder="Отчество"
                />
                <div class="input-group-append">
                  <div
                    class="input-group-text"
                  >
                    <img src="/img/user.png" alt=""/>
                  </div>
                </div>
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
                <div class="input-group-append">
                  <div
                    class="input-group-text"
                    :class="isRequired(form.phone) ? 'isRequired' : ''"
                  >
                    <img src="/img/phone.png" alt />
                  </div>
                </div>
              </div>
              <div class="input-group">
                <input
                  type="file"
                  id="file"
                  class="form-control"
                  @change="changeFile($event)"
                />
                <div class="input-group-append">
                  <div
                    class="input-group-text"
                  >
                    <img src="/img/docs.png" alt />
                  </div>
                </div>
              </div>
              <div class="input-group">
                <textarea
                  class="form-control"
                  v-model="form.text"
                  placeholder="Сообщение"
                  :class="isRequired(form.text) ? 'isRequired' : ''"
                /></textarea>
         <!--        <div class="input-group-append">
                  <div
                    class="input-group-text"
                    :class="isRequired(form.text) ? 'isRequired' : ''"
                  >
                    <img src="/img/file.png" alt />
                  </div>
                </div> -->
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
        // complaint_category_id: '',
      },
      requiredInput: false,
      isLoading:false,
    };
  },
  computed: {
    ...mapGetters('complaint',['getComplaintList','getMassage'])
  },
  mounted() {
    // await this.actionComplaintList();
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
    async send() {
      if (this.form.name && this.form.surname &&  this.form.phone &&  this.form.text) {
        let formData = new FormData();
        formData.append('items', this.form);
        await this.actionSendContact(formData)
        if (this.getMassage.success) {
          swal.fire({
            type: "success",
            icon: "success",
            title: "Сообщение",
            text: "Вам на почту отправлен доступ!"
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