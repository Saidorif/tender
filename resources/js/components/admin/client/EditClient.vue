<template>
  <div class="add_employee">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i  class="peIcon pe-7s-users"></i></i>Добавить перевозчик
        </h3>
        <router-link class="btn btn-primary back_btn" to="/crm/client">
          <span class="peIcon pe-7s-back"></span> Назад
        </router-link>
      </div>
      <form role="form" @submit.prevent.enter="sendEmployee" enctype="multipart/form-data">
        <div class="card-body d-flex flex-wrap">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Ф.И.О</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                :class="isRequired(form.name) ? 'isRequired' : ''"
                placeholder="Ф.И.О"
                v-model="form.name"
              />
            </div>
            <div class="form-group">
              <label for="address">Адрес</label>
              <input
                type="text"
                class="form-control input_style"
                id="address"
                placeholder="Адрес.."
                v-model="form.address"
                :class="isRequired(form.address) ? 'isRequired' : ''"
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="phone">Телефон</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="Телефон"
                  placeholder="Phone.."
                  v-model="form.phone"
                  :class="isRequired(form.phone) ? 'isRequired' : ''"
                />
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Сохранить
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapActions, mapGetters } from "vuex";
export default {
  components: {
    DatePicker
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        address: "",
        phone: "",
      },
      requiredInput: false,
      checkPassword: false,
      emailError: false
    };
  },
  async mounted() {
    await this.actionRoleList();
    await this.actionPositionList();
  },
  computed: {
    ...mapGetters("client", ["getMassage"]),
  },
  methods: {
    ...mapActions("client", ["actionAddEmployee", "actionCheckEmail"]),
    confirmPassword() {
      if (this.form.password && this.form.confirm_password) {
        if (this.form.password != this.form.confirm_password) {
          this.checkPassword = true;
        } else {
          this.checkPassword = false;
        }
      }
    },
    isRequired(input) {
      if (input != null) {
        return this.requiredInput && input === "";
      }
    },
    async checkEmailInput() {
      await this.actionCheckEmail({ email: this.form.email });
      if (
        this.getMassage.error &&
        this.getMassage.message.email == "Почта уже занята."
      ) {
        this.emailError = true;
      } else {
        this.emailError = false;
      }
    },
  }
};
</script>
<style scoped>
</style>