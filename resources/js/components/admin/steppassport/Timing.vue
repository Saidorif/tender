<template>
  <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
    <div class="col-md-12 tabs_block">
      <div class="form-group col-md-2" v-if="tableData.length == 0">
        <label for="region_from_id">Region from</label>
        <input v-model="form.whereForm"  type="radio" name="where_from"  value="region_from_id">
        <select
          class="form-control input_style"
          v-model="form.region_from_id"
          @change="selectRegion('region_from_id')"
        >
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in getRegionList"
            :key="s_index"
          >{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-2" v-if="tableData.length == 0">
        <label for="area_from_id">Area from</label>
        <input v-model="form.whereForm"  type="radio" name="where_from"  value="area_from_id">
        <select
          class="form-control input_style"
          v-model="form.area_from_id"
          placeholder="Area"
          @change="selectArea('area_from_id', 'region_from_id')"
        >
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in form.areaFrom"
            :key="s_index"
          >{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-2" v-if="tableData.length == 0">
        <label for="station_from_id">Station from</label>
        <input v-model="form.whereForm"  type="radio" name="where_from"  value="station_from_id">
        <select class="form-control input_style" v-model="form.station_from_id">
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in form.stationFrom"
            :key="s_index">{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="region_to_id">Region to</label>
        <input v-model="form.whereTo"  type="radio" name="where_to"  value="region_to_id">
        <select
          class="form-control input_style"
          v-model="form.region_to_id"
          @change="selectRegion('region_to_id')"
        >
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in getRegionList"
            :key="s_index">{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="area_to_id">Area to</label>
        <input v-model="form.whereTo"  type="radio" name="where_to"  value="area_to_id">
        <select
          class="form-control input_style"
          v-model="form.area_to_id"
          placeholder="Area"
          @change="selectArea('area_to_id', 'region_to_id')"
        >
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in form.areaTo"
            :key="s_index"
          >{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <input v-model="form.whereTo"  type="radio" name="where_to"  value="station_to_id">
        <label for="station_to_id">Station to</label>
        <select class="form-control input_style" v-model="form.station_to_id">
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in form.stationTo"
            :key="s_index"
          >{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="start_time">start_time</label>
        <date-picker
          lang="ru"
          class="input_style"
          v-model="form.start_time"
          type="datetime"
          placeholder="Select datetime"
        ></date-picker>
      </div>
      <div class="form-group col-md-2">
        <label for="seria">end_time</label>
        <date-picker
          lang="ru"
          class="input_style"
          v-model="form.end_time"
          type="datetime"
          placeholder="Select end_time"
        ></date-picker>
      </div>
      <div class="form-group col-md-2" v-if="tableData.length == 0">
        <label for="start_speedometer">Jonash vaqtida</label>
        <input
          type="text"
          v-model="form.start_speedometer"
          id="start_speedometer"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-2">
        <label for="end_speedometer">Kelgan vaqtida</label>
        <input
          type="text"
          v-model="form.end_speedometer"
          id="end_speedometer"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-2">
        <label for="distance_in_limited_speed">Shundan xarakat tezligi chegaralangan oraliqda</label>
        <input
          type="text"
          v-model="form.distance_in_limited_speed"
          id="distance_in_limited_speed"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-2">
        <label for="spendtime_between_limited_space">Shundan xarakat tezligi chegaralangan oraliqda</label>
        <input
          type="text"
          v-model="form.spendtime_between_limited_space"
          id="spendtime_between_limited_space"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-2">
        <label for="speed_between_station">Bekatlar oraligidagi xarakat</label>
        <input
          type="text"
          v-model="form.speed_between_station"
          id="speed_between_station"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-2">
        <label for="speed_between_limited_space">Shundan xarakat tezligi chegaralangan oraliqda</label>
        <input
          type="text"
          v-model="form.speed_between_limited_space"
          id="speed_between_limited_space"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-4 double_input">
        <label for="details">Qatnov yoli xaqidagi malumotlar</label>
        <select class="form-control input_style">
          <option
            v-for="(s_item,s_index) in form.detailsOptions"
            :value="s_item" :key="s_index">{{s_item.name}}</option>
        </select>
        <input
          type="text"
          v-model="form.details"
          id="details"
          class="form-control input_style"
        />
      </div>
    </div>
    <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
      <button @click="addItem()" class="btn btn-info mr-2">
        <i class="fas fa-plus"></i>
        Добавить
      </button>
      <button type="submit" class="btn btn-primary btn_save_category">
        <i class="fas fa-save"></i>
        Сохранить
      </button>
    </div>
    <div class="table-responsive" v-if="tableData.length">
      <table class="table table-bordered text-center table-hover table-striped">
        <thead>
          <tr>
            <th scope="col" rowspan="2">№</th>
            <th scope="col" rowspan="2">Oraliq toxtash bekatlari</th>
            <th scope="col" colspan="2">Masofa ulagich ko'rsatkichlari</th>
            <th scope="col" colspan="3">Masofa (km)</th>
            <th scope="col" colspan="3">Sariflanadigon vaqt (minut)</th>
            <th scope="col" colspan="2">Ortacha texnik tezlik (km/soat)</th>
            <th rowspan="2">Qatnov yol xaqidagi malumotlar</th>
          </tr>
          <tr>
            <th>Jonash vaqtida</th>
            <th>Kelgan vaqtida</th>
            <th>Boshlangich bekatdan</th>
            <th>Bekatlar oraligida</th>
            <th>Shundan xarakat tezligi chegaralangan oraliqda</th>
            <th>Bekatlar oralig'idagi xarakat</th>
            <th>Shundan xarakat tezligi chegaralangan oraliqda</th>
            <th>Oraliq bekatda toxtash uchun</th>
            <th>Bekatlar oralig'idagi xarakat</th>
            <th>Shundan xarakat tezligi chegaralangan oraliqda</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(table,index) in tableData">
							<td scope="row">{{index+1}}</td>
							<td>{{ table[table.whereForm].name }} {{ table[table.whereTo].name }}</td>
							<td>{{ table.start_speedometer }}</td>
							<td>{{ table.end_speedometer }}</td>
							<td>{{ table.distance_from_start_station }}</td>
							<td>{{ table.distance_between_station }}</td>
							<td>{{ table.distance_in_limited_speed }}</td>
							<td>{{ table.spendtime_between_station }}</td>
							<td>{{ table.spendtime_between_limited_space }}</td>
							<td>{{ table.spendtime_to_stay_station }}</td>
							<td>{{ table.speed_between_station }}</td>
							<td>{{ table.speed_between_limited_space }}</td>
							<td>{{ table.details }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    DatePicker,
  },
  data() {
    return {
      form: {
        direction_id: this.$route.params.directionId,
        region_from_id: "",
        region_to_id: "",
        area_from_id: "",
        area_to_id: "",
        station_from_id: "",
        station_to_id: "",
        start_time: "",
        end_time: "",
        start_speedometer: "",//Jonash vaqtida
        end_speedometer: "",//Kelgan vaqtida
        distance_from_start_station: "",//Boshlangich bekatdan
        distance_between_station: "",//Bekatlar oraligida
        distance_in_limited_speed: "",//Shundan xarakat tezligi chegaralangan oraliqda
        spendtime_between_station: "",//Bekatlar oraligidagi xarakat
        spendtime_between_limited_space: "",//Shundan xarakat tezligi chegaralangan oraliqda
        spendtime_to_stay_station: "",//Oraliq bekatdan toxtash uchun
        speed_between_station: "",//Bekatlar oraligidagi xarakat
        speed_between_limited_space: "",//Shundan xarakat tezligi chegaralangan oraliqda
        details: "",//Qatnov yoli xaqidagi malumotlar
        areaFrom: [],
        stationFrom: [],
        stationTo: [],
        areaTo: [],
        whereForm: '',
        whereTo: '',
        detailsOptions: [
          {name: "ASF"},
          {name: "Koprik"},
          {name: "Koprik yol"},
          {name: "Temir yol"}
        ]
      },
      tableData: [],
      requiredInput: false,
    };
  },
  async mounted() {
    await this.actionRegionList();
  },
  computed: {
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("passportTab", ["getTimingMassage"]),
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("passportTab", ["actionAddTiming"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async selectArea(this_select, parent_select) {
      await this.actionStationByRegion({
        region_id: this.form[parent_select].id,
        area_id: this.form[this_select].id,
      });
      if (this_select == "area_from_id") {
        this.form.stationFrom = this.getStationsList;
      } else if (this_select == "area_to_id") {
        this.form.stationTo = this.getStationsList;
      }
    },
    async selectRegion(input) {
      await this.actionAreaByRegion({ region_id: this.form[input].id });
      if (input == "region_from_id") {
        this.form.areaFrom = this.getAreaList;
      } else if (input == "region_to_id") {
        this.form.areaTo = this.getAreaList;
      }
    },
    addItem() {

      if(
        this.form.region_from_id != "" &&
        this.form.region_to_id != "" &&
        this.form.area_from_id != "" &&
        this.form.area_to_id != "" &&
        this.form.station_from_id != "" &&
        this.form.station_to_id != "" &&
        this.form.start_time != "" &&
        this.form.end_time != "" &&
        // this.form.start_speedometer != "" &&
        // this.form.end_speedometer != "" &&
        // this.form.distance_in_limited_speed != "" &&
        // this.form.spendtime_between_station != "" &&
        this.form.spendtime_between_limited_space != "" &&
        // this.form.spendtime_to_stay_station != "" &&
        // this.form.speed_between_station != "" &&
        // this.form.speed_between_limited_space != "" &&
        // this.form.details != "" &&
        // this.form.whereForm != "" &&
        this.form.whereTo != "" 
      ){
        let thisData ={}
        if(this.tableData.length == 0){
          thisData = {
                direction_id: this.$route.params.directionId,
                region_from_id:  this.form.region_to_id ,
                region_to_id: "",
                area_from_id: this.form.area_to_id,
                area_to_id: "",
                station_from_id:   this.form.station_to_id,
                station_to_id: "",
                start_time: "",
                end_time: "",
                start_speedometer: this.form.end_speedometer,
                end_speedometer: "",
                distance_from_start_station: "",
                distance_between_station: "",
                distance_in_limited_speed: "",
                spendtime_between_station: "",
                spendtime_between_limited_space: "",
                spendtime_to_stay_station: 0,
                speed_between_station: "",
                speed_between_limited_space: "",
                details: "",
                areaFrom: [],
                stationFrom: [],
                stationTo: [],
                areaTo: [],
                whereForm:  this.form.whereTo.replace('to', 'from'),
                whereTo: "",
          };
          this.form.distance_from_start_station = parseFloat(this.form.end_speedometer - this.form.start_speedometer).toFixed(1)
        }else{
          thisData = {
            direction_id: this.$route.params.directionId,
            region_from_id:  this.form.region_to_id ,
            region_to_id: "",
            area_from_id: this.form.area_to_id,
            area_to_id: "",
            station_from_id:   this.form.station_to_id,
            station_to_id: "",
            start_time: "",
            end_time: "",
            start_speedometer: this.form.end_speedometer,
            end_speedometer: "",
            distance_from_start_station: "",
            distance_between_station: this.form.end_speedometer - this.form.start_speedometer,
            distance_in_limited_speed: "",
            spendtime_between_station: "",
            spendtime_between_limited_space: "",
            spendtime_to_stay_station: 0,
            speed_between_station: "",
            speed_between_limited_space: "",
            details: "",
            areaFrom: [],
            stationFrom: [],
            stationTo: [],
            areaTo: [],
            whereForm:  this.form.whereTo.replace('to', 'from'),
            whereTo: "",
          };
          this.form.distance_from_start_station = parseFloat(this.form.end_speedometer - this.tableData[0].start_speedometer).toFixed(1)
          let result_spendtime_to_stay_station = (this.toTimestamp(this.form.start_time) - this.toTimestamp(this.tableData[this.tableData.length - 1].end_time)) / 60
          this.form.spendtime_between_station = parseFloat(result_spendtime_to_stay_station).toFixed(0)
          this.tableData[this.tableData.length - 1].spendtime_to_stay_station = result_spendtime_to_stay_station
        }
        this.form.distance_between_station = parseFloat(this.form.end_speedometer - this.form.start_speedometer).toFixed(1)
        let result_spendtime_between_station = (this.toTimestamp(this.form.end_time) - this.toTimestamp(this.form.start_time)) / 60
        this.form.spendtime_between_station = parseFloat(result_spendtime_between_station).toFixed(0)

        this.tableData.push(this.form)
        this.form = thisData;
        this.requiredInput = false;
      } else {
        this.requiredInput = true;
      }
    },
    toTimestamp(strDate){
        var datum = Date.parse(strDate);
        return datum/1000;
    },
    async saveData() {
      await this.actionAddTiming({ timing: this.form });
    },
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
.double_input {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}
.double_input label {
  width: 100%;
}
.double_input select,
.double_input input {
  width: 49%;
}
.tabs_block {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  border-bottom: 1px solid #000;
  margin-bottom: 30px;
}
</style>