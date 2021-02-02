<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
    <div class="card card_with_tabs">
      <div class="card-header">
          <h4 class="title_user">
            <i class="peIcon fas fa-clipboard-check"></i>
            Подтвердить хронометраж
          </h4>
          <router-link class="btn btn-primary back_btn" to="/crm/confirm-timing">
            <span class="peIcon pe-7s-back"></span>
            Назад
          </router-link>
        </div>
      <div class="card-body">
        <form class="row tabRow">
          <h2>{{getShowTiming.name}} bo'yicha boshlang'ich ma'lumot  </h2>
          <div class="col-md-12 tabs_block">
            <div class="form-group col-md-3">
              <label for="timingDetails_date">O'chov otkazilgan kun</label>
              <date-picker lang="ru" class="input_style" v-model="timingDetails.date" type="date" format="DD-MM-YYYY" valueType="format" :class="isRequired(timingDetails.date) ? 'isRequired' : ''" ></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label for="avto_model">Xronametraj otqizilgan avtomabil rusumi</label>
              <input
                type="text"
                v-model="timingDetails.avto_model"
                id="avto_model"
                class="form-control input_style"
                :class="isRequired(timingDetails.avto_model) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="avto_number">Xronametraj otqizilgan avtomabil davlat raqami</label>
              <input
                type="text"
                v-model="timingDetails.avto_number"
                id="avto_number"
                class="form-control input_style"
                :class="isRequired(timingDetails.avto_number) ? 'isRequired' : ''"
              />
            </div>
            <h4 class="col-md-12">Xronametraj otkazgan shaxslar</h4>
            <template v-for="(person,p_index) in timingDetails.persons">
              <div class="form-group col-md-2">
                <label for="person_name">Ism</label>
                <input type="text" v-model="person.name"  class="form-control input_style" :class="isRequired(person.name) ? 'isRequired' : ''" />
              </div>
              <div class="form-group col-md-2">
                <label for="surname">Familyasi</label>
                <input type="text" v-model="person.surname"  class="form-control input_style" :class="isRequired(person.surname) ? 'isRequired' : ''" />
              </div>
              <div class="form-group col-md-3">
                <label for="person_job">Ish joyi</label>
                <input type="text" v-model="person.job" id="person_job" class="form-control input_style" :class="isRequired(person.job) ? 'isRequired' : ''" />
              </div>
              <div class="form-group col-md-3">
                <label for="person_position">Lavozimi</label>
                <input
                  type="text"
                  v-model="person.position"
                  id="person_position"
                  class="form-control input_style"
                  :class="isRequired(person.position) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-md-1"></div>
            </template>
          </div>
          <h2>Asosiy ma'lumotlar</h2>
          <div class="col-md-12 tabs_block">
            <div class="form-group col-md-6" >
              <label for="start_speedometer">Бошланғич манзил номи </label>
              <input
                type="text"
                v-model="form.whereForm.name"
                id="start_speedometer"
                class="form-control input_style"
                disabled
              />
            </div>
            <div class="form-group col-md-6" >
              <label for="start_speedometer">Jonash vaqtida (km)  Бошланғич спидометр кўрсаткичи </label>
              <input
                type="number"
                v-model="form.start_speedometer"
                id="start_speedometer"
                class="form-control input_style"
                :class="isRequiredTwo(form.start_speedometer) ? 'isRequired' : ''"
                step="0.01"
                :disabled="tableTwoData.length > 0"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="start_time">Boshlash vaqti Бошлаш вақти </label>
              <date-picker
                lang="ru"
                class="input_style"
                v-model="form.start_time"
                :type="getShowTiming.type_id == 5 ? 'datetime' : 'time'"
                placeholder="Select datetime"
                :class="isRequiredTwo(form.start_time) ? 'isRequired' : ''"
                format="HH:mm:ss"
              ></date-picker>
            </div>
            <div class="form-group col-md-6">
              <label for="speed_between_station">Bekatlar oraligidagi xarakat (km/soat)</label>
              <input
                type="number"
                v-model="form.speed_between_station"
                id="speed_between_station"
                class="form-control input_style"
                :class="isRequiredTwo(form.speed_between_station) ? 'isRequired' : ''"
                step="0.01"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="speed_between_limited_space">Shundan xarakat tezligi chegaralangan oraliqda (km/soat)</label>
              <input
                type="number"
                v-model="form.speed_between_limited_space"
                id="speed_between_limited_space"
                class="form-control input_style"
                :class="isRequiredTwo(form.speed_between_limited_space) ? 'isRequired' : ''"
                step="0.01"
              />
            </div>
            <div class="form-group col-md-6 triple_input" v-for="(detail,p_index) in form.details">
              <label>Qatnov yoli xaqidagi malumotlar</label>
              <select class="form-control input_style" v-model="detail.sign" @change="signSelect(detail)" >
                <option
                  v-for="(s_item,s_index) in form.detailsOptions"
                  :value="s_item"
                  :key="s_index"
                >{{s_item.name}}</option>
              </select>
              <input type="text" v-model="detail.count"  class="form-control input_style"  />
            </div>
            <div class="form-group col-md-6">
              <label for="whereToregion_to_id" :class="isRequiredTwo(form.whereTo) ? 'isRequired' : ''">Oraliq toxtash viloyat nomi</label>
              <input
                v-model="form.whereTo"
                type="radio"
                name="where_to"
                :value="form.region_to_id"
                id="whereToregion_to_id"
              />
              <select
                class="form-control input_style"
                v-model="form.region_to_id"
                @change="selectRegion('region_to_id')"
                :class="isRequiredTwo(form.region_to_id) ? 'isRequired' : ''"
              >
                <option value selected disabled>choose option</option>
                <option
                  :value="s_item"
                  v-for="(s_item,s_index) in getRegionList"
                  :key="s_index"
                >{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-6" v-if="form.region_to_id">
              <label for="whereToarea_to_id" :class="isRequiredTwo(form.whereTo) ? 'isRequired' : ''">Oraliq toxtash tuman nomi</label>
              <input v-model="form.whereTo" type="radio" name="where_to" :value="form.area_to_id"  id="whereToarea_to_id"                 />
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
            <div class="form-group col-md-6" v-if="form.area_to_id">
              <input v-model="form.whereTo" type="radio" name="where_to" :value="form.station_to_id"     id="wherestation_to_id"            />
              <label for="wherestation_to_id" :class="isRequired(form.whereTo) ? 'isRequired' : ''">Oraliq toxtash bekat nomi</label>
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
                type="number"
                v-model="form.end_speedometer"
                id="end_speedometer"
                class="form-control input_style"
                :class="isRequiredTwo(form.end_speedometer) ? 'isRequired' : ''"
                step="0.01"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="seria"> Тўхтаганда вақт кўрсаткичи </label>
              <date-picker
                lang="ru"
                class="input_style"
                v-model="form.end_time"
                :type="getShowTiming.type_id == 5 ? 'datetime' : 'time'"
                placeholder="Select end_time"
                :class="isRequiredTwo(form.end_time) ? 'isRequired' : ''"
                format="HH:mm:ss"
              ></date-picker>
            </div>
            <div class="form-group col-md-6">
              <label for="distance_in_limited_speed">Shundan xarakat tezligi chegaralangan oraliqda (km)</label>
              <input
                type="number"
                v-model="form.distance_in_limited_speed"
                id="distance_in_limited_speed"
                class="form-control input_style"
                :class="isRequiredTwo(form.distance_in_limited_speed) ? 'isRequired' : ''"
                step="0.01"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="spendtime_between_limited_space">Shundan xarakat tezligi chegaralangan oraliqda (minut)</label>
              <input
                type="text"
                v-model="form.spendtime_between_limited_space"
                id="spendtime_between_limited_space"
                class="form-control input_style"
                :class="isRequiredTwo(form.spendtime_between_limited_space) ? 'isRequired' : ''"
              />
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="row">
              <div class="form-group col-md-3">
                  <label for="conclusion">Xulosa</label>
                  <select name="conclusion" id="conclusion" v-model="timingDetails.conclusion" :class="isRequired(timingDetails.conclusion) ? 'isRequired' : ''" class="form-control input_style">
                      <option value="Talablarga javob beradi">Talablarga javob beradi</option>
                      <option value="Talablarga javob bermaydi">Talablarga javob bermaydi</option>
                  </select>
              </div>
              <div class="form-group col-md-9 form_btn d-flex justify-content-end">
                <button type="button" class="btn btn-danger btn_save_category mr-3" @click.prevent="rejectTitul">
                  <i class="fas fa-times"></i>
                  Отказать
                </button>
                <button type="button" class="btn btn-success btn_save_category" @click.prevent="sendToActivate">
                  <i class="fas fa-check"></i>
                  Подтвердить
                </button>
              </div>
            </div>
          </div>
          <div class="table-responsive" v-if="tableTwoData.length">
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
                  <th rowspan="2">Taxrirlash</th>
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
                <tr v-for="(table,index) in tableTwoData">
                  <td scope="row">{{index+1}}</td>
                  <td>{{ table.whereForm ? table.whereForm.name  : '' }} {{ table.whereTo ? table.whereTo.name  : '' }}</td>
                  <td>{{ table.start_speedometer }}</td>
                  <td>{{ table.end_speedometer }}</td>
                  <td>{{ table.distance_from_start_station }}</td>
                  <td>{{ table.distance_between_station }}</td>
                  <td>{{ table.distance_in_limited_speed }} </td>
                  <td>{{ table.spendtime_between_station }} </td>
                  <td>{{ table.spendtime_between_limited_space }}</td>
                  <td>{{ table.spendtime_to_stay_station }} </td>
                  <td>{{ table.speed_between_station }}</td>
                  <td>{{ table.speed_between_limited_space }}</td>
                  <td class="detail_td">
                    <span v-for="(detail) in table.details">
                      {{detail.sign ? detail.sign.name : '' }} {{detail.count}}
                      <b>,</b>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td colspan="7" scope="row">Ortacha tezlik = {{technic_speed}} km/soat</td>
                  <td colspan="1" scope="row">{{total_spendtime_between_station}}</td>
                  <td colspan="1" scope="row"></td>
                  <td colspan="1" scope="row">{{total_spendtime_to_stay_station}}</td>
                  <td colspan="5" scope="row">Qatnov tezlik = {{traffic_speed}} km/soat</td>
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
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Loader
  },
  data() {
    return {
        titulData:[],
        form: {
            direction_id: this.$route.params.confirmtimingId,
            region_from_id: '',
            region_to_id: "",
            area_from_id:  '',
            area_to_id: "",
            station_from_id: '',
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
            whereForm: '',
            whereTo: '',
            detailsOptions: [],
        },
        timingDetails: {
            date: "",
            avto_number: "",
            avto_model: "",
            conclusion: "",
            persons: [
            { name: "", surname: '',  job: "", position: "" },
            { name: "", surname: '',  job: "", position: "" },
            { name: "", surname: '',  job: "", position: "" }
            ],
        },
        tableTwoData: [],
        requiredInput: false,
        requiredInputTwo: false,
        technic_speed: 0,
        traffic_speed: 0,
        total_spendtime_between_station: 0,
        total_spendtime_to_stay_station: 0,
        laoding: true,
        fullTableInfo: [],
        errorInput: true,
    };
  },
  async mounted() {
    await this.actionTimingShow(this.$route.params.confirmtimingId);
    await this.actionRegionList();
    await this.actionConditionalSignList();
    this.form.detailsOptions = this.getConditionalSignList;
    this.laoding = false
    this.titulData = this.getShowTiming
    this.timingDetails = this.titulData.timing_details.length ? this.titulData.timing_details[0] : this.timingDetails
    if(this.titulData.timing_with.length){
        this.fullTableInfo = JSON.parse(this.titulData.timing_with[0].vars)
        this.calcTableData();
        this.calctechnic_speed();
    }else{
        this.form.region_from_id = this.titulData.region_from_with;
        this.form.area_from_id = this.titulData.area_from_with;
        this.form.station_from_id = this.titulData.station_from_id;
        this.form.whereForm = this.titulData.from_where;
    }
  },
  computed: {
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("conditionalsign", ["getConditionalSignList"]),
    ...mapGetters("area", ["getAreaList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("passportTab", ["getTimingMassage"]),
    ...mapGetters("confirmtiming", ["getShowTiming","getTimingMassage"]),
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("conditionalsign", ["actionConditionalSignList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("confirmtiming", ["actionTimingShow","actionActivateTiming","actionRejectTiming"]),
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable"]),
    async rejectTitul(){
      if(confirm("Вы действительно хотите отказатся?")){
        await this.actionRejectTiming(this.$route.params.confirmtimingId)
        if (this.getTimingMassage.success){
          await this.actionTimingShow(this.$route.params.confirmtimingId);
          this.$router.push('/crm/confirm-timing')
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getTimingMassage.message,
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getTimingMassage.message,
          });
        }
      }
    },
    async sendToActivate(){
      await this.actionActivateTiming(this.$route.params.confirmtimingId)
      if (this.getTimingMassage.success){
        await this.actionTimingShow(this.$route.params.confirmtimingId);
        this.$router.push('/crm/confirm-timing')
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getTimingMassage.message,
        });
      }else{
        toast.fire({
          type: "error",
          icon: "error",
          title: this.getTimingMassage.message,
        });
      }
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    isRequiredTwo(input) {
      return this.requiredInputTwo && input === "";
    },
    async selectArea(this_select, parent_select) {
      this.laoding = true
      await this.actionStationByRegion({
        region_id: this.form[parent_select].id,
        area_id: this.form[this_select].id,
      });
      this.laoding = false
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
    calctechnic_speed(){
        let calc_technic_speed = 0
        let calc_traffic_speed = 0
        let calc_spendtime_between_station = 0
        let calc_spendtime_to_stay_station = 0
        this.tableTwoData.forEach((item)=>{
            calc_technic_speed += parseFloat(item.spendtime_between_station)
            calc_traffic_speed += parseFloat(item.spendtime_to_stay_station)
            calc_spendtime_between_station += parseFloat(item.spendtime_between_station)
            calc_spendtime_to_stay_station += parseFloat(item.spendtime_to_stay_station)
        })
        this.technic_speed =  (this.tableTwoData[this.tableTwoData.length - 1].distance_from_start_station * 60) /  calc_technic_speed
        this.traffic_speed =  (this.tableTwoData[this.tableTwoData.length - 1].distance_from_start_station * 60) /  (calc_technic_speed + calc_traffic_speed)
        this.technic_speed = parseFloat(this.technic_speed).toFixed(1)
        this.traffic_speed = parseFloat(this.traffic_speed).toFixed(1)
        this.total_spendtime_between_station = calc_spendtime_between_station
        this.total_spendtime_to_stay_station = calc_spendtime_to_stay_station
    },
    signSelect(detail){
        detail.name = detail.sign.id
    },
    calcTableData(){
        let dataTable = this.fullTableInfo
        this.tableTwoData = [];
        dataTable.forEach((element, index)=>{
            if(index == 0){
                element.distance_from_start_station = parseFloat(
                    element.end_speedometer - element.start_speedometer
                ).toFixed(1);
            }else{
                element.distance_from_start_station = parseFloat(
                    element.end_speedometer - this.tableTwoData[0].start_speedometer
                ).toFixed(1);
                let result_spendtime_to_stay_station =
                    (this.toTimestamp(element.start_time) -
                    this.toTimestamp(
                        this.tableTwoData[this.tableTwoData.length - 1].end_time
                    )) /
                    60;
                element.spendtime_between_station = parseFloat(
                    result_spendtime_to_stay_station
                ).toFixed(2);
                this.tableTwoData[
                    this.tableTwoData.length - 1
                ].spendtime_to_stay_station = result_spendtime_to_stay_station;
            } //else
            element.distance_between_station = parseFloat(
            element.end_speedometer - element.start_speedometer
            ).toFixed(1);
            let result_spendtime_between_station =
            (this.toTimestamp(element.end_time) -
                this.toTimestamp(element.start_time)) /
            60;
            element.spendtime_between_station = parseFloat(
            result_spendtime_between_station
            ).toFixed(2);
            this.tableTwoData.push(element);
        })
        let thisData;
        thisData = {
            direction_id: this.$route.params.confirmtimingId,
            region_from_id: this.fullTableInfo[this.fullTableInfo.length - 1].region_to_id,
            region_to_id: "",
            area_from_id: this.fullTableInfo[this.fullTableInfo.length - 1].area_to_id,
            area_to_id: "",
            station_from_id: this.fullTableInfo[this.fullTableInfo.length - 1].station_to_id,
            station_to_id: "",
            start_time: "",
            end_time: "",
            start_speedometer: this.fullTableInfo[this.fullTableInfo.length - 1].end_speedometer,
            end_speedometer: "",
            distance_from_start_station: this.fullTableInfo.length == 1 ? parseFloat(this.fullTableInfo[this.fullTableInfo.length - 1].end_speedometer - this.fullTableInfo[this.fullTableInfo.length - 1].start_speedometer).toFixed(1) : parseFloat(this.form.end_speedometer - this.tableTwoData[0].start_speedometer).toFixed(1),
            distance_between_station: this.fullTableInfo.length > 1 ? this.form.end_speedometer - this.form.start_speedometer : '', //d
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
            whereForm: this.fullTableInfo[this.fullTableInfo.length - 1].whereTo,
            whereTo: "",
            detailsOptions: this.getConditionalSignList,
        };
        this.form = thisData;
    },
    toTimestamp(strDate) {
      var datum = Date.parse(strDate);
      return datum / 1000;
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
  width: 58%;
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
