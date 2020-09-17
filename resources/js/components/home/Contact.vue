<template>
  <div class="card lognCard">
    <div class="card-body login-card-body">
      <div class="form_content auth_request">
          <form @submit.enter.prevent="send">
            <div class="col-md-12">
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
                  :class="isRequired(form.middlename) ? 'isRequired' : ''"
                />
                <div class="input-group-append">
                  <div
                    class="input-group-text"
                    :class="isRequired(form.middlename) ? 'isRequired' : ''"
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
import { TokenService } from "./../../services/storage.service";
export default {
  components: {
    DatePicker,
  },
  data() {
    return {
      form: {
        name: "",
        surname: "",
        middlename: "",
        phone: '',
      },
      requiredInput: false,
      checkPassword: false,
    };
  },
  computed: {
    ...mapGetters('complaint',['getComplaintList','getMassage'])
  },
  async mounted() {
    await this.actionComplaintList();
    console.log(this.getComplaintList)
  },
  methods: {
    ...mapActions('complaint',['actionComplaintList','actionDeleteComplaint']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async send() {
      
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