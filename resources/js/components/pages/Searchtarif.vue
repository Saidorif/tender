<template>
  <div class="about_page">
    <Loader v-if="laoding" />
    <Header />
    <div class="container about_block">
      <div class="col-md-12">
        <h2 align="center" class="title">
          <span>{{ $t('Yoʼnalish') }} </span> {{ $t('tarifni bilish') }}
        </h2>
        <div class="input-group input_group_with_label">
          <input
            type="text"
            id="number"
            class="form-control"
            v-model="form.number"
          />
          <label for="number"> {{ $t('Marshrut raqami') }}</label>
          <button @click="checkAuto()" class="btn_login ml-2">
            <i class="fas fa-search"></i> {{ $t('Qidirish') }}
          </button>
        </div>
        <div class="alert alert-danger" v-if="errorText">{{ errorText }}</div>
        <div
          class="table-responsive"
          v-if="getGetTarifByNumber.length"
          v-for="(t_item, t_index) in getGetTarifByNumber"
        >
          <div class="d-flex align-items-center w-50 justify-content-between">
            <h4>{{ t_index + 1 }})</h4>
            <div class="">
              {{ $t('Miqdor') }} : <b>{{ t_item.tarif.summa }}</b>
            </div>
            <div class="">
              {{ $t('Bagaj miqdori') }}: <b>{{ t_item.tarif.summa_bagaj }}</b>
            </div>
            <div class="">
              {{ $t('Tarif sanasi') }}: <b>{{ t_item.tarif.created_at }}</b>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>№ т/р</th>
                <th>{{ $t('Boshlangʼich va oraliq oxirgi bekatlar nomi') }}</th>
                <template
                  :colspan="statinsName.length"
                  v-for="(item) in statinsName"
                >
                  <th>
                    {{ item }}
                  </th>
                </template>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(items, index) in t_item.items">
                <td>{{ index + 1 }}</td>
                <td>
                  {{ items[index].from_name ? items[index].from_name : "" }}
                </td>
                <template v-for="(item, key) in items">
                  <td
                    v-if="item.tarif"
                    :class="
                      key == items.length - 1 && index == 0
                        ? 'alert-danger'
                        : ''
                    "
                  >
                    <div class="tarifs tarif">
                      <b>{{ item.tarif }}</b>
                    </div>
                    <div class="tarifs tarif_bagaj">
                      <b>{{ item.tarif_bagaj }}</b>
                    </div>
                    <div class="tarifs tarif_bagaj">
                      <b>{{ item.distance_test }}{{$t("km")}}</b>
                    </div>
                  </td>
                  <template v-else>
                    <td class="has_no_name_tarif" v-if="key != 'ddd'"></td>
                  </template>
                </template>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import Header from "./Header";
import Loader from "../Loader";
export default {
  components: {
    Header,
    Loader,
  },
  data() {
    return {
      laoding: true,
      form: {
        number: "",
      },
      statinsName:[],
      errorText: null,
    };
  },
  computed: {
    ...mapGetters("page", ["getMassage", "getGetTarifByNumber"]),
  },
  async mounted() {
    this.laoding = false;
  },
  methods: {
    ...mapActions("page", ["actionGetTarifByNumber"]),
    async checkAuto() {
      if (this.form.number != "") {
          this.laoding = false;
        await this.actionGetTarifByNumber(this.form);
        this.laoding = true;
        if (this.getGetTarifByNumber == undefined) {
          this.errorText = this.$t("Yoʼnalish topiladi");
        } else {
          this.errorText = null;
          this.statinsName = [];
          this.getGetTarifByNumber.forEach((item)=>{
              item.items[0].forEach((elem, ind)=>{
                  this.statinsName.push(elem.to_name)
              })
          })
        }
      }
    },
    getStatusClass(status) {
      if (status == "pending") {
        return "alert-warning";
      } else {
        return "alert-primary";
      }
    },
    getStatusName(status) {
      if (status == "pending") {
        return this.$t('Kutish jarayonida');
      } else if (status == "approved") {
        return this.$t('Tasdiqlagan');
      } else {
        return status;
      }
    },
  },
};
</script>
<style scoped>
</style>
