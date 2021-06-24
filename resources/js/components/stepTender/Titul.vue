<template>
  <div class="add_area">
    <Loader v-if="laoding" />
    <PassportTab />
    <div class="card-body container">
      <div class="row">
        <div class="form-group col-lg-3 col-md-6">
          <label for="type_id">{{ $t("Yoʼnalish klasifikatsiyasi") }} </label>
          <div class="form-control input_style">
            {{ item.type ? item.type.name : "" }}
            {{ item.type ? item.type.type : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="seria">{{ $t("Passport raqami") }} </label>
          <div class="form-control input_style">
            {{ item.pass_number }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="region_id">{{ $t("Shaxardan, viloyatdan") }}</label>
          <div class="form-control input_style">
            {{ item.region_from_with ? item.region_from_with.name : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="region_id">{{
            $t("Tumandan, qishloqdan, shaxridan")
          }}</label>
          <div class="form-control input_style">
            {{ item.area_from_with ? item.area_from_with.name : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="region_id">{{ $t("Bekatdan") }}</label>
          <div class="form-control input_style">
            {{ item.station_from ? item.station_from.name : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="region_id">{{ $t("Shaxarga, viloyatga") }}</label>
          <div class="form-control input_style">
            {{ item.region_to_with ? item.region_to_with.name : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="region_id"
            >{{ $t("Tumanga, qishloqga, shaxriga") }}
          </label>
          <div class="form-control input_style">
            {{ item.area_to_with ? item.area_to_with.name : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="region_id">{{ $t("Bakatga") }}</label>
          <div class="form-control input_style">
            {{ item.station_to ? item.station_to.name : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="seasonal">{{ $t("Ishlash mavsumi") }}</label>
          <div class="form-control input_style">
            {{ item.seasonal }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label>{{ $t("Qaysi tarafdan") }}</label>
          <div class="form-control input_style">
            {{ item.from_where ? item.from_where.name : "" }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="seria">{{ $t("Yoʼnalish ochilish sanasi") }}</label>
          <div class="form-control input_style">
            {{ item.year }}
          </div>
        </div>
        <div class="form-group col-lg-3 col-md-6">
          <label for="seria">{{ $t("Yoʼnalish masofasi") }}</label>
          <div class="form-control input_style">
            {{ item.distance }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Timing from "./Timing";
import Scheme from "./Scheme";
import Schedule from "./Schedule";
import PassportTab from "./PassportTab";
import Tarif from "./Tarif";
import { mapGetters, mapActions } from "vuex";
import "vue2-datepicker/index.css";
import Loader from "../Loader";
export default {
  components: {
    DatePicker,
    Timing,
    Scheme,
    Tarif,
    PassportTab,
    Schedule,
    Loader,
  },
  data() {
    return {
      loaded: false,
      laoding: true,
      item: {},
    };
  },
  async mounted() {
    await this.actionDirection(this.$route.params.directionId);
    console.log(this.getDirection)
    this.item = this.getDirection
    this.laoding = false;
  },
  methods: {
    ...mapActions("front", ["actionDirection"]),
  },
  computed: {
    ...mapGetters("front", ["getDirection"]),
  },
};
</script>
<style scoped>
</style>
