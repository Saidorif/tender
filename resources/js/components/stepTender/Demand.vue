<template>
  <div class="add_area">
        <Loader v-if="laoding"/>
        <PassportTab/>
        <div class="card-body container">
            <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>1</td>
                    <td width="50%"><b>{{$t('Аvtotransport vositasi kategoriyasi')}}</b></td>
                    <td>{{form.auto_type_name}}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td width="50%"><b>{{$t('Аvtotransport vositasi modelining klassi')}}</b></td>
                    <td>
                    <div v-for="(item,index) in form.auto_model_class">
                        {{item.model.name}}
                    </div>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3">3</td>
                    <td width="50%"><b>{{$t('Аvtotransport vositalari soni (saroydan foydalanish koeffitsienti 0,8 xisobga olinganda)')}} </b></td>
                    <td>{{form.auto_trans_count}}</td>
                </tr>
                <tr>
                    <td>{{$t('Ishkunlari')}}</td>
                    <td>
                    {{form.auto_trans_working_days}}
                    </td>
                </tr>
                <tr>
                    <td>{{$t('Dam olish kunlari')}}</td>
                    <td>
                    {{form.auto_trans_weekends}}
                    </td>
                </tr>
                <!-- 3 end -->
                <tr>
                    <td>4</td>
                    <td width="50%"><b>{{$t('Аvtotransport vositalari holati')}}</b></td>
                    <td>14 {{$t('yildan')}}</td>
                </tr>
                <!-- 3 s -->
                <tr>
                    <td rowspan="3">5</td>
                    <td width="50%"><b>{{$t('Yunalishning umumiy uzunligi')}}</b></td>
                    <td><b>{{form.direction_total_length}}</b></td>
                </tr>
                <tr>
                    <td>{{form.direction_from_name}}-{{form.direction_to_name}}</td>
                    <td>{{form.direction_from_value}}</td>
                </tr>
                <tr>
                    <td>{{form.direction_to_name}}-{{form.direction_from_name}}</td>
                    <td>{{form.direction_to_value}}</td>
                </tr>
                <!-- 3 end -->
                <!-- 3 s -->
                <tr>
                    <td rowspan="3">6</td>
                    <td width="50%"><b>{{$t('Bekatlar soni')}}</b></td>
                    <td><b>{{form.stations_count}}</b></td>
                </tr>
                <tr>
                    <td>{{form.stations_from_name}}-{{form.stations_to_name}}</td>
                    <td>{{form.stations_from_value}}</td>
                </tr>
                <tr>
                    <td>{{form.stations_to_name}}-{{form.stations_from_name}}</td>
                    <td>{{form.stations_to_value}}</td>
                </tr>
                <!-- 3 end -->
                <tr>
                    <td>7</td>
                    <td width="50%"><b>{{$t('Mavsumiyligi')}}</b></td>
                    <td>{{getSeasonalName(form.seasonal)}}</td>
                </tr>
                <!-- 3 s -->
                <tr>
                    <td rowspan="3">8</td>
                    <td width="50%"><b>{{$t('Reyslar (qatnovlar) soni')}}</b></td>
                    <td><b>{{form.reyses_count}}</b></td>
                </tr>
                <tr>
                    <td>{{form.reyses_from_name}}-{{form.reyses_to_name}}</td>
                    <td>{{form.reyses_from_value}}</td>
                </tr>
                <tr>
                    <td>{{form.reyses_to_name}}-{{form.reyses_from_name}}</td>
                    <td>{{form.reyses_to_value}}</td>
                </tr>
                <!-- 3 end -->
                <!-- 3 s -->
                <tr>
                    <td rowspan="3">9</td>
                    <td width="50%"><b>{{$t('Dastlabki reys (ishni boshlash) vaqti')}} </b></td>
                    <td><b>{{form.schedule_begin_time}}</b></td>
                </tr>
                <tr>
                    <td>{{form.reyses_from_name}}{{$t('tomondan')}} </td>
                    <td>{{form.schedule_begin_from}}</td>
                </tr>
                <tr>
                    <td>{{form.reyses_to_name}} {{$t('tomondan')}}</td>
                    <td>{{form.schedule_begin_to}}</td>
                </tr>
                <!-- 3 end -->
                <!-- 3 s -->
                <tr>
                    <td rowspan="3">10</td>
                    <td width="50%"><b>{{$t('Soʼngi reys (ishni tugallanish) vaqti')}}</b></td>
                    <td><b>{{form.schedule_end_time}}</b></td>
                </tr>
                <tr>
                    <td>{{form.reyses_from_name}} {{$t('tomondan')}}</td>
                    <td>{{form.schedule_end_from}}</td>
                </tr>
                <tr>
                    <td>{{form.reyses_to_name}} {{$t('tomondan')}}</td>
                    <td>{{form.schedule_end_to}}</td>
                </tr>
                <!-- 3 end -->
                <!-- 3 s -->
                <tr>
                    <td>11</td>
                    <td width="50%"><b>{{$t('Bekatlar oraliq intervallari')}}</b></td>
                    <td><b>{{form.station_intervals}}</b></td>
                </tr>
                <!-- 3 end -->
                <!-- 3 s -->
                <tr>
                    <td rowspan="3">12</td>
                    <td width="50%"><b>{{$t('Reys vaqti')}} </b></td>
                    <td><b>{{(form.reys_time)}}</b></td>
                </tr>
                <tr>
                    <td>{{form.reyses_from_name}}-{{form.reyses_to_name}}</td>
                    <td>{{form.reys_from_value}}</td>
                </tr>
                <tr>
                    <td>{{form.reyses_to_name}}-{{form.reyses_from_name}}</td>
                    <td>{{form.reys_to_value}}</td>
                </tr>
                <!-- 3 end -->
                <tr>
                    <td>13</td>
                    <td width="50%"><b>{{$t('Xarakatlanish jadvallari')}} </b></td>
                    <td>{{form.schedules}}</td>
                </tr>
                <!-- 3 s -->
                <tr>
                    <td rowspan="3">14</td>
                    <td width="50%"><b>{{$t('Tarif')}}</b></td>
                    <td><b>{{form.tarif}}</b></td>
                </tr>
                <tr>
                    <td>1 {{$t('km. uchun yoʼl tarif (shahar atrofi, shaharlararo yoʼnalishlar uchun)')}}</td>
                    <td>1 {{$t('km. uchun')}}  ({{form.tarif_one_km}} {{$t('soʼm). Yoʼl kira haqqi (00 sum)')}} </td>
                </tr>
                <tr>
                    <td>{{$t('Yoʼl kira haqqi (shahar yoʼnalishlar uchun)')}}</td>
                    <td>{{form.tarif_city}} {{$t('soʼm')}} </td>
                </tr>
                <!-- 3 end -->
                <!-- 3 s -->
                <tr>
                    <td rowspan="2">15</td>
                    <td width="50%"><b>{{$t('Аvtotransport vositalarini umumiy sigʼimi')}}</b></td>
                    <td>{{form.transports_capacity}}</td>
                </tr>
                <tr>
                    <td>{{$t('oʼrindiqlar soni')}}</td>
                    <td>{{form.transports_seats}}</td>
                </tr>
                <!-- 3 end -->
                <tr>
                    <td>16</td>
                    <td width="50%"><b>{{$t('Minimal ball')}}</b></td>
                    <td>{{form.minimum_bal}}</td>
                </tr>
                </tbody>
            </table>
            <div class="text_place">
                <label for="text">{{$t('Matn')}}</label>
                <textarea id="text" class="form-control" v-model="form.holiday_days" disabled></textarea>
            </div>
        <!--    <div class="btn_send d-flex justify-content-end">
                <button type="button" class="btn btn-primary" @click.prevent="saveData">
                <i class="fas fa-save"></i>
                Сохранить
                </button>
            </div> -->
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
    },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ['getDemand']),
  },
  methods: {
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ['actionDemand']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    getSeasonalName(name){
      if(name == 'always') {
        return 'Doimiy';
      }
      else if (name == 'seasonal') {
        return 'Mavsumiy';
      }
    },
    saveData(){

    }
  },
};
</script>
<style scoped>
  .btn_send{
    margin-top:30px;
  }
</style>
