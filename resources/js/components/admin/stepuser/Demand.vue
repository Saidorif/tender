<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
    <div class="card card_with_tabs">
      <div class="card-header tabCard">
        <PassportTab/>
      </div>
      <div class="card-body">
  <!--       <div class="row">
          <div class="col-md-12 d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-info text-white" @click.prevent="refreshDemand">
              <i class="fas fa-redo"></i>
              {{$t('Yangilash')}}
            </button>
          </div>
        </div> -->
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>1</td>
                <td width="50%"><b>{{$t('Avtotransport vositasi turi')}}</b></td>
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
                <td width="50%"><b>{{$t('Avtotransport vositasi markasini sinfi')}}</b></td>
                <td>
                  <div v-for="(item,index) in form.auto_model_class">
                    <!-- {{ item.model ? item.model.name : '' }} -->
                    {{ item.tclass ? item.tclass.name : '' }}
                  </div>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td width="50%"><b>{{$t('Yoʼnalish turi')}}</b></td>
                <td>{{type.name}}</td>
              </tr>
              <tr>
                <td rowspan="3">4</td>
                <td width="50%"><b>{{$t('Ish rejasi')}}</b></td>
              </tr>
              <tr>
                <td>{{$t('Ish rejasi')}}</td>
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
                <td>5</td>
                <td width="50%"><b>{{$t('Avtotransport vositalari holati')}}</b></td>
                <td>14 {{$t('yildan')}}</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">6</td>
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
                <td rowspan="3">7</td>
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
                <td>8</td>
                <td width="50%"><b>{{$t('Mavsumiyligi')}}</b></td>
                <td>{{getSeasonalName(form.seasonal)}}</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">9</td>
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
                <td rowspan="3">10</td>
                <td width="50%"><b>{{$t('Dastlabki reys (ishni boshlash) vaqti')}}</b></td>
                <td><b>{{form.schedule_begin_time}}</b></td>
              </tr>
              <tr>
                <td>{{form.reyses_from_name}} {{$t('tomondan')}}</td>
                <td>{{form.schedule_begin_from}}</td>
              </tr>
              <tr>
                <td>{{form.reyses_to_name}} {{$t('tomondan')}}</td>
                <td>{{form.schedule_begin_to}}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">11</td>
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
                <td>12</td>
                <td width="50%"><b>{{$t('Bekatlar oraliq intervallari')}}</b></td>
                <td><b>{{form.station_intervals}}</b></td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">13</td>
                <td width="50%"><b>{{$t('Reys vaqti')}}</b></td>
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
                <td>14</td>
                <td width="50%"><b>{{$t('Xarakatlanish jadvallari')}}</b></td>
                <td>{{form.schedules}}</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td :rowspan="form.tarif_city ? 3 : 2">15</td>
                <td width="50%"><b>{{$t('Tarif')}}</b></td>
                <td><b>{{form.tarif}}</b></td>
              </tr>
              <tr>
                <td>1 {{$t('km. uchun yoʼl tarif (shahar atrofi, shaharlararo yoʼnalishlar uchun)')}}</td>
                <td>1 {{$t('km. uchun')}} ({{form.tarif_one_km}} {{$t('soʼm). Yoʼl kira haqqi (00 sum)')}}</td>
              </tr>
              <tr v-if="form.tarif_city">
                <td>{{$t('Yoʼl kira haqqi (shahar yoʼnalishlar uchun)')}}</td>
                <td>{{form.tarif_city}} {{$t('soʼm')}}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="2">16</td>
                <td width="50%"><b>{{$t('Аvtotransport vositalarini umumiy sigʼimi')}}</b></td>
                <td>{{form.transports_capacity}}</td>
              </tr>
              <tr>
                <td>{{$t('Oʼrindiqlar soni')}}</td>
                <td>{{form.transports_seats}}</td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td rowspan="3">17</td>
                <td width="50%"><b>{{$t('Аvtotransport vositalari soni (saroydan foydalanish koeffitsienti 0,8 xisobga olinganda)')}}</b></td>
                <td>{{form.auto_trans_count}}</td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }}-{{ form.reyses_to_name }}</td>
                <td>
                  {{form.auto_trans_count_from}}
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }}-{{ form.reyses_from_name }}</td>
                <td>
                  {{form.auto_trans_count_to}}
                </td>
              </tr>
              <tr>
                <td>18</td>
                <td width="50%"><b>{{$t('Minimal ball')}}</b></td>
                <td>{{form.minimum_bal}}</td>
              </tr>
            </tbody>
          </table>
          <div class="text_place">
            <label for="text">{{$t('Matn')}}</label>
            <textarea id="text" class="form-control" v-model="form.text" disabled></textarea>
          </div>
       <!--    <div class="btn_send d-flex justify-content-end">
            <button type="button" class="btn btn-primary" @click.prevent="saveData">
              <i class="fas fa-save"></i>
              {{$t('Saqlash')}}
            </button>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import PassportTab from "../stepuser/PassportTab";
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
      type:{},
      laoding: true
    };
  },
  async mounted(){
    // await this.actionEditCarrierDirection(this.$route.params.directionId);
    let data ={
      generate:0,
      id:this.$route.params.directionId
    }
    await this.actionDemand(data);
    this.laoding = false
    if(this.getDemand.success){
        this.form = this.getDemand.result
        this.type = this.getDemand.type
    }else{
        toast.fire({
            type: 'error',
            icon: 'error',
            title: this.getDemand.message,
        })
    }
    },
  computed: {
    ...mapGetters("direction", ["getCarrierDirection"]),
    ...mapGetters("passportTab", ['getDemand']),
  },
  methods: {
    ...mapActions("direction", ["actionEditCarrierDirection"]),
    ...mapActions("passportTab", ['actionDemand']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    getSeasonalName(name){
      if (name == 'always') {
        return this.$t('Doimiy');
      }
      else if (name == 'seasonal') {
        return this.$t('Mavsumiy');
      }
    },
    // async refreshDemand(){
    //   let data = {
    //     generate:1,
    //     id:this.$route.params.directionId
    //   }
    //   await this.actionDemand(data);
    //   this.form = this.getDemand.result;
    //   if(this.getDemand.error){
    //     toast.fire({
    //       type: "error",
    //       icon: "error",
    //       title: this.getDemand.message,
    //     });
    //   }
    // },
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
