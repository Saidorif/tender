<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
    <div class="card card_with_tabs">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-clipboard-check"></i>
          {{$t('Tahrirlash')}}
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/confirm-schedule">
          <span class="peIcon pe-7s-back"></span>
          {{$t('Orqaga')}}
        </router-link>
      </div>
      <div class="card-body">
        <form
          enctype="multipart/form-data"
          class="row tabRow"
        >
          <div class="row col-md-12">
            <div class="form-group col-md-3" v-if="titulData">
              <label for="reys_to_count" v-if="titulData.timing_with && titulData.timing_with.length" >
                {{$t('Reyslar soni')}} {{ titulData.timing_with[0].whereForm  ? titulData.timing_with[0].whereForm.name : '' }}  {{$t('tomondan')}}
              </label>
              <div class="form-control input_style">
                {{form.reys_to_count}}
              </div>
            </div>
            <div class="form-group col-md-3" v-if="titulData">
              <label for="reys_from_count" v-if="titulData.timing_with && titulData.timing_with.length">
                {{$t('Reyslar soni')}}
                {{ titulData.timing_with[0].whereTo  ? titulData.timing_with[titulData.timing_with.length - 1].whereTo.name : '' }}  {{$t('tomondan')}}
              </label>
              <div class="form-control input_style">
                {{form.reys_from_count}}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="count_bus">{{$t('Qatnovchi avtomobillar soni')}} </label>
              <div class="form-control input_style">
                {{form.count_bus}}
              </div>
            </div>
          </div>
          <h2 v-if="titulData.type">
            {{ titulData.type.type }} - {{ titulData.pass_number }} -{{$t('sonli')}}  "{{
              titulData.name
            }}" {{$t('Avtobus yoʼnalishi qatnov yoʼli masofasini va xarakat vaqtini olchash qaydnomasi')}}
          </h2>
          <div class="col-md-4">
            <p>
              {{$t('Qatnov yoʼl masofasi')}}
              <b v-if="titulData.timing_with && titulData.timing_with.length"
                >{{ titulData.timing_with[titulData.timing_with.length - 1].distance_from_start_station}}
                 {{$t('km')}}</b
              >
            </p>
          </div>
          <div class="col-md-4">
            <p>{{$t('Qatnovchi avtomobillar soni')}} {{ form.count_bus }}</p>
          </div>
          <div class="col-md-4">
            <p>{{$t('Yoʼlkira xaqqi soʼm')}}</p>
          </div>
          <div class="table-responsive" v-if="form.whereTo">
            <table
              class="table table-bordered text-center table-hover table-striped"
            >
              <thead>
                <tr>
                  <th scope="col" rowspan="5">{{$t('Qatnovlar')}}</th>
                  <th scope="col" :colspan="form.whereTo.stations.length * 2">
                    {{form.whereTo.where.name}} {{$t('tomondan')}}
                  </th>
                  <th scope="col" rowspan="3">{{$t('Reys ischinligi')}}</th>
                </tr>
                <tr>
                  <th
                    colspan="2"
                    v-for="(item, index) in form.whereTo.stations"
                  >
                    {{ item.name }}
                    <i v-if="index != 0 && index != form.whereTo.stations.length - 1" class="trashTable fas fa-trash"  @click="removeStation('whereTo', index)"></i>
                  </th>
                </tr>
                <tr>
                  <template v-for="(item, index) in form.whereTo.stations">
                    <th>{{$t('Kelish')}}</th>
                    <th>{{$t('Chiqish')}}</th>
                  </template>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(p_item, p_index) in form.whereTo.reyses">
                  <td>{{ p_index + 1 }}</td>
                  <template v-for="(ch_item, ch_index) in p_item">
                    <td class="reys1" colspan="1">
                      <div class="table_input">
                        {{ch_item.end}}
                      </div>
                    </td>
                    <td class="reys1" colspan="1">
                      <div class="table_input">
                        {{ch_item.start}}
                      </div>
                    </td>
                    <input type="hidden" v-model="p_item.bus_order" class="table_input" />
                  </template>
                  <td class="reys1" colspan="1">
                    <div class="table_input">
                      {{p_item.bus_order}}
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive" v-if="form.whereFrom">
            <table  class="table table-bordered text-center table-hover table-striped">
              <thead>
                <tr>
                  <th scope="col" rowspan="5">{{$t('Qatnovlar')}}</th>
                  <th scope="col" :colspan="form.whereFrom.stations.length * 2">
                     {{form.whereFrom.where.name}} {{$t('tomondan')}}
                  </th>
                  <th scope="col" rowspan="3">{{$t('Reys ischinligi')}}</th>
                </tr>
                <tr>
                  <th colspan="2" v-for="(item, index) in form.whereFrom.stations" >
                    {{ item.name }}
                    <i v-if="index != 0 && index != form.whereFrom.stations.length - 1" class="trashTable fas fa-trash"  @click="removeStation('whereFrom', index)"></i>
                  </th>
                </tr>
                <tr>
                  <template v-for="(item, index) in form.whereFrom.stations">
                    <th>{{$t('Kelish')}}</th>
                    <th>{{$t('Chiqish')}}</th>
                  </template>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(p_item, p_index) in form.whereFrom.reyses">
                  <td>{{ p_index + 1 }}</td>
                  <template v-for="(ch_item, ch_index) in p_item">
                    <td class="reys1" colspan="1">
                      <div class="table_input">
                        {{ch_item.end}}
                      </div>
                    </td>
                    <td class="reys1" colspan="1">
                      <div class="table_input">
                        {{ch_item.start}}
                      </div>
                    </td>
                    <input type="hidden" v-model="p_item.bus_order" class="table_input" />
                  </template>
                  <td class="reys1" colspan="1">
                    <div class="table_input">
                      {{p_item.bus_order}}
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="form-group col-lg-12 d-flex justify-content-end">
            <button type="button" class="btn btn-danger btn_save_category mr-3" @click.prevent="rejectTitul">
              <i class="fas fa-times"></i>
              {{$t('Rad etish')}}
            </button>
            <button type="button" class="btn btn-success btn_save_category" @click.prevent="sendToActivate">
              <i class="fas fa-check"></i>
              {{$t('Tasdiqlash')}}
            </button>
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
      titulData: {},
      form: {
        whereFrom: {
          where: '',
          stations: [],
          reyses: [],
          from: ''
        },
        whereTo: {
          where:  '',
          stations: [],
          reyses: [],
          from: ''
        },
        count_bus: '',
        reys_to_count: '',
        reys_from_count: '',
      },
      requiredInput: false,
      laoding: true
    };
  },
  watch: {
    'form.reys_to_count': {
      handler() {
        if (this.form.reys_to_count) {
            if(this.getSchedule.whereTo.length){
              if(this.form.reys_to_count > this.form.whereTo.reyses.length){
                let forEachNumber = this.form.reys_to_count - this.form.whereTo.reyses.length
                for (let index = 0; index < forEachNumber; index++) {
                    let dataArray = this.form.whereTo.stations.map((item) => {
                      return { end: "", start: "", where: item, bus_order: '',};
                    });
                    this.form.whereTo.reyses.push(dataArray);
                }
              }else{
                let forEachNumber =  this.form.whereTo.reyses.length - this.form.reys_to_count
                this.form.whereTo.reyses.splice(-forEachNumber, forEachNumber);
              }
            }else{
              this.form.whereTo.reyses = [];
              for (let i = 1; i <= this.form.reys_to_count; i++) {
                let dataArray = this.form.whereTo.stations.map((item) => {
                  return { end: "", start: "", where: item, bus_order: '', };
                });
                this.form.whereTo.reyses.push(dataArray);
              }
            }
        }
      },
      deep: true
    },
    'form.reys_from_count': {
      handler() {
          if (this.form.reys_from_count) {
            if(this.getSchedule.whereFrom.length){
              if(this.form.reys_from_count > this.form.whereFrom.reyses.length){
                let forEachNumber = this.form.reys_from_count - this.form.whereFrom.reyses.length
                for (let index = 0; index < forEachNumber; index++) {
                    let dataArray = this.form.whereFrom.stations.map((item) => {
                      return { end: "", start: "", where: item };
                    });
                    this.form.whereFrom.reyses.push(dataArray);
                }
              }else{
                let forEachNumber =  this.form.whereFrom.reyses.length - this.form.reys_from_count
                this.form.whereFrom.reyses.splice(-forEachNumber, forEachNumber);
              }
            }else{
              this.form.whereFrom.reyses = [];
              for (let i = 1; i <= this.form.reys_from_count; i++) {
                let dataArray = this.form.whereFrom.stations.map((item) => {
                  return { end: "", start: "", where: item };
                });
                this.form.whereFrom.reyses.push(dataArray);
              }
            }
          }
      },
    },
  },
  async mounted() {
    await this.actionScheduleShow(this.$route.params.confirmscheduleId);
    await this.actionGetScheduleTable(this.$route.params.confirmscheduleId);
    this.laoding = false
      this.titulData = this.getShowschedule;
    if(this.getSchedule.whereFrom.length && this.getSchedule.whereTo.length){
      this.form.whereFrom.where = this.getSchedule.whereFrom[0].where;
      this.form.whereFrom.stations =  this.getSchedule.whereFrom[0].stations
      this.getSchedule.whereFrom.forEach(element => {
        this.form.whereFrom.reyses.push(element.reys_times)
      });
      this.form.whereTo.where = this.getSchedule.whereTo[0].where;
      this.form.whereTo.stations =  this.getSchedule.whereTo[0].stations
      this.getSchedule.whereTo.forEach(element => {
        this.form.whereTo.reyses.push(element.reys_times)
      });
      this.form.count_bus = this.getSchedule.whereFrom[0].count_bus
      this.form.reys_from_count = this.getSchedule.whereFrom[0].reys_from_count
      this.form.reys_to_count = this.getSchedule.whereFrom[0].reys_to_count
      this.form.whereFrom.from = this.titulData.timing_with.length ? this.titulData.timing_with[0].whereForm : '';
      this.form.whereTo.from = this.titulData.timing_with.length ? this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo : '';
      this.form.whereFrom.reyses.forEach((p_item)=>{
          p_item['bus_order'] = p_item[0].bus_order
      })
      this.form.whereTo.reyses.forEach((p_item)=>{
          p_item['bus_order'] = p_item[0].bus_order
      })
    }else{
      this.form.whereFrom.where = this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo;
      this.form.whereTo.where = this.titulData.timing_with[0].whereForm;
      this.form.whereFrom.from = this.titulData.timing_with[0].whereForm;
      this.form.whereTo.from =  this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo;
      let stationsLeng = this.titulData.timing_with.length;
      this.titulData.timing_with.forEach((item, i) => {
        this.form.whereTo.stations.push(item.whereForm)
        this.form.whereFrom.stations.push(item.whereForm);
        if(stationsLeng == i + 1){
          this.form.whereTo.stations.push(item.whereTo)
          this.form.whereFrom.stations.push(item.whereTo);
        }
      });
      this.form.whereFrom.stations = this.form.whereFrom.stations.reverse()
    }
  },
  computed: {
    ...mapGetters("passportTab", ["getScheduleResMsg", "getSchedule"]),
    ...mapGetters("confirmschedule", ["getSchedules","getScheduleMassage","getShowschedule"]),
  },
  methods: {
    ...mapActions("confirmschedule", ["actionScheduleShow","actionActivateSchedule","actionRejectSchedule"]),
    ...mapActions("passportTab", [
      "actionAddTiming",
      "clearTimingTable",
      "actionSetScheduleTable",
      "actionGetScheduleTable",
    ]),
    calcToTime(fromTime, toTime, index, thisItem) {
      let nextItem = this.form[index];
    },
    async rejectTitul(){
      if(confirm("Вы действительно хотите отказатся?")){
        await this.actionRejectSchedule(this.$route.params.confirmscheduleId)
        if (this.getScheduleMassage.success){
          await this.actionScheduleShow(this.$route.params.confirmscheduleId);
          this.$router.push('/crm/confirm-schedule')
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getScheduleMassage.message,
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getScheduleMassage.message,
          });
        }
      }
    },
    async sendToActivate(){
      await this.actionActivateSchedule(this.$route.params.confirmscheduleId)
      if (this.getScheduleMassage.success){
        await this.actionScheduleShow(this.$route.params.confirmscheduleId);
        this.$router.push('/crm/confirm-schedule')
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getScheduleMassage.message,
        });
      }else{
        toast.fire({
          type: "error",
          icon: "error",
          title: this.getScheduleMassage.message,
        });
      }
    },
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
.th_with_input {
  padding: 0;
}
.table_input {
  width: 70px;
  padding: 0px;
  border: none;
  background: transparent;
}
.btn_trash {
  width: 30px;
  height: 30px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  margin-left: auto;
  margin-right: auto;
}
.input_bd_none {
  border: none;
  width: 20px;
  text-align: center;
}
.reys8.hovered,
.reys7.hovered,
.reys6.hovered,
.reys5.hovered,
.reys4.hovered,
.reys3.hovered,
.reys2.hovered,
.reys1.hovered {
  background-color: #e0f3ff;
}
tbody tr td:focus-within {
  border-bottom: 1px solid #000;
}
.trashTable{
  color: red;
  position: absolute;
  top: 8px;
  right: 5px;
  cursor: pointer;
  opacity: 0;
  transition: .5s;
}
th{
  position: relative;
}
th:hover .trashTable{
  opacity: 1;
}

</style>
