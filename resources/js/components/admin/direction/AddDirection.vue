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
              <label for="region_id">Type direction</label>
              <select
                class="form-control input_style"
                v-model="form.type"
                :class="isRequired(form.type) ? 'isRequired' : ''"
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
                <option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
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
                <option :value="item.id" v-for="(item,index) in getStationsList">{{item.name}}</option>
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
                <option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
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
                <option :value="item.id" v-for="(item,index) in getStationsList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">direction Year</label>
              <input
                type="number"
                v-model="form.year"
                class="form-control input_style"
                :class="isRequired(form.year) ? 'isRequired' : ''"
              />
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
            <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
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
        distance: "",
        type: "",
      },

      requiredInput: false,
    };
  },
  computed: {
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
    ...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("direction", ["getMassage"]),
  },
  async mounted() {
    await this.actionRegionList();
    await this.actionTypeofdirectionList();
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
    ...mapActions("direction", ["actionAddDirection"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async saveDirection() {
      if (
        this.form.pass_number != "" &&
        this.form.year != "" &&
        this.form.distance != "" &&
        this.form.type != ""  &&
        this.form.region_from.region_id != ""  &&
        this.form.region_from.area_id != ""  &&
        this.form.region_from.station_id != ""  &&
        this.form.region_to.region_id != ""  &&
        this.form.region_to.area_id != ""  &&
        this.form.region_to.station_id != "" 
      ) {
		await this.actionAddDirection(this.form)
		if(this.getMassage.success){
			toast.fire({
				type: "success",
				icon: "success",
				title: this.getMassage.message
			 });
			this.$router.push("/crm/direction");
		}else{
			toast.fire({
				type: "error",
				icon: "error",
				title: 'error whoops'
			 });
		}
        this.requiredInput = false;
      } else {
        this.requiredInput = true;
      }
    },
    async selectRegion(input) {
      await this.actionAreaByRegion({ region_id: this.form[input].region_id });
    },
    async selectArea(input) {
      await this.actionStationByRegion({
        region_id: this.form[input].region_id,
        area_id: this.form[input].area_id,
      });
    },
  },
};
</script>
<style scoped>
</style>