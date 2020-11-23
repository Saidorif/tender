<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
    <div class="card card_with_tabs">
      <div class="card-header tabCard">
        <PassportTab/>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
<!--             <thead>
              <tr>
                <th>№ т/р</th>
                <th>Автотранспорт воситаси категорияси</th>
                <th>Автотранспорт воситаси моделининг класси (фақат енгил автомобиллар учун)</th>
                <th>Таклиф</th>
              </tr>
            </thead> -->
            <tbody>
              <tr>
                <td>1</td>
                <td width="50%"><b>Автотранспорт воситаси категорияси</b></td>
                <td>{{form.auto_type_name}}</td>
              </tr>
              <tr>
                <td>2</td>
                <td width="50%"><b>Автотранспорт воситаси моделининг класси</b></td>
                <td>
                  <div v-for="(item,index) in form.auto_model_class">
                    {{item.model.name}}
                  </div>
                </td>
              </tr>
              <tr>
                <td rowspan="3">3</td>
                <td width="50%"><b>Автотранспорт воситалари сони (саройдан фойдаланиш коэффициенти 0,8 хисобга олинганда)</b></td>
                <td>{{form.auto_trans_count}}</td>
              </tr>
              <tr>
                <td>Ишкунлари</td>
                <td>
                  <input type="number" v-model="form.auto_trans_working_days" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Дам олиш кунлари</td>
                <td>
                  <input type="number" v-model="form.auto_trans_weekends" class="form-control">
                </td>
              </tr>
               <!-- 3 end -->
              <tr>
                <td>4</td>
                <td width="50%"><b>Автотранспорт воситалари ҳолати</b></td>
                <td><input type="number" v-model="form.auto_trans_status" class="form-control">йилдан</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">5</td>
                <td width="50%"><b>Йуналишнинг умумий узунлиги</b></td>
                <td><b>{{form.direction_total_length}}</b></td>
              </tr>
              <tr>
                <td>{{form.direction_from_name}}-{{form.direction_to_name}}</td>
                <td><input type="number" v-model="form.direction_from_value" class="form-control"></td>
              </tr>
              <tr>
                <td>{{form.direction_to_name}}-{{form.direction_from_name}}</td>
                <td><input type="number" v-model="form.direction_to_value" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">6</td>
                <td width="50%"><b>Бекатлар сони</b></td>
                <td><b>{{form.stations_count}}</b></td>
              </tr>
              <tr>
                <td>{{form.stations_from_name}}-{{form.stations_to_name}}</td>
                <td><input type="number" v-model="form.stations_from_value" class="form-control"></td>
              </tr>
              <tr>
                <td>{{form.stations_to_name}}-{{form.stations_from_name}}</td>
                <td><input type="number" v-model="form.stations_to_value" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>7</td>
                <td width="50%"><b>Мавсумийлиги</b></td>
                <td>{{getSeasonalName(form.seasonal)}}</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">8</td>
                <td width="50%"><b>Рейслар (қатновлар) сони</b></td>
                <td><b>{{form.reyses_count}}</b></td>
              </tr>
              <tr>
                <td>{{form.reyses_from_name}}-{{form.reyses_to_name}}</td>
                <td><input type="number" v-model="form.reyses_from_value" class="form-control"></td>
              </tr>
              <tr>
                <td>{{form.reyses_to_name}}-{{form.reyses_from_name}}</td>
                <td><input type="number" v-model="form.reyses_to_value" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">9</td>
                <td width="50%"><b>Дастлабки рейс (ишни бошлаш) вақти</b></td>
                <td><b>{{form.schedule_begin_time}}</b></td>
              </tr>
              <tr>
                <td>{{form.reyses_from_name}} томондан</td>
                <td>{{form.schedule_begin_from}}</td>
              </tr>
              <tr>
                <td>{{form.reyses_to_name}} томондан</td>
                <td>{{form.schedule_begin_to}}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">10</td>
                <td width="50%"><b>Сўнги рейс (ишни тугалланиш) вақти</b></td>
                <td><b>{{form.schedule_end_time}}</b></td>
              </tr>
              <tr>
                <td>{{form.reyses_from_name}} томондан</td>
                <td>{{form.schedule_end_from}}</td>
              </tr>
              <tr>
                <td>{{form.reyses_to_name}} томондан</td>
                <td>{{form.schedule_end_to}}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td>11</td>
                <td width="50%"><b>Бекатлар оралиқ интерваллари</b></td>
                <td><b><input type="number" v-model="form.station_intervals" class="form-control"></b></td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">12</td>
                <td width="50%"><b>Рейс вақти</b></td>
                <td><b>{{(form.reys_time)}}</b></td>
              </tr>
              <tr>
                <td>{{form.reyses_from_name}}-{{form.reyses_to_name}}</td>
                <td><input type="number" v-model="form.reys_from_value" class="form-control"></td>
              </tr>
              <tr>
                <td>{{form.reyses_to_name}}-{{form.reyses_from_name}}</td>
                <td><input type="number" v-model="form.reys_to_value" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>13</td>
                <td width="50%"><b>Харакатланиш жадваллари</b></td>
                <td><input type="number" v-model="form.schedules" class="form-control"></td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">14</td>
                <td width="50%"><b>Тариф</b></td>
                <td><b>{{form.tarif}}</b></td>
              </tr>
              <tr>
                <td>1 км. учун йўл тариф (шаҳар атрофи, шаҳарлараро йўналишлар учун)</td>
                <td>1 км. учун ({{form.tarif_one_km}} сум). Йўл кира ҳаққи (00 сум)</td>
              </tr>
              <tr>
                <td>Йўл кира ҳаққи (шаҳар йўналишлар учун)</td>
                <td>{{form.tarif_city}} сум</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="2">15</td>
                <td width="50%"><b>Автотранспорт воситаларини умумий сиғими</b></td>
                <td><input type="number" v-model="form.transports_capacity" class="form-control"></td>
              </tr>
              <tr>
                <td>ўриндиқлар сони</td>
                <td><input type="number" v-model="form.transports_seats" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>16</td>
                <td width="50%"><b>Минимал балл</b></td>
                <td><input type="number" v-model="form.minimum_bal" class="form-control"></td>
              </tr>
            </tbody>
          </table>
          <div class="text_place">
            <label for="text">Текст</label>
            <textarea id="text" class="form-control" v-model="form.text"></textarea>
          </div>
          <div class="btn_send d-flex justify-content-end">
            <button type="button" class="btn btn-primary" @click.prevent="saveData">
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
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    PassportTab,
    Loader
  },
  data(){
    return{
      form:{},
      laoding: true
    };
  },
  async mounted(){
    // await this.actionEditDirection(this.$route.params.directionId);
    await this.actionDemand(this.$route.params.directionId);
    this.laoding = false
    this.form = this.getDemand
    Vue.set(this.form,'stations_from_value','')
    Vue.set(this.form,'stations_to_value','')
    Vue.set(this.form,'station_intervals','')
    Vue.set(this.form,'text','')
    },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ['getDemand','getMsg']),
  },
  methods: {
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ['actionDemand','actionDemandSave']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    getSeasonalName(name){
      if (name == 'always'){
        return 'Doimiy';
      }
      else if (name == 'seasonal') {
        return 'Mavsumiy';
      }
    },
    async saveData(){
      let data ={
        id: this.$route.params.directionId,
        items:this.form       
      }
      await this.actionDemandSave(data)
      if (this.getMsg.success) {
        toast.fire({
          type: 'success',
          icon: 'success',
          title: this.getMsg.message,
        })
      }else{
        toast.fire({
          type: 'error',
          icon: 'error',
          title: 'Error',
        })
      }
    }
  },
};
</script>
<style scoped>
  .btn_send{
    margin-top:30px;
  }
</style>
