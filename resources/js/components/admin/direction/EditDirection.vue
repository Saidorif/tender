<template>
  <div class="add_area">
    <div class="card">
      <div class="card-header tabCard">
        <!-- <h4 class="title_user">
          <i class="peIcon fas fa-route"></i>
          Добавить направление
        </h4> -->
        <ul class="nav nav-tabs " id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="titul-tab" data-toggle="tab" href="#titul" role="tab" aria-controls="titul" aria-selected="false">Titul</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link " id="timing-tab" data-toggle="tab" href="#timing" role="tab" aria-controls="timing" aria-selected="true">Xronametraj</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sxema</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li>
        </ul>
        <router-link class="btn btn-primary back_btn" to="/crm/direction">
          <span class="peIcon pe-7s-back"></span> Назад
        </router-link>
      </div>
      <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="titul" role="tabpanel" aria-labelledby="titul-tab">
              <form @submit.prevent.enter="saveDirection" enctype="multipart/form-data">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="type_id">Yo'nalish klasifikatsiyasi</label>
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
                    <label for="seria">Passport raqami</label>
                    <input
                      type="number"
                      v-model="form.pass_number"
                      class="form-control input_style"
                      :class="isRequired(form.pass_number) ? 'isRequired' : ''"
                    />
                  </div>
                  <div class="form-group col-md-3">
                    <label for="region_id">Shaxardan, viloyatdan</label>
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
                    <label for="region_id">Tumandan, qishloqdan, shaxridan</label>
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
                    <label for="region_id">Bekatdan</label>
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
                    <label for="region_id">Shaxarga, viloyatga</label>
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
                    <label for="region_id">Tumanga, qishloqga, shaxriga,</label>
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
                    <label for="region_id">Bakatga</label>
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
                    <label for="seasonal">Ishlash mavsumi</label>
                    <select
                      class="form-control input_style"
                      v-model="form.seasonal"
                      :class="isRequired(form.seasonal) ? 'isRequired' : ''"
                      placeholder="Area"
                    >
                      <option value selected disabled>choose option</option>
                      <option value="always">Doimiy</option>
                      <option value="seasonal">Mavsumiy</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3" v-for="(item,index) in destinations">
                    <label :for="'from_where'+index">{{item.name}}</label>
                    <input
                      type="radio"
                      v-model="form.from_where"
                      name="from_where"
                      :id="'from_where'+index"
                      :value="item"
                      class="form-control input_style"
                    />
                  </div>
                  <div class="form-group col-md-3">
                    <label for="seria">Yo'nalish ochilish sanasi</label>
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
                    <label for="seria">Yonalish masofasi</label>
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
            </div>
            <div class="tab-pane fade " id="timing" role="tabpanel" aria-labelledby="home-tab">
                <Timing v-if="loaded" :titulData="this.getDirection" />
            </div>
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <Scheme v-if="loaded" :titulData="this.getDirection" />
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Timing from "../steppassport/Timing";
import Scheme from "../steppassport/Scheme";
import { mapGetters, mapActions } from "vuex";
import "vue2-datepicker/index.css";
export default {
  components: {
    DatePicker,
    Timing,
    Scheme
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
      loaded: false,
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
.tabCard{
  padding: 0 15px;
}
.tabCard .nav.nav-tabs{
  border: none;
}
.tabCard .back_btn{
  margin-bottom: 10px;
  margin-top: 10px;
}
.tabCard .nav-link {
  padding: .9rem 1rem;
}
</style>