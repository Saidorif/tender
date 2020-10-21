<template>
  <div class="add_region">
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-bus-alt"></i>
          Добавить тип автобуса
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/busclass">
          <span class="peIcon pe-7s-back"></span>
          Назад
        </router-link>
      </div>
      <div class="card-body">
        <form @submit.prevent.enter="saveType">
          <div class="row">
            <div class="form-group col-md-4">
              <label for="bustype_id">Тип автобуса</label>
              <select
                class="form-control input_style"
                v-model="form.bustype_id"
                :class="isRequired(form.bustype_id) ? 'isRequired' : ''"
              >
                <option value="" selected disabled>
                  Выберите тип автобус!
                </option>
                <option
                  :value="item.id"
                  v-for="(item, index) in getTypeofbusList"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="name">Название класса</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                placeholder="Название класса"
                v-model="form.name"
                :class="isRequired(form.name) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-4">
              <label for="busmodel_id">Марка автобуса</label>
              <select
                class="form-control input_style"
                v-model="form.busbrand_id"
                :class="isRequired(form.busbrand_id) ? 'isRequired' : ''"
              >
                <option value="" selected disabled>
                  Выберите тип автобус!
                </option>
                <option
                  :value="item.id"
                  v-for="(item, index) in getBusBrandList"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="busmodel_id">Модель автобуса</label>
              <select
                class="form-control input_style"
                v-model="form.busmodel_id"
                :class="isRequired(form.busmodel_id) ? 'isRequired' : ''"
              >
                <option value="" selected disabled>
                  Выберите тип автобус!
                </option>
                <option
                  :value="item.id"
                  v-for="(item, index) in getBusmodelList"
                >
                  {{ item.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="seat_from">Количество сидящих</label>
              <input
                type="number"
                class="form-control input_style"
                id="seat_from"
                placeholder="Количество сидящих"
                v-model="form.seat_from"
                :class="isRequired(form.seat_from) ? 'isRequired' : ''"
              />
            </div>
            <!-- 			  <div class="form-group col-md-4">
					    <label for="seat_to">Количество сидящих (по)</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="seat_to"
					    	placeholder="Количество сидящих (по)"
					    	v-model="form.seat_to"
					    	:class="isRequired(form.seat_to) ? 'isRequired' : ''"
				    	>
					  </div> -->
            <div class="form-group col-md-4">
              <label for="stay_from">Пассажировместимость </label>
              <input
                type="number"
                class="form-control input_style"
                id="stay_from"
                placeholder="Пассажировместимость"
                v-model="form.stay_from"
                :class="isRequired(form.stay_from) ? 'isRequired' : ''"
              />
            </div>
            <!-- 		  <div class="form-group col-md-4">
					    <label for="stay_to">Пассажировместимость (по)</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="stay_to"
					    	placeholder="Пассажировместимость (по)"
					    	v-model="form.stay_to"
					    	:class="isRequired(form.stay_to) ? 'isRequired' : ''"
				    	>
					  </div> -->
            <div class="form-group col-lg-10">
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
            <div
              class="form-group col-lg-2 form_btn d-flex justify-content-end"
            >
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
export default {
  data() {
    return {
      form: {
        name: "",
        seat_from: "",
        seat_to: "",
        stay_from: "",
        stay_to: "",
        bustype_id: "",
        busmodel_id: "",
        busbrand_id: "",
        desc: "",
      },
      requiredInput: false,
    };
  },
  computed: {
    ...mapGetters("typeofbus", ["getMassage", "getTypeofbusList"]),
    ...mapGetters("busclass", ["getMassage"]),
    ...mapGetters("busmodel", ["getBusmodelList"]),
    ...mapGetters("busbrand", ["getBusBrandList"]),
  },
  async mounted() {
    await this.actionTypeofbusList();
    await this.actionBusmodelList();
    await this.actionBusBrandList();
  },
  methods: {
    ...mapActions("typeofbus", [
      "actionTypeofbusList",
      "actionDeleteTypeofbus",
    ]),
    ...mapActions("busclass", ["actionAddBusclass"]),
    ...mapActions("busmodel", ["actionBusmodelList"]),
    ...mapActions("busbrand", ["actionBusBrandList"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async saveType() {
      if (
        this.form.name != "" &&
        this.form.desc != "" &&
        this.form.seat_from != "" &&
        this.form.stay_from != "" &&
        this.form.bustype_id != "" &&
        this.form.busbrand_id != "" &&
        this.form.busmodel_id != ""
      ) {
        await this.actionAddBusclass(this.form);
        if (this.getMassage.success) {
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getMassage.message,
          });
          this.$router.push("/crm/busclass");
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
