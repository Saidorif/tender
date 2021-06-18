<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
    <div class="card card_with_tabs">
      <div class="card-header">
        <h4 class="title_user">
            <i class="peIcon fas fa-clipboard-check"></i>
            {{$t('Tahrirlash')}}
        </h4>
      </div>
      <div class="card-body">
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
                <td width="50%"><b>{{$t('Avtotransport vositasi markasini sinfi')}} </b></td>
                <td>
                  <div v-for="(item,index) in form.auto_model_class">
                      {{ item.tclass ? item.tclass.name : '' }}
                  </div>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td width="50%"><b>{{$t('Yoʼnalish turi')}} </b></td>
                <td>
                  <template v-if="form.dir_type">
                      {{form.dir_type == 'bus' ? $t('Avtobus yoʼnalishi') : $t('Yoʼnalishli taxi yoʼnalishi')}}
                  </template>
                </td>
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
                <td width="50%"><b>{{$t('Reyslar soni')}}</b></td>
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
          <div class="btn_gruops mt-5 d-flex justify-content-end">
              <button class="btn btn-danger mr-3" style="height:auto;" @click.prevent="rejectDmand()" >{{$t('Rad etish')}}</button>
              <button class="btn btn-success" @click.prevent="activeDmand()">{{$t('Tasdiqlash')}}</button>
          </div>
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
      laoding: true
    };
  },
    async mounted(){
        await this.actionDemandShow(this.$route.params.confirmdemandId);
        this.laoding = false
        this.form = this.getShowDemand
    },
  computed: {
    ...mapGetters("confirmdemand", ["getDemands","getShowDemand","getDemandConfirmMassage"]),
  },
  methods: {
    ...mapActions("confirmdemand", ["actionRejectDemand","actionDemandShow","actionActivateDemand", ]),
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
    async activeDmand(){
        await this.actionActivateDemand(this.$route.params.confirmdemandId);
        if(this.getDemandConfirmMassage.error){
            toast.fire({
                type: "error",
                icon: "error",
                title: this.getDemandConfirmMassage.message,
            });
        }else{
            toast.fire({
                type: "success",
                icon: "success",
                title: this.getDemandConfirmMassage.message,
            });
            this.$router.push("/crm/confirm-confirmdemand");
        }
    },
    async rejectDmand(){
        await this.actionRejectDemand(this.$route.params.confirmdemandId);
        if(this.getDemandConfirmMassage.error){
            toast.fire({
                type: "error",
                icon: "error",
                title: this.getDemandConfirmMassage.message,
            });
        }else{
            toast.fire({
                type: "success",
                icon: "success",
                title: this.getDemandConfirmMassage.message,
            });
            this.$router.push("/crm/confirm-confirmdemand");
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
