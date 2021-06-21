<template>
  <div class="add_area">
    <Loader v-if="laoding" />
    <div class="card card_with_tabs">
      <div class="card-header tabCard">
        <PassportTab />
      </div>
      <div class="card-body">
        <div class="col-12 d-flex justify-content-end align-items-start mb-2"  v-if="getDemand.result">
            <span class="alert alert-success mr-2" v-if="getDemand.result.status == 'completed'" style="padding:6px 20px;">Подтвержден</span>
            <span class="alert alert-warning mr-2" v-if="getDemand.result.status == 'pending'" style="padding:6px 20px;">В ожидании</span>
            <span class="alert alert-danger mr-2" v-if="getDemand.result.status == 'active'" style="padding:6px 20px;">{{$t('Tasdiqlanmagan')}}</span>
        </div>
        <div class="row">
          <div class="form-group col-lg-12">
            <div class="row">
              <div class="col-md-6">
                <button type="button" class="btn btn-success btn_save_category" @click.prevent="sendToActivate">
                  <i class="far fa-share-square"></i>
                  {{$t('Yuvorish')}} на подтверждение
                </button>
              </div>
              <div class="col-md-6 form_btn d-flex justify-content-end">
                <button type="button" class="btn btn-info text-white" @click.prevent="refreshDemand">
                  <i class="fas fa-redo"></i>
                  Обнавить
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive" v-if="getDemand.result">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>1</td>
                <td width="50%"><b>{{$t('Avtotransport vositasi turi')}}</b></td>
                <td>
                  <template v-if="form.auto_model_class">
                    <div v-for="(item, index) in form.auto_model_class" >
                      {{ item && item.bustype ? item.bustype.name : '' }}
                    </div>
                  </template>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td width="50%">
                  <b>{{$t('Avtotransport vositasi markasini sinfi')}}</b>
                </td>
                <td>
                  <template v-if="form.auto_model_class">
                    <div v-for="(item, index) in form.auto_model_class">
                      <!-- {{ item.model ? item.model.name : '' }} -->
                      {{ item && item.tclass ? item.tclass.name : '' }}
                    </div>
                  </template>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td width="50%"><b>{{$t('Yoʼnalish turi')}}</b></td>
                <td>
                    {{form.dir_type == 'bus' ? $t('Avtobus yoʼnalishi') : $t('Yoʼnalishli taxi yoʼnalishi')}}
                </td>
              </tr>
              <!-- 4 -->
              <tr>
                <td rowspan="3">4</td>
                <td width="50%">
                  <b>{{$t('Ish rejasi')}}</b
                  >
                </td>
              </tr>
              <tr>
                <td>{{$t('Ish rejasi')}}</td>
                <td>
                  <textarea
                    rows="1"
                    v-model="form.auto_trans_working_days"
                    class="form-control"
                  ></textarea>
                </td>
              </tr>
              <tr>
                <td>{{$t('Dam olish kunlari')}}</td>
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
                <td width="50%"><b>{{$t('Avtotransport vositalari holati')}}</b></td>
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
                <td width="50%"><b>{{$t('Yunalishning umumiy uzunligi')}}</b></td>
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
                <td width="50%"><b>{{$t('Bekatlar soni')}}</b></td>
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
                <td width="50%"><b>{{$t('Mavsumiyligi')}}</b></td>
                <td>{{ getSeasonalName(form.seasonal) }}</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">9</td>
                <td width="50%"><b>{{$t('Reyslar (qatnovlar) soni')}}</b></td>
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
                <td width="50%"><b>{{$t('Dastlabki reys (ishni boshlash) vaqti')}}</b></td>
                <td>
                  <b>{{ form.schedule_begin_time }}</b>
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }} {{$t('tomondan')}}</td>
                <td>{{ form.schedule_begin_from }}</td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }} {{$t('tomondan')}}</td>
                <td>{{ form.schedule_begin_to }}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">11</td>
                <td width="50%"><b>{{$t('Soʼngi reys (ishni tugallanish) vaqti')}}</b></td>
                <td>
                  <b>{{ form.schedule_end_time }}</b>
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }} {{$t('tomondan')}}</td>
                <td>{{ form.schedule_end_from }}</td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }} {{$t('tomondan')}}</td>
                <td>{{ form.schedule_end_to }}</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td>12</td>
                <td width="50%"><b>{{$t('Bekatlar oraliq intervallari')}}</b></td>
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
                <td width="50%"><b>{{$t('Reys vaqti')}}</b></td>
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
                <td width="50%"><b>{{$t('Xarakatlanish jadvallari')}}</b></td>
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
                <td width="50%"><b>{{$t('Reyslar soni')}}</b></td>
                <td>
                  <b>{{ form.tarif }}</b>
                </td>
              </tr>
              <!-- v-if="getDemand.result.direction && getDemand.result.direction.type_id != 1" -->
              <tr v-if="getDemand.type && getDemand.type.id != 1">
                <td>
                  1 {{$t('km. uchun')}} йўл тариф (шаҳар атрофи, шаҳарлараро йўналишлар
                  учун)
                </td>
                <td>
                  1 {{$t('km. uchun')}} ({{ form.tarif_one_km }} сум). Йўл кира ҳаққи ({{ form.tarif_full_km }}
                  сум)
                </td>
              </tr>
              <tr v-if="getDemand.type && getDemand.type.id == 1">
                <td>{{$t('Yoʼl kira haqqi (shahar yoʼnalishlar uchun)')}}</td>
                <td v-if='form.dir_type == "taxi"' class="d-flex align-items-center">
                  <input
                    type="number"
                    v-model="form.tarif_city"
                    class="form-control w-50"
                  /> <span class="ml-2"><h5>сум</h5></span>
                </td>
                <td v-else>
                  {{ form.tarif_city }} сум
                </td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="2">16</td>
                <td width="50%">
                  <b>{{$t('Аvtotransport vositalarini umumiy sigʼimi')}}</b>
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
                <td>{{$t('Oʼrindiqlar soni')}}</td>
                <td>
                  <input
                    type="number"
                    v-model="form.transports_seats"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td rowspan="3">17</td>
                <td width="50%">
                  <b>Автотранспорт воситалари сони (саройдан фойдаланиш
                    коэффициенти 0,8 хисобга олинганда)</b>
                </td>
                <td>{{ form.auto_trans_count }}</td>
              </tr>
              <tr>
                <td>{{ form.reyses_from_name }}-{{ form.reyses_to_name }}</td>
                <td>
                  <input
                    type="number"
                    v-model="form.auto_trans_count_from"
                    class="form-control"
                  />
                </td>
              </tr>
              <tr>
                <td>{{ form.reyses_to_name }}-{{ form.reyses_from_name }}</td>
                <td>
                  <input
                    type="number"
                    v-model="form.auto_trans_count_to"
                    class="form-control"
                  />
                </td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>18</td>
                <td width="50%"><b>{{$t('Minimal ball')}}</b></td>
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
            <label for="text">{{$t('Matn')}}</label>
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
              {{$t('Saqlash')}}
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
    if(this.getDemand.success){
        this.form = this.getDemand.result;
    }
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
    ...mapGetters('confirmdemand',['getDemandConfirmMassage']),
  },
  methods: {
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ["actionDemand", "actionDemandSave"]),
    ...mapActions('confirmdemand',['actionApproveDemand']),
    async sendToActivate(){
      await this.actionApproveDemand(this.$route.params.directionId)
      if (this.getDemandConfirmMassage.success){
        await this.actionEditDirection(this.$route.params.directionId);
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getDemandConfirmMassage.message,
        });
      }else{
        toast.fire({
          type: "error",
          icon: "error",
          title: this.getDemandConfirmMassage.message,
        });
      }
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    getSeasonalName(name) {
      if (name == "always") {
        return this.$t('Doimiy');
      } else if (name == "seasonal") {
        return this.$t('Mavsumiy');
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
