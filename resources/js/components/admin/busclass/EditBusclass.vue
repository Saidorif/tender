<template>
  <div class="add_region">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-bus-alt"></i>
          {{$t('Avtobus toifasi tahrirlash')}}
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/busclass">
          <span class="peIcon pe-7s-back"></span>
          {{$t('Orqaga')}}
        </router-link>
      </div>
      <div class="card-body">
        <form @submit.prevent.enter="saveType">
          <div class="row">
            <div class="form-group col-md-4">
              <label for="bustype_id">{{$t('Avtobus toifasi')}}</label>
              <select
                class="form-control input_style"
                v-model="form.bustype_id"
                :class="isRequired(form.bustype_id) ? 'isRequired' : ''"
              >
                <option value="" selected disabled>
                  {{$t('Avtobus toifasi tanlang')}}!
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
              <label for="name">{{$t('Avtomobil sinfi nomi')}}</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                v-model="form.name"
                :class="isRequired(form.name) ? 'isRequired' : ''"
              />
            </div>
            <div
              class="form-group col-lg-2 form_btn d-flex justify-content-end"
            >
              <button type="submit" class="btn btn-primary btn_save_category">
                <i class="fas fa-save"></i>
                {{$t('Saqlash')}}
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
import Loader from '../../Loader'
export default {
    components:{
        Loader
    },
  data() {
    return {
      form: {
        name: "",
        bustype_id: "",
      },
      requiredInput: false,
      laoding: true,
    };
  },
  computed: {
    ...mapGetters("typeofbus", ["getMassage", "getTypeofbusList"]),
    ...mapGetters("busclass", ["getMassage", "getBusclass"]),
    ...mapGetters("busmodel", ["getBusmodelList"]),
    ...mapGetters("busbrand", ["getBusBrandList"]),
  },
  async mounted() {
    await this.actionTypeofbusList();
    await this.actionEditBusclass(this.$route.params.busclassId);
    this.form = this.getBusclass;
    this.laoding = false
  },
  methods: {
    ...mapActions("typeofbus", [
      "actionTypeofbusList",
      "actionDeleteTypeofbus",
    ]),
    ...mapActions("busclass", ["actionUpdateBusclass", "actionEditBusclass"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async saveType() {
      if (
        this.form.name != "" &&
        this.form.seat_from != "" &&
        this.form.stay_from != "" &&
        this.form.bustype_id != "" &&
        this.form.busmodel_id != ""
      ) {
        this.laoding = true
        await this.actionUpdateBusclass(this.form);
        this.laoding = false
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
    async selectBrandBus(){
        this.laoding = true
        await this.actionBusmodelListByBrand({busmarka_id:this.form.busmarka_id});
        this.laoding = false
    }
  },
};
</script>
<style scoped>
.saveBtn {
  margin-top: 30px;
}
</style>
