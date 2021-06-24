<template>
    <div class="add_area">
        <Loader v-if="laoding"/>
        <PassportTab/>
        <div class="card-body container">
            <div class="table-responsive" v-if="tableData.length">
                <table class="table table-bordered text-center table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2">№</th>
                        <th scope="col" rowspan="2">{{$t('Oraliq toʼxtash bekatlari')}}</th>
                        <th scope="col" colspan="2">{{$t('Masofa ulagich koʼrsatkichlari')}}</th>
                        <th scope="col" colspan="3">{{$t('Masofa (km)')}}</th>
                        <th scope="col" colspan="3">{{$t('Sariflanadigan vaqt (daqiqa)')}} </th>
                        <th scope="col" colspan="2">{{$t('Oʼrtacha texnik tezlik (km/soat)')}} </th>
                        <th rowspan="2">{{$t('Qatnov yoʼl xaqidagi maʼlumotlar')}} </th>
                    </tr>
                    <tr>
                        <th>{{$t('Joʼnash vaqtida')}}</th>
                        <th>{{$t('Kelgan vaqtida')}} </th>
                        <th>{{$t('Boshlangʼich bekatdan')}}</th>
                        <th>{{$t('Bekatlar oraligʼida')}}</th>
                        <th>{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}}</th>
                        <th>{{$t('Bekatlar oraligʼidagi xarakat')}} </th>
                        <th>{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}}</th>
                        <th>{{$t('Oraliq bekatda toʼxtash uchun')}}</th>
                        <th>{{$t('Bekatlar oraligʼidagi xarakat')}}</th>
                        <th>{{$t('Shundan xarakat tezligi chegaralangan oraliqda')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(table,index) in tableData">
                        <td scope="row">{{index+1}}</td>
                        <td>{{ table.whereForm ? table.whereForm.name  : '' }} {{ table.whereTo ? table.whereTo.name  : '' }}</td>
                        <td>{{ table.start_speedometer }}</td>
                        <td>{{ table.end_speedometer }}</td>
                        <td>{{ table.distance_from_start_station }} </td>
                        <td>{{ table.distance_between_station }}</td>
                        <td>{{ table.distance_in_limited_speed }}</td>
                        <td>{{ table.spendtime_between_station }} </td>
                        <td>{{ table.spendtime_between_limited_space }}</td>
                        <td>{{ table.spendtime_to_stay_station }} </td>
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
                        <td colspan="8" scope="row">{{$t('Oʼrtacha tezlik')}} = {{technic_speed}} {{$t('km/soat')}}</td>
                        <td colspan="8" scope="row">{{$t('Qatnov tezlik')}} = {{traffic_speed}} {{$t('km/soat')}}</td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="table_footer" v-if="tableData.length">
                <div class="col-xl-6 col-lg-6">
                    <p>{{$t('Qatnov yoʼli xarakat xafsizligiga')}}:  {{timingDetails.conclusion}}</p>
                    <p>{{$t('Oʼlchov oʼtkazilgan kun')}}:  {{timingDetails.date}} {{$t('yil')}}</p>
                    <p>{{$t('Xronametraj oʼtkazilgan avtomobil rusumi va davlat raqami')}}:  {{timingDetails.avto_model}}, {{timingDetails.avto_number}}</p>
                </div>
                <div class="col-xl-4 col-lg-6 right_item">
                    <div>
                        <p>{{$t('Oʼlchov qatnashchilari imzolari')}}:</p>
                    </div>
                    <div>
                        <p  v-for="(person,index) in timingDetails.persons">{{person.name.charAt(0)}}.{{person.surname}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import PassportTab from "./PassportTab";
import Loader from '../Loader'
export default {
  components: {
    DatePicker,
    PassportTab,
    Loader
  },
  data() {
    return {
      titulData:[],
      form: {
        direction_id: this.$route.params.directionId,
        // region_from_id: this.titulData.region_from_with,
        region_from_id: '',
        region_to_id: "",
        // area_from_id:  this.titulData.area_from_with,
        area_from_id:  '',
        area_to_id: "",
        // station_from_id: this.titulData.station_from_id,
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
        // whereForm: this.titulData.from_where,
        whereForm: '',
        whereTo: '',
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
      technic_speed: 0,
      traffic_speed: 0,
      laoding: true
    };
  },
  async mounted() {
    await this.actionDirection(this.$route.params.directionId);
    this.laoding = false
    this.titulData = this.getDirection
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
      this.calctechnic_speed()
    }
  },
  computed: {
    ...mapGetters("front", ["getDirection"]),
  },
  methods: {
    ...mapActions("front", ["actionDirection"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    calctechnic_speed(){
      let calc_technic_speed = 0
      let calc_traffic_speed = 0
      this.tableData.forEach((item)=>{
        calc_technic_speed += parseFloat(item.spendtime_between_station)
        calc_traffic_speed += parseFloat(item.spendtime_to_stay_station)
      })
      this.technic_speed =  (this.tableData[this.tableData.length - 1].distance_from_start_station * 60) /  calc_technic_speed
      this.traffic_speed =  (this.tableData[this.tableData.length - 1].distance_from_start_station * 60) /  (calc_technic_speed + calc_traffic_speed)
      this.technic_speed = parseFloat(this.technic_speed).toFixed(1)
      this.traffic_speed = parseFloat(this.traffic_speed).toFixed(1)
      // traffic_speed
    },
    addItem() {
      if (
        this.form.start_time != "" &&
        this.form.speed_between_station != "" &&
        this.form.speed_between_limited_space != "" &&
        this.form.end_speedometer != "" &&
        this.form.end_time != "" &&
        this.form.distance_in_limited_speed != "" &&
        this.form.spendtime_between_limited_space != "" &&
        this.form.region_to_id != "" &&
        this.form.whereTo  != ""
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
        this.calctechnic_speed()
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
    addPerson(){
      let thisDate = { name: "", surname: '', middlename: '', job: "", position: "" }
      this.timingDetails.persons.push(thisDate)
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
