<template>
  <div class="add_area">
    <Loader v-if="laoding" />
    <div class="card card_with_tabs">
      <div class="card-header tabCard">
        <PassportTab />
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-info text-white" @click.prevent="refreshDemand">
              <i class="fas fa-redo"></i>
              Обнавить
            </button>
          </div>
        </div>
        <div class="table-responsive" v-if="getDemand.result">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>1</td>
                <td width="50%"><b>Автотранспорт воситаси категорияси</b></td>
                <td>
                  <template v-if="form.auto_model_class">
                    <div v-for="(item, index) in form.auto_model_class">
                      {{ item.bustype ? item.bustype.name : '' }}
                    </div>
                  </template>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td width="50%">
                  <b>Автотранспорт воситаси моделининг класси</b>
                </td>
                <td>
                  <template v-if="form.auto_model_class">
                    <div v-for="(item, index) in form.auto_model_class">
                      <!-- {{ item.model ? item.model.name : '' }} -->
                      {{ item.tclass ? item.tclass.name : '' }}
                    </div>
                  </template>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td width="50%"><b>Йуналишнинг тури</b></td>
                <td>
                    {{form.dir_type == 'bus' ? 'Автобус йуналиши' : "Йўналиши тахи йуналиши"}}
                </td>
              </tr>
              <tr>
                <td rowspan="3">4</td>
                <td width="50%">
                  <b
                    >Автотранспорт воситалари сони (саройдан фойдаланиш
                    коэффициенти 0,8 хисобга олинганда)</b
                  >
                </td>
                <td>{{ form.auto_trans_count }}</td>
              </tr>
              <tr>
                <td>Ишкунлари</td>
                <td>
                  <textarea
                    rows="1"
                    v-model="form.auto_trans_working_days"
                    class="form-control"
                  ></textarea>
                </td>
              </tr>
              <tr>
                <td>Дам олиш кунлари</td>
                <td>
                  <textarea
                    rows="1"
                    v-model="form.auto_trans_weekends"
                    class="form-control"
                  ></textarea>
                </td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>5</td>
                <td width="50%"><b>Автотранспорт воситалари ҳолати</b></td>
                <td>
                  <input
                    type="text"
                    v-model="form.auto_trans_status"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">6</td>
                <td width="50%"><b>Йуналишнинг умумий узунлиги</b></td>
                <td>
                  <input
                    type="number"
                    v-model="form.direction_total_length"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td>
                  {{ form.direction_from_name }}-{{ form.direction_to_name }}
                </td>
                <td>
                  <input
                    type="number"
                    v-model="form.direction_from_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td>
                  {{ form.direction_to_name }}-{{ form.direction_from_name }}
                </td>
                <td>
                  <input
                    type="number"
                    v-model="form.direction_to_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">7</td>
                <td width="50%"><b>Бекатлар сони</b></td>
                <td>
                  <b>{{ form.stations_count }}</b>
                </td>
              </tr>
              <tr>
                <td>
                  {{ form.stations_from_name }}-{{ form.stations_to_name }}
                </td>
                <td>
                  <input
                    type="number"
                    v-model="form.stations_from_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td>
                  {{ form.stations_to_name }}-{{ form.stations_from_name }}
                </td>
                <td>
                  <input
                    type="number"
                    v-model="form.stations_to_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>8</td>
                <td width="50%"><b>Мавсумийлиги</b></td>
                <td>{{ getSeasonalName(form.seasonal) }}</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">9</td>
                <td width="50%"><b>Рейслар (қатновлар) сони</b></td>
                <td>
                  <b>{{ form.reyses_count }}</b>
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }}-{{ form.reyses_to_name }}</td>
                <td>
                  <input
                    type="number"
                    v-model="form.reyses_from_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }}-{{ form.reyses_from_name }}</td>
                <td>
                  <input
                    type="number"
                    v-model="form.reyses_to_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">10</td>
                <td width="50%"><b>Дастлабки рейс (ишни бошлаш) вақти</b></td>
                <td>
                  <b>{{ form.schedule_begin_time }}</b>
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }} томондан</td>
                <td>{{ form.schedule_begin_from }}</td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }} томондан</td>
                <td>{{ form.schedule_begin_to }}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">11</td>
                <td width="50%"><b>Сўнги рейс (ишни тугалланиш) вақти</b></td>
                <td>
                  <b>{{ form.schedule_end_time }}</b>
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }} томондан</td>
                <td>{{ form.schedule_end_from }}</td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }} томондан</td>
                <td>{{ form.schedule_end_to }}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td>12</td>
                <td width="50%"><b>Бекатлар оралиқ интерваллари</b></td>
                <td>
                  <b
                    ><input
                      type="number"
                      v-model="form.station_intervals"
                      class="form-control"
                  /></b>
                </td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">13</td>
                <td width="50%"><b>Рейс вақти</b></td>
                <td>
                  <b
                    ><input
                      type="string"
                      v-model="form.reys_time"
                      class="form-control"
                  /></b>
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }}-{{ form.reyses_to_name }}</td>
                <td>
                  <input
                    type="string"
                    v-model="form.reys_from_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }}-{{ form.reyses_from_name }}</td>
                <td>
                  <input
                    type="string"
                    v-model="form.reys_to_value"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>14</td>
                <td width="50%"><b>Харакатланиш жадваллари</b></td>
                <td>
                  <input
                    type="number"
                    v-model="form.schedules"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td :rowspan="2">15</td>
                <td width="50%"><b>Тариф</b></td>
                <td>
                  <b>{{ form.tarif }}</b>
                </td>
              </tr>
              <tr v-if="getDemand.type && getDemand.type.id != 1">
                <td>
                  1 км. учун йўл тариф (шаҳар атрофи, шаҳарлараро йўналишлар
                  учун)
                </td>
                <td>
                  1 км. учун ({{ form.tarif_one_km }} сум). Йўл кира ҳаққи ({{
                    form.tarif_full_km
                  }}
                  сум)
                </td>
              </tr>
              <tr v-else>
                <td>Йўл кира ҳаққи (шаҳар йўналишлар учун)</td>
                <td>{{ form.tarif_city }} сум</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="2">16</td>
                <td width="50%">
                  <b>Автотранспорт воситаларини умумий сиғими</b>
                </td>
                <td>
                  <input
                    type="number"
                    v-model="form.transports_capacity"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td>ўриндиқлар сони</td>
                <td>
                  <input
                    type="number"
                    v-model="form.transports_seats"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>17</td>
                <td width="50%"><b>Минимал балл</b></td>
                <td>
                  <input
                    type="number"
                    v-model="form.minimum_bal"
                    class="form-control"
                  />
                </td>
              </tr>
            </tbody>
          </table>
          <div class="text_place">
            <label for="text">Текст</label>
            <textarea
              id="text"
              class="form-control"
              v-model="form.text"
            ></textarea>
          </div>
          <div class="btn_send d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-primary"
              @click.prevent="saveData"
            >
              <i class="fas fa-save"></i>
              Сохранить
            </button>
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
import Loader from "../../Loader";
export default {
  components: {
    DatePicker,
    PassportTab,
    Loader,
  },
  data() {
    return {
      form: {},
      laoding: true,
    };
  },
  async mounted(){
    // await this.actionEditDirection(this.$route.params.directionId);
    let data ={
      generate:0,
      id:this.$route.params.directionId
    }
    await this.actionDemand(data);
    this.form = this.getDemand.result;
    if(this.getDemand.error){
      toast.fire({
        type: "error",
        icon: "error",
        title: this.getDemand.message,
      });
    }
    this.laoding = false;
  },
  // watch:{
  //   'getDemand.result':{
  //     handler(){
  //       if (this.getDemand.success){
  //         this.form = this.getDemand.result;
  //       } else if(this.getDemand.error){
  //         this.form = this.getDemand.result;
  //         toast.fire({
  //           type: "error",
  //           icon: "error",
  //           title: this.getDemand.message,
  //         });
  //       }
  //     },deep:true
  //   }
  // },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ["getDemand", "getMsg"]),
  },
  methods: {
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ["actionDemand", "actionDemandSave"]),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    getSeasonalName(name) {
      if (name == "always") {
        return "Doimiy";
      } else if (name == "seasonal") {
        return "Mavsumiy";
      }
    },
    async refreshDemand(){
      let data = {
        generate:1,
        id:this.$route.params.directionId
      }
      await this.actionDemand(data);
      this.form = this.getDemand.result;
      if(this.getDemand.error){
        toast.fire({
          type: "error",
          icon: "error",
          title: this.getDemand.message,
        });
      }
    },
    async saveData() {
      let data = {
        id: this.$route.params.directionId,
        items: this.form,
      };
      this.laoding = true
      await this.actionDemandSave(data);
      this.laoding = false
      if (this.getMsg.success) {
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getMsg.message,
        });
      } else if(this.getMsg.error) {
        let errors= this.getMsg.message
        if(errors.constructor.name === 'Object'){
          toast.fire({
            type: "error",
            icon: "error",
            title: "Заполните все поля!",
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getMsg.message,
          });
        }
      }
    },
  },
};
</script>
<style scoped>
.btn_send {
  margin-top: 30px;
}
</style>
