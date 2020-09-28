<template>
  <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
    <h2>Boshlangich ma'lumot</h2>
    <div class="col-md-12 tabs_block">
      <div class="form-group col-md-3">
        <label for="timingDetails_date">O'chov otkazilgan kun</label>
        <date-picker lang="ru" class="input_style" v-model="timingDetails.date" type="date" format="DD-MM-YYYY" valueType="format"></date-picker>
      </div>
      <div class="form-group col-md-3">
        <label for="avto_model">Xronametraj otqizilgan avtomabil rusumi</label>
        <input
          type="text"
          v-model="timingDetails.avto_model"
          id="avto_model"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-3">
        <label for="avto_number">Xronametraj otqizilgan avtomabil davlat raqami</label>
        <input
          type="text"
          v-model="timingDetails.avto_number"
          id="avto_number"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-3">
        <label for="conclusion">Xulosa</label>
        <select name="conclusion" id="conclusion" v-model="timingDetails.conclusion" class="form-control input_style">
          <option value="Talablarga javob beradi">Talablarga javob beradi</option>
          <option value="Talablarga javob bermaydi">Talablarga javob bermaydi</option>
        </select>
      </div>
      <h4 class="col-md-12">Xronametraj otkazgan shaxslar</h4>
      <template v-for="(person,p_index) in timingDetails.persons">
        <div class="form-group col-md-2">
          <label for="person_name">Ism</label>
          <input type="text" v-model="person.name"  class="form-control input_style" />
        </div>
        <div class="form-group col-md-2">
          <label for="surname">Familyasi</label>
          <input type="text" v-model="person.surname"  class="form-control input_style" />
        </div>
        <div class="form-group col-md-2">
          <label for="middlename">Sharifi</label>
          <input type="text" v-model="person.middlename"  class="form-control input_style" />
        </div>
        <div class="form-group col-md-2">
          <label for="person_job">Ish joyi</label>
          <input type="text" v-model="person.job" id="person_job" class="form-control input_style" />
        </div>
        <div class="form-group col-md-3">
          <label for="person_position">Lavozimi</label>
          <input
            type="text"
            v-model="person.position"
            id="person_position"
            class="form-control input_style"
          />
        </div>
        <div class="form-group col-md-1">
          <button @click="addPerson()"           type="button" class="btn btn-info mr-2"  v-if="timingDetails.persons.length == p_index  +1 ">
            <i class="fas fa-plus"></i>
          </button>
          <button @click="removePerson(p_index)" type="button" class="btn btn-danger" v-if="p_index > 2">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </template>
    </div>
    <h2>Asosiy ma'lumotlar</h2>
    <div class="col-md-12 tabs_block">
      <div class="form-group col-md-6" v-if="tableData.length == 0">
        <label for="start_speedometer">Jonash vaqtida (km)</label>
        <input
          type="text"
          v-model="form.start_speedometer"
          id="start_speedometer"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-6">
        <label for="start_time">Boshlash vaqti</label>
        <date-picker
          lang="ru"
          class="input_style"
          v-model="form.start_time"
          type="datetime"
          placeholder="Select datetime"
        ></date-picker>
      </div>
      <div class="form-group col-md-6">
        <label for="speed_between_station">Bekatlar oraligidagi xarakat (km/soat)</label>
        <input
          type="text"
          v-model="form.speed_between_station"
          id="speed_between_station"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-6">
        <label for="speed_between_limited_space">Shundan xarakat tezligi chegaralangan oraliqda (km/soat)</label>
        <input
          type="text"
          v-model="form.speed_between_limited_space"
          id="speed_between_limited_space"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-6 triple_input" v-for="(detail,p_index) in form.details">
        <label>Qatnov yoli xaqidagi malumotlar</label>
        <select class="form-control input_style" v-model="detail.name">
          <option
            v-for="(s_item,s_index) in form.detailsOptions"
            :value="s_item.code"
            :key="s_index"
          >{{s_item.title}}</option>
        </select>
        <input type="text" v-model="detail.count" class="form-control input_style" />
        <button
          @click="addDetail()"
          class="btn btn-info"
          v-if="form.details.length  == p_index + 1"
          type="button"
        >
          <i class="fas fa-plus"></i>
        </button>
        <button
          @click="removeDetail(p_index)"
          class="btn btn-danger"
          v-if="form.details.length  > p_index + 1"
          type="button"
        >
          <i class="fas fa-trash"></i>
        </button>
      </div>
      <div class="form-group col-md-6">
        <label for="region_to_id">Oraliq toxtash viloyat nomi</label>
        <input
          v-model="form.whereTo"
          type="radio"
          name="where_to"
          :value="form.region_to_id"
          checked
        />
        <select
          class="form-control input_style"
          v-model="form.region_to_id"
          @change="selectRegion('region_to_id')"
        >
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in getRegionList"
            :key="s_index"
          >{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="area_to_id">Oraliq toxtash tuman nomi</label>
        <input v-model="form.whereTo" type="radio" name="where_to" :value="form.area_to_id" />
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
      <div class="form-group col-md-6">
        <input v-model="form.whereTo" type="radio" name="where_to" :value="form.station_to_id" />
        <label for="station_to_id">Oraliq toxtash bekat nomi</label>
        <select class="form-control input_style" v-model="form.station_to_id">
          <option value selected disabled>choose option</option>
          <option
            :value="s_item"
            v-for="(s_item,s_index) in form.stationTo"
            :key="s_index"
          >{{s_item.name}}</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="end_speedometer">Kelgan vaqtida (km)</label>
        <input
          type="text"
          v-model="form.end_speedometer"
          id="end_speedometer"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-6">
        <label for="seria">end_time</label>
        <date-picker
          lang="ru"
          class="input_style"
          v-model="form.end_time"
          type="datetime"
          placeholder="Select end_time"
        ></date-picker>
      </div>
      <div class="form-group col-md-6">
        <label for="distance_in_limited_speed">Shundan xarakat tezligi chegaralangan oraliqda (km)</label>
        <input
          type="text"
          v-model="form.distance_in_limited_speed"
          id="distance_in_limited_speed"
          class="form-control input_style"
        />
      </div>
      <div class="form-group col-md-6">
        <label for="spendtime_between_limited_space">Shundan xarakat tezligi chegaralangan oraliqda (minut)</label>
        <input
          type="text"
          v-model="form.spendtime_between_limited_space"
          id="spendtime_between_limited_space"
          class="form-control input_style"
        />
      </div>
    </div>
    <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
      <button type="button" @click="clearTable()" class="btn btn-danger mr-2" v-if="tableData.length">
        <i class="fas fa-trash"></i>
        Очистить таблисту
      </button>
      <button type="button" @click="addItem()" class="btn btn-info mr-2">
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
            <td>{{ table.whereForm ? table.whereForm.name  : '' }} {{ table.whereTo ? table.whereTo.name  : '' }}</td>
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
            <td class="detail_td">
              <span v-for="(detail) in table.details">
                {{detail.name }} {{ detail.count}}
                <b>,</b>
              </span>
            </td>
          </tr>
          <tr>
            <td colspan="8" scope="row">Ortacha tezlik = {{technicSpeed}} km/soat</td>
            <td colspan="8" scope="row">Qatnov tezlik = {{technicSpeed}} km/soat</td>
          </tr>
        </tbody>
      </table>
      <div class="table_footer">
        <div class="col-md-6">
          <p>Qatnov yoli xarakat xafsizligiga:  {{timingDetails.conclusion}}</p>
          <p>Olchov otkazilgan kun:  {{timingDetails.date}} yil</p>
          <p>Xronametraj otkazilgan avtomobil rusumi va davlat raqami:  {{timingDetails.avto_model}}, {{timingDetails.avto_number}}</p>
        </div>
        <div class="col-md-4 right_item">
          <div>
            <p>Olchov <br> qatnashchilari <br>  imzolari:</p>
          </div>
          <div>
            <p  v-for="(person,index) in timingDetails.persons">{{person.name.charAt(0)}}.{{person.surname}}</p>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["titulData"],
  components: {
    DatePicker,
  },
  data() {
    return {
      form: {
        direction_id: this.$route.params.directionId,
        region_from_id: this.titulData.region_from_with,
        region_to_id: "",
        area_from_id:  this.titulData.area_from_with,
        area_to_id: "",
        station_from_id: this.titulData.station_from_id,
        station_to_id: "",
        start_time: "",
        end_time: "",
        start_speedometer: "", //Jonash vaqtida
        end_speedometer: "", //Kelgan vaqtida
        distance_from_start_station: "", //Boshlangich bekatdan
        distance_between_station: "", //Bekatlar oraligida
        distance_in_limited_speed: "", //Shundan xarakat tezligi chegaralangan oraliqda
        spendtime_between_station: "", //Bekatlar oraligidagi xarakat
        spendtime_between_limited_space: "", //Shundan xarakat tezligi chegaralangan oraliqda
        spendtime_to_stay_station: 0, //Oraliq bekatdan toxtash uchun
        speed_between_station: "", //Bekatlar oraligidagi xarakat
        speed_between_limited_space: "", //Shundan xarakat tezligi chegaralangan oraliqda
        details: [{ name: "", count: "" }], //Qatnov yoli xaqidagi malumotlar
        areaFrom: [],
        stationFrom: [],
        stationTo: [],
        areaTo: [],
        whereForm: this.titulData.from_where,
        whereTo: {},
        detailsOptions: [
          { title: "Xafli yo'l uchastkalari", code: 'danger'},
          { title: "Temir yol", code: 'railway' },
          { title: "kesishgan yol ustidan otkazilgan kondalang yollar", code: 'bridge'},
          { title: "dam olish joylari", code: 'rest'},
          { title: "ovqatlanish joylari", code: 'food'},
        ],
      },
      timingDetails: {
        date: "",
        avto_number: "",
        avto_model: "",
        conclusion: "",
        persons: [
          { name: "", surname: '', middlename: '', job: "", position: "" },
          { name: "", surname: '', middlename: '', job: "", position: "" },
          { name: "", surname: '', middlename: '', job: "", position: "" }
        ],
      },
      tableData: [],
      requiredInput: false,
      technicSpeed: 0,
    };
  },
  async mounted() {
    await this.actionRegionList();
    this.timingDetails = this.titulData.timing_details.length ? this.titulData.timing_details[0] : this.timingDetails
    this.tableData = this.titulData.timing_with.length ? this.titulData.timing_with : this.tableData
    if(this.tableData.length){
      this.tableData.forEach(item => {
        item.region_to_id = item.region_to
        item.region_from_id = item.region_from
        item.area_from_id = item.area_from
        item.area_to_id = item.area_to
        item.station_from_id = item.station_from
        item.station_to_id = item.station_to
      })
      this.form.start_speedometer = this.tableData[this.tableData.length - 1].end_speedometer
    }
  },
  computed: {
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("passportTab", ["getTimingMassage"]),
    ...mapGetters("direction", ["getDirection"]),
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable"]),
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
    calcTechnicSpeed(){
      let calcRes = 0
      this.tableData.forEach((item)=>{
        calcRes += item.spendtime_between_station 
      })
      this.technicSpeed = calcRes /  this.tableData.length
    },
    addItem() {
      if (
        this.form.region_to_id != "" &&
        this.form.start_time != "" &&
        this.form.end_time != "" &&
        this.form.spendtime_between_limited_space != "" &&
        this.form.whereTo != ""
      ) {
        let thisData = {};
        if (this.tableData.length == 0) {
          thisData = {
            direction_id: this.$route.params.directionId,
            region_from_id: this.form.region_to_id,
            region_to_id: "",
            area_from_id: this.form.area_to_id,
            area_to_id: "",
            station_from_id: this.form.station_to_id,
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
            details: [{ name: "", count: "" }],
            areaFrom: [],
            stationFrom: [],
            stationTo: [],
            areaTo: [],
            whereForm: this.form.whereTo,
            whereTo: "",
            detailsOptions: [
              { title: "ASF", code: 'road'},
              { title: "Koprik", code: 'bridge'},
              { title: "Temir yol", code: 'railway' },
            ],
          };
          this.form.distance_from_start_station = parseFloat(
            this.form.end_speedometer - this.form.start_speedometer
          ).toFixed(1);
        } else {
          thisData = {
            direction_id: this.$route.params.directionId,
            region_from_id: this.form.region_to_id,
            region_to_id: "",
            area_from_id: this.form.area_to_id,
            area_to_id: "",
            station_from_id: this.form.station_to_id,
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
            details: [{ name: "", count: "" }],
            areaFrom: [],
            stationFrom: [],
            stationTo: [],
            areaTo: [],
            whereForm: this.form.whereTo,
            whereTo: "",
            detailsOptions: [
              { title: "ASF", code: 'road'},
              { title: "Koprik", code: 'bridge'},
              { title: "Temir yol", code: 'railway' },
            ],
          };
          this.form.distance_from_start_station = parseFloat(
            this.form.end_speedometer - this.tableData[0].start_speedometer
          ).toFixed(1);
          let result_spendtime_to_stay_station =
            (this.toTimestamp(this.form.start_time) -
              this.toTimestamp(
                this.tableData[this.tableData.length - 1].end_time
              )) /
            60;
          this.form.spendtime_between_station = parseFloat(
            result_spendtime_to_stay_station
          ).toFixed(0);
          this.tableData[
            this.tableData.length - 1
          ].spendtime_to_stay_station = result_spendtime_to_stay_station;
        }
        this.form.distance_between_station = parseFloat(
          this.form.end_speedometer - this.form.start_speedometer
        ).toFixed(1);
        let result_spendtime_between_station =
          (this.toTimestamp(this.form.end_time) -
            this.toTimestamp(this.form.start_time)) /
          60;
        this.form.spendtime_between_station = parseFloat(
          result_spendtime_between_station
        ).toFixed(0);
        this.tableData.push(this.form);
        this.form = thisData;
        this.requiredInput = false;
      } else {
        this.requiredInput = true;
      }
    },
    addDetail() {
      this.form.details.push({ name: "", count: "" });
    },
    removeDetail(index) {
      this.form.details.splice(index, 1);
    },
    toTimestamp(strDate) {
      var datum = Date.parse(strDate);
      return datum / 1000;
    },
    async saveData() {
      await this.actionAddTiming({ timing: this.tableData, timingDetails: this.timingDetails });
      if(this.getTimingMassage.success){
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getTimingMassage.message
          });
      }
    },
    addPerson(){
      let thisDate = { name: "", surname: '', middlename: '', job: "", position: "" }
      this.timingDetails.persons.push(thisDate)
    },
    removePerson(index) {
      this.timingDetails.persons.splice(index, 1);
    },
    async clearTable(){
      window.swal.fire({
        title: 'Ishonchingiz komilmi?',
        text: "Siz buni qaytarib ololmaysiz!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Ha, uni o'chirib tashlang!",
        cancelButtonText: "Bekor qilish",
      }).then( async (result) => {
        if (result.value) {
          await this.clearTimingTable(this.$route.params.directionId);
          if(this.getTimingMassage.success){
            this.tableData = []
            window.swal.fire(
              "O'chirildi!",
              "Ma'lumotlaringiz o'chirildi."
            )
          }
        }
      })

    }
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
.triple_input label,
.double_input label {
  width: 100%;
}
.double_input select,
.double_input input {
  width: 49%;
}
.triple_input {
  display: flex;
  flex-wrap: wrap;
}
.triple_input select {
  width:30%;
  margin-right: 15px;
}
.triple_input input {
  width: 60%;
  margin-right: 15px;
}
.tabs_block {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  border-bottom: 1px solid #000;
  margin-bottom: 30px;
}
.detail_td span:last-child b {
  display: none;
}
.form-group {
  align-self: flex-end;
}
.table_footer{
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  width: 100%;
}
.table_footer .right_item{
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}
.table_footer p{
  font-weight: bold;
  font-size: 16px;
}
.table_btn{
  width: 30px;
  height: 30px;
  font-size: 10px;
  padding: 1px;
}
</style>