<template>
  <div class="add_area">
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-route"></i>
          Добавить направление
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/direction">
          <span class="peIcon pe-7s-back"></span> Назад
        </router-link>
      </div>
      <div class="card-body">
        <form @submit.prevent.enter="saveDirection" enctype="multipart/form-data">
          <div class="row">
            <div class="form-group col-md-3">
              <label for="type_id">Type direction</label>
              <select
                class="form-control input_style"
                v-model="form.type_id"
                :class="isRequired(form.type_id) ? 'isRequired' : ''"
              >
                <option value selected disabled>choose option</option>
                <option
                  :value="item.id"
                  v-for="(item,index) in getTypeofdirectionList"
                >{{item.name }} {{item.type}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Passport number</label>
              <input
                type="number"
                v-model="form.pass_number"
                class="form-control input_style"
                :class="isRequired(form.pass_number) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Region from</label>
              <select
                class="form-control input_style"
                v-model="form.region_from.region_id"
                :class="isRequired(form.region_from.region_id) ? 'isRequired' : ''"
                @change="selectRegion('region_from')"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Area from</label>
              <select
                class="form-control input_style"
                v-model="form.region_from.area_id"
                :class="isRequired(form.region_from.area_id) ? 'isRequired' : ''"
                placeholder="Area"
                @change="selectArea('region_from')"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in areaFrom">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Station from</label>
              <select
                class="form-control input_style"
                v-model="form.region_from.station_id"
                :class="isRequired(form.region_from.station_id) ? 'isRequired' : ''"
                placeholder="Area"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in stationFrom">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Region to</label>
              <select
                class="form-control input_style"
                v-model="form.region_to.region_id"
                :class="isRequired(form.region_to.region_id) ? 'isRequired' : ''"
                @change="selectRegion('region_to')"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Area to</label>
              <select
                class="form-control input_style"
                v-model="form.region_to.area_id"
                :class="isRequired(form.region_to.area_id) ? 'isRequired' : ''"
                placeholder="Area"
                @change="selectArea('region_to')"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in areaTo">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Station to</label>
              <select
                class="form-control input_style"
                v-model="form.region_to.station_id"
                :class="isRequired(form.region_to.station_id) ? 'isRequired' : ''"
                placeholder="Area"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in stationTo">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="seasonal">Seasonal</label>
              <select
                class="form-control input_style"
                v-model="form.seasonal"
                :class="isRequired(form.seasonal) ? 'isRequired' : ''"
                placeholder="Area"
              >
                <option value selected disabled>choose option</option>
                <option value="always">Always</option>
                <option value="seasonal">Seasonal</option>
              </select>
            </div>
            <div class="form-group col-md-3" v-for="(item,index) in destinations">
              <label :for="'from_where'+index">{{item.name}}</label>
              <input
                type="radio"
                v-model="form.from_where"
                name="from_where"
                :id="'from_where'+index"
                :value="item.id"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="seria">direction Year</label>
              <date-picker
                lang="ru" 
                type="year"
                v-model="form.year" 
                valueType="format" 
                class="input_style"
                :class="isRequired(form.year) ? 'isRequired' : ''"
                format="YYYY"
              ></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">direction distance</label>
              <input
                type="number"
                v-model="form.distance"
                class="form-control input_style"
                :class="isRequired(form.distance) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-lg-3 form_btn d-flex justify-content-end">
              <button type="submit" class="btn btn-primary btn_save_category">
                <i class="fas fa-save"></i>
                Сохранить
              </button>
            </div>
          </div>
        </form>
        <PassportTab />
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import PassportTab from "../steppassport/PassportTab";
import { mapGetters, mapActions } from "vuex";
import "vue2-datepicker/index.css";
export default {
  components: {
    DatePicker,
    PassportTab
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
      areaFrom: [],
      areaTo: [],
      stationFrom: [],
      stationTo: [],
      requiredInput: false,
    };
  },
  async mounted() {
    await this.actionRegionList();
    await this.actionTypeofdirectionList();
    await this.actionEditDirection(this.$route.params.directionId);
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
    this.form.type_id = this.getDirection.type_id;
    this.areaFrom = this.getDirection.region_from_with.area;
    this.areaTo = this.getDirection.region_to_with.area;
    this.stationFrom = this.getDirection.area_from_with.station;
    this.stationTo = this.getDirection.area_to_with.station;
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
    ...mapActions("direction", ["actionEditDirection"]),
    isRequired(input) {
      return this.requiredInput && input === "";
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
            title: "error whoops",
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
  },
  computed: {
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
    ...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("direction", ["getDirection"]),
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