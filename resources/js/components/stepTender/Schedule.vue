<template>
    <div class="add_area">
        <Loader v-if="laoding"/>
        <PassportTab />
        <div class="card-body container">
            <div class="row col-md-12">
            <div class="form-group col-md-3">
                <label for="reys_to_count" v-if="this.titulData">
                Reyslar soni {{ this.titulData.timing_with  ? this.titulData.timing_with[0].whereForm.name : '' }} tomondan
                </label>
                <div class="form-control input_style">
                {{form.reys_to_count}}
                </div>
            </div>
            <div class="form-group col-md-3" v-if="this.titulData">
                <label for="reys_from_count">
                Reyslar soni  {{ this.titulData.timing_with  ? this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo.name : '' }} tomondan
                </label>
                <div class="form-control input_style">
                {{form.reys_from_count}}
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="count_bus">Qatnovchi avtomobillar soni </label>
                <div class="form-control input_style">
                {{form.count_bus}}
                </div>
            </div>
            </div>
            <h2 v-if="titulData.type">
            {{ titulData.type.type }} - {{ titulData.pass_number }} - sonli "{{
                titulData.name
            }}"Avtobus yo'nalishi qatnov yo'li masofasini va xarakat vaqtini
            olchash qaydnomasi
            </h2>
            <div class="col-md-4">
            <p>
                Qatnov yo'l masofasi
                <b v-if="titulData.timing_with"
                >{{
                    titulData.timing_with[titulData.timing_with.length - 1]
                    .end_speedometer
                }}
                km</b
                >
            </p>
            </div>
            <div class="col-md-4">
            <p>Qatnovchi avtomobillar soni {{ form.count_bus }}</p>
            </div>
            <div class="col-md-4">
            <p>Yolkira xaqqi so'm</p>
            </div>
            <div class="table-responsive" v-if="form.whereTo">
            <table
                class="table table-bordered text-center table-hover table-striped"
            >
                <thead>
                <tr>
                    <th scope="col" rowspan="5">Qatnovlar</th>
                    <th scope="col" :colspan="form.whereTo.stations.length * 2">
                    {{form.whereTo.where.name}}
                    </th>
                    <th scope="col" rowspan="3">Reys ischinligi</th>
                </tr>
                <tr>
                    <th
                    colspan="2"
                    v-for="(item, index) in form.whereTo.stations"
                    >
                    {{ item.name }}
                    </th>
                </tr>
                <tr>
                    <template v-for="(item, index) in form.whereTo.stations">
                    <th>Прибытие</th>
                    <th>Отправление</th>
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
                    </template>
                    <td class="reys1" colspan="1">
                    <div class="table_input">
                        {{p_item.bus_number}}
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
                    <th scope="col" rowspan="5">Qatnovlar</th>
                    <th scope="col" :colspan="form.whereFrom.stations.length * 2">
                    {{form.whereFrom.where.name}}
                    </th>
                    <th scope="col" rowspan="3">Reys ischinligi</th>
                </tr>
                <tr>
                    <th colspan="2" v-for="(item, index) in form.whereFrom.stations" >
                    {{ item.name }}
                    </th>
                </tr>
                <tr>
                    <template v-for="(item, index) in form.whereFrom.stations">
                    <th>Прибытие</th>
                    <th>Отправление</th>
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
                    </template>
                    <td class="reys1" colspan="1">
                    <div class="table_input">
                        {{p_item.bus_number}}
                    </div>
                    </td>
                </tr>
                </tbody>
            </table>
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
                      return { end: "", start: "", where: item };
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
                  return { end: "", start: "", where: item };
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
    await this.actionEditDirection(this.$route.params.directionId);
    await this.actionGetScheduleTable(this.$route.params.directionId);
    this.laoding = false
      this.titulData = this.getDirection;

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
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ["getScheduleResMsg", "getSchedule"]),
  },
  methods: {
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", [
      "actionAddTiming",
      "clearTimingTable",
      "actionSetScheduleTable",
      "actionGetScheduleTable",
    ]),
    async saveData() {
      if (
        this.form.count_bus != "" &&
        this.form.reys_to_count != "" &&
        this.form.reys_from_count != ""
      ) {
        this.laoding = true
        await this.actionSetScheduleTable({
          id: this.$route.params.directionId,
          data: this.form,
        });
        this.laoding = false
        if (this.getScheduleResMsg.success) {
          toast.fire({
            type: "success",
            icon: "success",
            title: "Malumotlar saqlandi",
          });
        } else {
          toast.fire({
            type: "error",
            icon: "error",
            title: "nmadir nito",
          });
        }
        this.requiredInput = false;
      }else{
        this.requiredInput = true;
      }
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    removeItem(index) {
      this.form.splice(index, 1);
    },
    calcToTime(fromTime, toTime, index, thisItem) {
      let nextItem = this.form[index];
    },
    removeStation(parentName, index){
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
          this.form[parentName].stations.splice(index, 1);
          this.form[parentName].reyses.forEach((item)=>{
            item.splice(index, 1)
          })
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
.th_with_input {
  padding: 0;
}
.table_input {
  width: 70px;
  padding: 0.25rem;
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
