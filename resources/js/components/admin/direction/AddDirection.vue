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
                <option :value="item.id" v-for="(item,index) in getTypeofdirectionList">{{item.name }} {{item.type}}</option>
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
              <label for="region_id">Regions</label>
              <select
                class="form-control input_style"
                v-model="form.region_id"
                :class="isRequired(form.region_id) ? 'isRequired' : ''"
                @change="selectRegion()"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Area</label>
              <select
                class="form-control input_style"
                v-model="form.area_id"
                :class="isRequired(form.area_id) ? 'isRequired' : ''"
                placeholder="Area"
                @change="selectArea()"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Station</label>
              <!-- <select 
					    	class="form-control input_style" 
					    	v-model="form.station_id" 
					    	:class="isRequired(form.station_id) ? 'isRequired' : ''"  
							placeholder="Area"
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getStationList">{{item.name}}</option>
              </select>-->
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
        region_id: "",
        area_id: "",
        station_id: "",
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
	...mapGetters('typeofdirection',['getTypeofdirectionList'])
  },
  async mounted() {
    await this.actionRegionList();
	await this.actionTypeofdirectionList();
	console.log(this.getTypeofdirectionList)
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
	...mapActions("area", ["actionAreaByRegion"]),
	...mapActions('typeofdirection',['actionTypeofdirectionList']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    saveDirection() {
      if (
        this.form.region_from_id != "" &&
        this.form.region_to_id != "" &&
        this.form.seria != "" &&
        this.form.number != ""
      ) {
        this.requiredInput = false;
      } else {
        this.requiredInput = true;
      }
    },
    async selectRegion() {
      await this.actionAreaByRegion({ region_id: this.form.region_id });
    },
    async selectArea() {
      await this.actionAreaByRegion({
        region_id: this.form.region_id,
        area_id: this.form.area_id,
      });
    },
  },
};
</script>
<style scoped>
</style>