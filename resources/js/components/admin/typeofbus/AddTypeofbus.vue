<template>
  <div class="add_region">
    <Loader v-if="laoding" />
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-bus"></i>
          Добавить тип автобуса
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/typeofbus"
          ><span class="peIcon pe-7s-back"></span> Назад</router-link
        >
      </div>
      <div class="card-body">
        <form @submit.prevent.enter="saveType">
          <div class="row">
            <div class="form-group col-md-4">
              <label for="name">Название</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                placeholder="Название"
                v-model="form.name"
                :class="isRequired(form.name) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-lg-4">
              <label for="stay_from">Комментарии </label>
              <textarea
                type="number"
                class="form-control input_style"
                id="stay_from"
                placeholder="Комментарии"
                v-model="form.desc"
                :class="isRequired(form.desc) ? 'isRequired' : ''"
              ></textarea>
            </div>
            <div class="form-group col-lg-3 d-flex justify-content-end saveBtn">
              <button type="submit" class="btn btn-primary btn_save_category">
                <i class="fas fa-save"></i>
                Сохранить
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import Loader from "../../Loader";
export default {
  components: {
    Loader,
  },
  data() {
    return {
      form: {
        name: "",
        desc: "",
      },
      requiredInput: false,
      laoding: true,
    };
  },
  computed: {
    ...mapGetters("typeofbus", ["getMassage"]),
  },
  mounted() {
    this.laoding = false;
  },
  methods: {
    ...mapActions("typeofbus", ["actionAddTypeofbus"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async saveType() {
      if (this.form.name != "" && this.form.desc != "") {
        this.laoding = true;
        await this.actionAddTypeofbus(this.form);
        this.laoding = false;
        if (this.getMassage.success) {
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getMassage.message,
          });
          this.$router.push("/crm/typeofbus");
          this.requiredInput = false;
        }
      } else {
        this.requiredInput = true;
      }
    },
  },
};
</script>
<style scoped>
.saveBtn {
  margin-top: 30px;
}
</style>
