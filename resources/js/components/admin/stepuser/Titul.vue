<template>
	<div class="add_area">
    <Loader v-if="laoding"/>
	    <div class="card card_with_tabs">
	  		<div class="card-header tabCard">
	        	<PassportTab/>
	  		</div>
	  		<div class="card-body">
				<form>
          <div class="row">
            <div class="form-group col-md-3">
              <label for="type_id">Yo'nalish klasifikatsiyasi</label>
              <div class="form-control input_style">
                {{item.type ? item.type.name : ''}}
                {{item.type ? item.type.type : ''}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Passport raqami</label>
              <div class="form-control input_style">
                {{form.pass_number}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Shaxardan, viloyatdan</label>
              <div class="form-control input_style">
                {{item.region_from_with ? item.region_from_with.name : ''}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Tumandan, qishloqdan, shaxridan</label>
              <div class="form-control input_style">
                {{item.area_from_with ? item.area_from_with.name : ''}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Bekatdan</label>
              <div class="form-control input_style">
                {{item.station_from ? item.station_from.name : ''}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Shaxarga, viloyatga</label>
              <div class="form-control input_style">
                {{item.region_to_with ? item.region_to_with.name : ''}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Tumanga, qishloqga, shaxriga,</label>
              <div class="form-control input_style">
                {{item.area_to_with ? item.area_to_with.name : ''}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Bakatga</label>
              <div class="form-control input_style">
                {{item.station_to ? item.station_to.name : ''}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="seasonal">Ishlash mavsumi</label>
              <div class="form-control input_style">
                {{getSeasonal(form.seasonal)}}
              </div>
            </div>
            <div class="col-md-3 input_radios_block">
              <p>Qaysi tarafdan</p>
              <div class="form-group input_radio_with_label" v-for="(item,index) in destinations">
                <input
                  type="radio"
                  v-model="form.from_where"
                  name="from_where"
                  :id="'from_where'+index"
                  :value="item"
                  disabled
                />
                <label :for="'from_where'+index">{{item.name}}</label>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Yo'nalish ochilish sanasi</label>
              <div class="form-control input_style">
                {{form.year}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Yonalish masofasi</label>
              <div class="form-control input_style">
                {{form.distance}}
              </div>
            </div>
          </div>
        </form>
      </div>
		</div>
	</div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Timing from "../stepuser/Timing";
import Scheme from "../stepuser/Scheme";
import Schedule from "../stepuser/Schedule";
import PassportTab from "../stepuser/PassportTab";
import Tarif from "../stepuser/Tarif";
import { mapGetters, mapActions } from "vuex";
import "vue2-datepicker/index.css";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Timing,
    Scheme,
    Tarif,
    PassportTab,
    Schedule,
    Loader
  },
  data() {
    return {
      form: {
        pass_number: "",
        region_from: {
          region_id: "",
          area_id: "",
          station_id: "",
        },
        region_to: {
          region_id: "",
          area_id: "",
          station_id: "",
        },
        year: "",
        from_where: "",
        seasonal: "",
        distance: "",
        type_id: "",
      },
      item:{},
      areaFrom: [],
      areaTo: [],
      stationFrom: [],
      stationTo: [],
      requiredInput: false,
      loaded: false,
      laoding: true
    };
  },
  async mounted() {
    await this.actionRegionList();
    await this.actionTypeofdirectionList();
    await this.actionEditDirection(this.$route.params.directionId);
    this.item = this.getDirection
    this.laoding = false
    this.form.pass_number = this.getDirection.pass_number;
    this.form.region_from.region_id = this.getDirection.region_from_id;
    this.form.region_from.area_id = this.getDirection.area_from_id;
    this.form.region_from.station_id = this.getDirection.station_from_id;
    this.form.region_to.region_id = this.getDirection.region_to_id;
    this.form.region_to.area_id = this.getDirection.area_to_id;
    this.form.region_to.station_id = this.getDirection.station_to_id;
    this.form.year = this.getDirection.year.toString();
    this.form.from_where = this.getDirection.from_where;
    this.form.seasonal = this.getDirection.seasonal;
    this.form.distance = this.getDirection.distance;
    this.areaFrom = this.getDirection.region_from_with.area;
    this.areaTo = this.getDirection.region_to_with.area;
    this.stationFrom =  this.getDirection.area_from_with ? this.getDirection.area_from_with.station : '';
    this.stationTo = this.getDirection.area_to_with ? this.getDirection.area_to_with.station : '';
    this.loaded = true
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ["actionTarif"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async sendDirection(){
      await this.actionEditDirection(this.$route.params.directionId);
    },
    async saveDirection() {
      if (
        this.form.pass_number != "" &&
        this.form.year != "" &&
        this.form.distance != "" &&
        this.form.type_id != "" &&
        this.form.region_from_id != "" &&
        this.form.area_from_id != "" &&
        this.form.station_from_id != "" &&
        this.form.region_to_id != "" &&
        this.form.area_to_id != "" &&
        this.form.station_to_id != "" &&
        this.form.from_where != "" &&
        this.form.seasonal != ""
      ) {
        await this.actionAddDirection(this.form);
        if (this.getMassage.success) {
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getMassage.message,
          });
          this.$router.push(`/crm/direction/${this.getMassage.id}`);
        } else {
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getMassage.message,
          });
        }
        this.requiredInput = false;
      } else {
        this.requiredInput = true;
      }
    },
    async selectRegion(input) {
      await this.actionAreaByRegion({ region_id: this.form[input].region_id });
      if (input == "region_from") {
        this.areaFrom = this.getAreaList;
        this.form.area_from_id = "";
      } else if (input == "region_to") {
        this.areaTo = this.getAreaList;
        this.form.area_to_id = "";
      }
    },
    async selectArea(input) {
      await this.actionStationByRegion({
        region_id: this.form[input].region_id,
        area_id: this.form[input].area_id,
      });
      if (input == "region_from") {
        this.stationFrom = this.getStationsList;
        this.form.station_from_id = "";
      } else if (input == "region_to") {
        this.stationTo = this.getStationsList;
        this.form.station_to_id = "";
      }
    },
    getSeasonal(item){
      if (item == 'always') {
        return 'Doimiy'
      }else{
        return 'Mavsumiy'
      }
    },
  },
  computed: {
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
    ...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ["getTarif"]),
    destinations() {
      let from = null;
      let to = null;
      let itemsFrom = [];
      let itemsTo = [];
      let arr = [null, null];
      if (this.form.region_from.region_id && this.form.region_to.region_id) {
        if (this.form.region_from.region_id == this.form.region_to.region_id) {
          // If region_from 'id' is equal to region_to 'id'
          if (this.form.region_from.area_id == this.form.region_to.area_id) {
            // FROM
            itemsFrom = this.form.region_from.station_id
              ? this.stationFrom
              : this.areaFrom;
            from = this.form.region_from.station_id
              ? this.form.region_from.station_id
              : this.form.region_from.area_id;
            itemsFrom.forEach((item) => {
              if (item.id == from) {
                arr[0] = item;
              }
            });
            // TO
            itemsTo = this.form.region_to.station_id
              ? this.stationTo
              : this.areaTo;
            to = this.form.region_to.station_id
              ? this.form.region_to.station_id
              : this.form.region_to.area_id;
            itemsTo.forEach((item) => {
              if (item.id == to) {
                arr[1] = item;
              }
            });
          } else {
            // FROM
            itemsFrom = this.form.region_from.area_id
              ? this.areaFrom
              : this.getRegionList;
            from = this.form.region_from.area_id
              ? this.form.region_from.area_id
              : this.form.region_from.region_id;
            itemsFrom.forEach((item) => {
              if (item.id == from) {
                arr[0] = item;
              }
            });
            // TO
            itemsTo = this.form.region_to.area_id
              ? this.areaTo
              : this.getRegionList;
            to = this.form.region_to.area_id
              ? this.form.region_to.area_id
              : this.form.region_to.region_id;
            itemsTo.forEach((item) => {
              if (item.id == to) {
                arr[1] = item;
              }
            });
          }
        } else {
          // FROM
          itemsFrom = this.form.region_from.area_id
            ? this.areaFrom
            : this.getRegionList;
          from = this.form.region_from.area_id
            ? this.form.region_from.area_id
            : this.form.region_from.region_id;
          itemsFrom.forEach((item) => {
            if (item.id == from) {
              arr[0] = item;
            }
          });
          // TO
          itemsTo = this.form.region_to.area_id
            ? this.areaTo
            : this.getRegionList;
          to = this.form.region_to.area_id
            ? this.form.region_to.area_id
            : this.form.region_to.region_id;
          itemsTo.forEach((item) => {
            if (item.id == to) {
              arr[1] = item;
            }
          });
        }
        return arr;
      }
    },
  },
};
</script>
<style scoped>

</style>
