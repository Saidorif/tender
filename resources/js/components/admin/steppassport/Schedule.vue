<template>
  <div class="add_area">
    <div class="card card_with_tabs">
      <div class="card-header tabCard">
        <PassportTab />
      </div>
      <div class="card-body">
        <form
          @submit.prevent.enter="saveData"
          enctype="multipart/form-data"
          class="row tabRow"
        >
          <div class="row col-md-12">
            <div class="form-group col-md-3">
              <label for="reys_to_count" v-if="this.titulData">Reyslar soni {{ this.titulData.timing_with  ? this.titulData.timing_with[0].whereForm.name : '' }} tomondan</label>
              <input
                type="number"
                v-model="form.reys_to_count"
                id="reys_to_count"
                class="form-control input_style"
                :class="isRequired(form.reys_to_count) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3" v-if="this.titulData">
              <label for="reys_from_count">Reyslar soni  {{ this.titulData.timing_with  ? this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo.name : '' }} tomondan</label>
              <input
                type="number"
                v-model="form.reys_from_count"
                id="reys_from_count"
                class="form-control input_style"
                :class="isRequired(form.reys_from_count) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="count_bus">Qatnovchi avtomobillar soni </label>
              <input
                type="number"
                v-model="form.count_bus"
                id="count_bus"
                class="form-control input_style"
                :class="isRequired(form.count_bus) ? 'isRequired' : ''"
              />
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
                  <template v-for="(p_item, p_index) in p_item">
                    <td class="reys1" colspan="1">
                      <input
                        v-model="p_item.from_date"
                        type="text"
                        class="table_input"
                      />
                    </td>
                    <td class="reys1" colspan="1">
                      <input
                        v-model="p_item.to_date"
                        type="text"
                        class="table_input"
                      />
                    </td>
                  </template>
                  <td class="reys1" colspan="1">
                    <input type="text" class="table_input" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive" v-if="form.whereFrom">
            <table
              class="table table-bordered text-center table-hover table-striped"
            >
              <thead>
                <tr>
                  <th scope="col" rowspan="5">Qatnovlar</th>
                  <th scope="col" :colspan="form.whereFrom.stations.length * 2">
                     {{form.whereFrom.where.name}}
                  </th>
                  <th scope="col" rowspan="3">Reys ischinligi</th>
                </tr>
                <tr>
                  <th
                    colspan="2"
                    v-for="(item, index) in form.whereFrom.stations"
                  >
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
                  <template v-for="(p_item, p_index) in p_item">
                    <td class="reys1" colspan="1">
                      <input
                        v-model="p_item.from_date"
                        type="text"
                        class="table_input"
                      />
                    </td>
                    <td class="reys1" colspan="1">
                      <input
                        v-model="p_item.to_date"
                        type="text"
                        class="table_input"
                      />
                    </td>
                  </template>
                  <td class="reys1" colspan="1">
                    <input type="text" class="table_input" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn_save_category">
              <i class="fas fa-save"></i>
              Сохранить
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
import PassportTab from "./PassportTab";
export default {
  components: {
    DatePicker,
    PassportTab,
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
        count_bus: null,
        reys_to_count: null,
        reys_from_count: null,
      },

    };
  },
  watch: {
    'form.reys_to_count': {
      handler() {
        if (this.form.reys_to_count) {
          if(this.form.reys_to_count > this.form.whereTo.reyses.length && this.form.whereTo.reyses.length != 0){
            console.log(this.form.whereTo.reyses.length)
            console.log(this.form.reys_to_count)
            for (let i = 1; i <= this.form.reys_to_count - this.form.whereTo.reyses.length + 1; i++) {
              let dataArray = this.form.whereTo.stations.map((item) => {
                return { from_date: "", to_date: "", where: item };
              });
              this.form.whereTo.reyses.push(dataArray);
            }
          }else{
            this.form.whereTo.reyses = [];
            for (let i = 1; i <= this.form.reys_to_count; i++) {
              let dataArray = this.form.whereTo.stations.map((item) => {
                return { from_date: "", to_date: "", where: item };
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
        this.form.whereFrom.reyses = [];
        if (this.form.reys_from_count) {
          for (let i = 1; i <= this.form.reys_from_count; i++) {
            let dataArray = this.form.whereFrom.stations.map((item) => {
              return { from_date: "", to_date: "", where: item };
            });
            this.form.whereFrom.reyses.push(dataArray);
          }
        }
      },
    },
  },
  async mounted() {
    await this.actionEditDirection(this.$route.params.directionId);
    await this.actionGetScheduleTable(this.$route.params.directionId);
      this.titulData = this.getDirection;
    // if(this.getSchedule){
    //   console.log(this.getSchedule)
    //   this.form.whereFrom.where = this.getSchedule.whereFrom[0].where;
    //   this.form.whereTo.where = this.getSchedule.whereTo[0].where;
    //         console.log(this.form)
    // }else{
      this.form.whereFrom.where = this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo;
      this.form.whereTo.where = this.titulData.timing_with[0].whereForm;
      this.form.whereFrom.from = this.titulData.timing_with[0].whereForm;
      this.form.whereTo.from =  this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo;
      this.form.whereTo.stations = this.titulData.timing_with.map((item) => {
        return item.whereForm;
      });
      this.form.whereFrom.stations = this.titulData.timing_with.map((item) => {
        return item.whereForm;
      });

      this.form.whereFrom.stations = this.form.whereFrom.stations.reverse()
    // }
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
      await this.actionSetScheduleTable({
        id: this.$route.params.directionId,
        data: this.form,
      });
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
</style>