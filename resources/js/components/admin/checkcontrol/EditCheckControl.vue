<template>
  <div class="add_region">
    <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-file"></i>
          {{$t('Arizani tekshirish')}}
        </h4>
        <h3 class="ml-5">
          <b>{{getCompanyName}}</b>
        </h3>
        <div class="d-flex align-items-center">
          <router-link class="btn btn-primary back_btn" to="/crm/check-control">
            <span class="peIcon pe-7s-back"></span>
            {{$t('Orqaga')}}
          </router-link>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group col-md-12 table table-responsive mb-4" v-if="showCarInfos">
          <div class="d-flex justify-content-center text-center">
            <h4 class="app_title">
                {{$t('Yoʼnalishlarda ishlayotganda harakatlanish xavfsizligini taʼminlash boʼyicha qatnashchi tomonidan amalga oshirilgan tadbirlar rejasi quyidagicha baholanadi')}}
            </h4>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr v-if="form.daily_technical_job == 1">
                <th width="50%">
                    {{$t('Аvtotransport vositalarini xar kuni reysdan oldingi texnik koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
                </th>
                <th class="text-center">
                  <span v-html="checkBox(form.daily_technical_job)"></span>
                </th>
                <th class="text-center">
                  <div class="badge" :class="targetStatusClass(form.daily_technical_job_status)">
                    {{targetStatusName(form.daily_technical_job_status)}}
                  </div>
                </th>
                <th>
                  <div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-danger mr-3" @click.prevent="rejectTargetModal('daily_technical_job_status')"  v-if="form.daily_technical_job == null">
                      <i class="fas fa-minus-circle"></i>
                      {{$t('Rad etish')}}
                    </button>
                    <button type="button" class="btn btn-success mr-3" @click.prevent="activeTargetCar('daily_technical_job_status')" v-if="form.daily_technical_job == null">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Tasdiqlash')}}
                    </button>
                    <button type="button" class="btn btn-info" @click.prevent="openFileModal('','daily_technical_job')">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Fayllar')}}
                    </button>
                  </div>
                </th>
              </tr>
              <tr v-if="form.daily_medical_job == 1">
                <th width="50%">
                    {{$t('Haydovchilarni har kungi tibbiy koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
                </th>
                <th class="text-center">
                  <span v-html="checkBox(form.daily_medical_job)"></span>
                </th>
                <th class="text-center">
                  <div class="badge" :class="targetStatusClass(form.daily_medical_job_status)">
                    {{targetStatusName(form.daily_medical_job_status)}}
                  </div>
                </th>
                <th>
                  <div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-danger mr-3" @click.prevent="rejectTargetModal('daily_medical_job_status')" v-if="form.daily_medical_job_status == null">
                      <i class="fas fa-minus-circle"></i>
                      {{$t('Rad etish')}}
                    </button>
                    <button type="button" class="btn btn-success mr-3" @click.prevent="activeTargetCar('daily_medical_job_status')" v-if="form.daily_medical_job_status == null">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Tasdiqlash')}}
                    </button>
                    <button type="button" class="btn btn-info" @click.prevent="openFileModal('','daily_medical_job')">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Fayllar')}}
                    </button>
                  </div>
                </th>
              </tr>
              <tr v-if="form.hours_rule == 1">
                <th width="50%">
                    {{$t('Taklif etilgan avtotransport vositalari sonidan kelib chiqib barcha haydovchilariga 30 soatlik dastur boʼyicha yoʼl harakati qoidalarini oʼrgatilgan')}}
                </th>
                <th class="text-center">
                  <span v-html="checkBox(form.hours_rule)"></span>
                </th>
                <th class="text-center">
                  <div class="badge" :class="targetStatusClass(form.hours_rule_status)">
                    {{targetStatusName(form.hours_rule_status)}}
                  </div>
                </th>
                <th>
                  <div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-danger" @click.prevent="rejectTargetModal('hours_rule_status')" v-if="form.hours_rule_status == null">
                      <i class="fas fa-minus-circle"></i>
                      {{$t('Rad etish')}}
                    </button>
                    <button type="button" class="btn btn-success mr-3 ml-3" @click.prevent="activeTargetCar('hours_rule_status')" v-if="form.hours_rule_status == null">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Tasdiqlash')}}
                    </button>
                    <button type="button" class="btn btn-info" @click.prevent="openFileModal('','hours_rule')">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Fayllar')}}
                    </button>
                  </div>
                </th>
              </tr>
              <tr v-if="form.videoregistrator == 1">
                <th width="50%">
                     {{$t('Taklif etilgan barcha avtotransport vositalarining old oynalariga videoregistrator oʼrnatilgan')}}
                </th>
                <th class="text-center">
                  <span v-html="checkBox(form.videoregistrator)"></span>
                </th>
                <th class="text-center">
                  <div class="badge" :class="targetStatusClass(form.videoregistrator_status)">
                    {{targetStatusName(form.videoregistrator_status)}}
                  </div>
                </th>
                <th>
                  <div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-danger" @click.prevent="rejectTargetModal('videoregistrator_status')" v-if="form.videoregistrator_status == null">
                      <i class="fas fa-minus-circle"></i>
                      {{$t('Rad etish')}}
                    </button>
                    <button type="button" class="btn btn-success mr-3 ml-3" @click.prevent="activeTargetCar('videoregistrator_status')" v-if="form.videoregistrator_status == null">
                      <i class="fas fa-check-circle"></i>
                        {{$t('Tasdiqlash')}}
                    </button>
                    <button type="button" class="btn btn-info" @click.prevent="openFileModal('','videoregistrator')">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Fayllar')}}
                    </button>
                  </div>
                </th>
              </tr>
              <tr v-if="form.gps == 1">
                <th width="50%">
                    {{$t('Taklif etilgan barcha avtotransport vositalarini GPS rejimida masofadan kuzatish tizimiga ulangan')}}
                </th>
                <th class="text-center">
                  <span v-html="checkBox(form.gps)"></span>
                </th>
                <th class="text-center">
                  <div class="badge" :class="targetStatusClass(form.gps_status)">
                    {{targetStatusName(form.gps_status)}}
                  </div>
                </th>
                <th>
                  <div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-danger" @click.prevent="rejectTargetModal('gps_status')" v-if="form.gps_status == null">
                      <i class="fas fa-minus-circle"></i>
                      {{$t('Rad etish')}}
                    </button>
                    <button type="button" class="btn btn-success mr-3 ml-3" @click.prevent="activeTargetCar('gps_status')" v-if="form.gps_status == null">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Tasdiqlash')}}
                    </button>
                    <button type="button" class="btn btn-info" @click.prevent="openFileModal('','gps')">
                      <i class="fas fa-check-circle"></i>
                      {{$t('Fayllar')}}
                    </button>
                  </div>
                </th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="accordion" id="accordionExample" v-if="cars.length > 0">
          <div class="d-flex justify-content-center">
            <h4>{{$t('Avtomobillar')}}</h4>
          </div>
          <div class="card-body">
            <h3><strong>{{$t('Kiritilgan maʼlumotalar')}}</strong></h3>
            <div class=" table-responsive table">
              <table class="table table-hover table-bordered text-center">
                <thead>
                  <tr>
                    <th>№</th>
                    <th>{{$t('Holati')}}</th>
                    <th>{{$t('Avtomobil raqami')}}</th>
                    <th>{{$t('Avtomobil turi')}}</th>
                    <th>{{$t('Avtomobil sinfi')}}</th>
                    <th>{{ $t('Avtobus markasi')}}</th>
                    <th>{{$t('Avtomobil rusumi')}}</th>
                    <th>{{$t('yil')}}</th>
                    <th>{{$t('capacity')}}</th>
                    <th>{{$t('Oʼrindiqlar soni')}}</th>
                    <th>{{$t('Sovutgich (iqlim-nazorati tizimi)')}}</th>
                    <th>{{$t('Internet')}}</th>
                    <th>{{$t('Bioxojatxona')}}</th>
                    <th>{{$t('Аvtobusning nogironlarga va aholining boshqa xarakatlanishi cheklangan guruxlariga moslashganligi')}}</th>
                    <th>{{$t('Telefon quvvatlagichlari')}}</th>
                    <th>{{$t('Xar bir oʼrindiqda monitor (planshet)')}}</th>
                    <th>{{$t('Bekatlarni eʼlon qilish audio tizimi')}}</th>
                    <th>{{$t('GAI maʼlumoti')}}</th>
                    <th>{{$t('Natarius maʼlumoti')}}</th>
                    <th class="wd12">{{$t('Nazorat')}}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(car_items,car_index) in cars">
                    <td>
                      <b>{{car_index + 1}}</b>
                    </td>
                    <td>
                      <div class="badge" :class="getCarStatusClass(car_items.status)">
                        {{getCarStatusName(car_items.status)}}
                      </div>
                      <div class="badge" :class="getLicenseStatusClass(car_items.license_status)">
                        {{getLicenseStatusName(car_items.license_status)}}
                      </div>
                    </td>
                    <td>
                      <b>{{car_items.auto_number}}</b>
                    </td>
                    <td>
                      <b>{{car_items.bustype ? car_items.bustype.name : ''}}</b>
                    </td>
                    <td>
                      <b>{{car_items.tclass ? car_items.tclass.name : ''}}</b>
                    </td>
                    <td>
                      <b>{{car_items.busmarka ? car_items.busmarka.name : ''}}</b>
                    </td>
                    <td>
                      <b>{{car_items.busmodel ? car_items.busmodel.name : ''}}</b>
                    </td>
                    <td>{{car_items.date}}</td>
                    <td>{{car_items.capacity}}</td>
                    <td>{{car_items.seat_qty}}</td>
                    <td>
                      <span v-html="checkBox(car_items.conditioner)"></span>
                    </td>
                    <td>
                      <span v-html="checkBox(car_items.internet)"></span>
                    </td>
                    <td>
                      <span v-html="checkBox(car_items.bio_toilet)"></span>
                    </td>
                    <td>
                      <span v-html="checkBox(car_items.bus_adapted)"></span>
                    </td>
                    <td>
                      <span v-html="checkBox(car_items.telephone_power)"></span>
                    </td>
                    <td>
                      <span v-html="checkBox(car_items.monitor)"></span>
                    </td>
                    <td>
                      <span v-html="checkBox(car_items.station_announce)"></span>
                    </td>
                    <td>
                      <h2 class="text-primary text-center" v-if="car_items.gai">
                        <i class="fas fa-file-alt" @click.prevent="showGai(car_items)"></i>
                      </h2>
                      <h2 class="text-secondary text-center" v-else>
                        <i class="fas fa-file-alt"></i>
                      </h2>
                    </td>
                    <td>
                      <h2 class="text-primary text-center" v-if="car_items.adliya">
                        <i class="fas fa-file-alt" @click.prevent="showAdliya(car_items.adliya)"></i>
                      </h2>
                      <h2 class="text-secondary text-center" v-else>
                        <i class="fas fa-file-alt"></i>
                      </h2>
                    </td>
                    <td>
                      <div class="col-lg-12 d-flex flex-column">
                        <button type="button" class="btn btn-danger mb-2" @click.prevent="openModal(car_items)" >
                          <i class="fas fa-minus-circle"></i>
                          {{$t('Rad etish')}}
                        </button>
                        <button type="button" class="btn btn-success mb-2" @click.prevent="activeCar(car_items.id)" v-if="form.tender_status == 'active'">
                          <i class="fas fa-check-circle"></i>
                          {{$t('Tasdiqlash')}}
                        </button>
                        <button type="button" class="btn btn-info" @click.prevent="openFileModal(car_items.id,'car')">
                          <i class="fas fa-check-circle"></i>
                          {{$t('Fayllar')}}
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Gai Modal-->
          <div class="modal fade" id="gaiModal" tabindex="-1" role="dialog" aria-labelledby="gaiModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle"><strong> {{$t('GAI maʼlumotilari')}}</strong></h5>
                  <button type="button" class="close" @click.prevent="closeGaiModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h3><strong> {{$t('GAI maʼlumotilari')}}</strong></h3>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>{{$t('Аvtomobil tartib raqami')}}</th>
                        <th>{{$t('Kiritilgan maʼlumot')}}</th>
                        <th>{{$t('GAI maʼlumoti')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td><b>{{$t('Davlat raqami')}}</b></td>
                          <td>{{gaiItem.auto_number}}</td>
                          <td>{{gaiItem.gai ? gaiItem.gai.pNameOfClient : ''}}</td>
                        </tr>
                        <tr>
                          <td><b>{{$t('Avtomobil yili')}}</b></td>
                          <td>{{gaiItem.date}}</td>
                          <td>{{gaiItem.gai ? gaiItem.gai.pMadeofYear : ''}}</td>
                        </tr>
                        <tr>
                          <td><b>{{$t('Avtomobil turi')}}</b></td>
                          <td>{{gaiItem.bustype ? gaiItem.bustype.name : ''}}</td>
                          <td>{{gaiItem.gai ? gaiItem.gai.pTypeOfAuto : ''}}</td>
                        </tr>
                        <tr>
                          <td><b>{{$t('Avtomobil rusumi')}}</b></td>
                          <td>{{gaiItem.busmodel ? gaiItem.busmodel.name : ''}}</td>
                          <td>{{gaiItem.gai ? gaiItem.gai.pMarka : ''}}</td>
                        </tr>
                        <tr>
                          <td><b>{{$t('capacity')}}</b></td>
                          <td>{{gaiItem.capacity}}</td>
                          <td>{{gaiItem.gai ? gaiItem.gai.pNumberofplace : ''}}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click.prevent="closeGaiModal">{{$t('Yopish')}}</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Natarius Modal-->
          <div class="modal fade" id="natariusModal" tabindex="-1" role="dialog" aria-labelledby="natariusModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle"><strong>{{$t('Adliya vazirligi maʼlumotlari')}}</strong></h5>
                  <button type="button" class="close" @click.prevent="closeNatariusModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h3><strong>{{$t('Adliya vazirligi maʼlumotlari')}}</strong></h3>
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th>{{$t('Avtomobil raqami')}}</th>
                        <th>{{$t('Egasi')}}</th>
                        <th>{{$t('INN')}}</th>
                        <th>{{$t('Notarius hujjat sanasi')}}</th>
                        <th>{{$t('Notarius hujjat reestr raqami')}}</th>
                        <th>{{$t('Notarius hujjati muddati')}}</th>
                      </tr>
                    </thead>
                    <tbody v-if="natariusItem">
                      <tr>
                        <td>{{natariusItem.auto_number}}</td>
                        <td>{{natariusItem.nameOwner}}</td>
                        <td>{{natariusItem.pINN}}</td>
                        <td>{{natariusItem.pDateNatarius}}</td>
                        <td>{{natariusItem.pNumberNatarius}}</td>
                        <td>{{natariusItem.expirationDate}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click.prevent="closeNatariusModal">{{$t('Yopish')}}</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal start-->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle"><strong>{{$t('Izohlar')}}</strong></h5>
                  <button type="button" class="close" @click.prevent="closeModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="technical_status">
                        <input
                          type="checkbox"
                          id="technical_status"
                          true-value="1"
                          false-value="0"
                          v-model="carItem.technical_status"
                          :disabled="form.tender_status != 'active'"
                        >
                        {{$t('Avtotransport vositasi texnik soz holatda')}}
                      </label>
                    </div>
                    <div class="form-group">
                      <label for="textAuto">{{$t('Matn')}} </label>
                      <textarea
                        class="form-control"
                        id="textAuto"
                        v-model="carItem.text"
                        :disabled="form.tender_status != 'active'"
                      ></textarea>
                    </div>
                    <div class="form-group">
                      <label for="fileAuto">{{$t('Fayl')}}</label>
                      <input
                        type="file"
                        ref="fileupload"
                        class="form-control"
                        id="fileAuto"
                        :disabled="form.tender_status != 'active'"
                        @change="changePhoto($event)"
                      />
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click.prevent="closeModal">{{$t('Yopish')}}</button>
                  <button type="button" class="btn btn-success" @click.prevent="denyCar" v-if="form.tender_status == 'active'">
                    <i class="fas fa-save"></i>
                    {{$t('Saqlash')}}
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- File Modal start-->
          <div class="modal fade" id="exampleFileModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleFileModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle"><strong>{{$t('Fayllar')}}</strong></h5>
                  <button type="button" class="close" @click.prevent="closeFileModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form enctype="multipart/form-data">
                    <div class="row">
                      <div class="form-group col-md-2 file_width mb40" v-for="(f,index) in getControlFiles">
                        <img :src='"/"+f.file'>
                        <button class="btn btn-danger" type="button" @click.prevent="removeCarFile(f.id)">
                          <i class="fas fa-trash"></i>
                          {{$t('Oʼchirish')}}
                        </button>
                      </div>
                      <div class="form-group col-md-2 mb40">
                        <label for="targetFile">
                          <div class="file_width">
                            <img src="/f.png" alt="">
                          </div>
                        </label>
                        <input
                          type="file"
                          ref="fileupload"
                          class="hidden"
                          id="targetFile"
                          @change="changeCarFile($event)"
                        />
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click.prevent="closeFileModal">{{$t('Yopish')}}</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import { mapGetters, mapActions } from "vuex";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Multiselect,
    Loader
  },
  data() {
    return {
      form:{
        tarif:'',
        direction_id:'',
        daily_medical_job:0,
        daily_technical_job:0,
        videoregistrator:0,
        gps:0,
        qty_reys:'',
        hours_rule:0,
      },
      cars:[],
      makeDisabled: true,
      laoding: true,
      carItem:{
        id:'',
        file:'',
        text:'',
        technical_status:0
      },
      tests:[],
      natariusItem:{},
      gaiItem:{},
      company_name:'',
      myFile:'',
      carId:'',
      myFileName:'',
      carType:'',
    };
  },
  watch:{
    getAppCars:{
      handler(){
        this.form = this.getAppCars;
        this.cars = this.getAppCars.cars_with;
        this.company_name = this.getAppCars.user.company_name;
      }
    }
  },
  computed: {
    ...mapGetters("checkcontrol",["getAppCars",'getStatusMessage','getStatusLicense','getControlFiles']),
    getCompanyName(){
      return this.company_name  ? this.company_name : 'Без название'
    },
    showCarInfos(){
      if(this.form.daily_technical_job == 1 || this.form.daily_medical_job == 1 || this.form.hours_rule == 1 || this.form.videoregistrator == 1 || this.form.gps == 1){
        return true
      }else{
        return false
      }
    }
  },
  async mounted(){
    await this.actionAppCars(this.$route.params.appId);
    $('#exampleModalCenter').modal({backdrop: 'static',keyboard: true, show: false});
    this.laoding = false
  },
  methods: {
    ...mapActions("checkcontrol", [
      "actionControlRemoveFile",
      "actionAppCars",
      "actionAppTarget",
      'actionStatusMessage',
      'actionCloseLot',
      'actionCheckLicense',
      'actionControlFiles',
      'actionControlStoreFile',
    ]),
    targetStatusClass(name){
      if(name == 1){
        return 'badge-success'
      }else if(name == 0){
        return 'badge-danger'
      }else{
        return 'badge-secondary'
      }
    },
    targetStatusName(name){
      if(name == 1){
        return this.$t('Tasdiqlangan')
      }else if(name == 0){
        return this.$t('Rad etilgan')
      }else{
        return this.$('Tekshirilmagan');
      }
    },
    showGai(item){
      this.gaiItem = item
      $('#gaiModal').modal('show')
    },
    closeGaiModal(){
      this.gaiItem = {}
      $('#gaiModal').modal('hide')
    },
    showAdliya(item){
      this.natariusItem = item
      $('#natariusModal').modal('show')
    },
    closeNatariusModal(){
      this.natariusItem = {}
      $('#natariusModal').modal('hide')
    },
    async checkLicense(){
      let inn = this.form.user ? this.form.user.inn : null
      if(confirm(this.$('Litsenziyalarni tekshirishni xohlaysizmi?'))){
        this.laoding = true
        await this.actionCheckLicense(inn)
        if (this.getStatusLicense.success){
          await this.actionAppCars(this.$route.params.appId);
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getStatusLicense.message
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getStatusLicense.message
          });
        }
        this.laoding = false
      }
    },
    openModal(item){
      this.$refs.fileupload.value='';
      $("#exampleModalCenter").modal('show')
      this.carItem = item
    },
    async rejectTargetModal(target){
      if(confirm(this.$t("Haqiqatan ham rad etmoqchimisiz?"))){
        let data = {
          target:target,
          app_id:Number(this.$route.params.appId),
          status:0,
        }
        this.laoding = true
        await this.actionAppTarget(data);
        if (this.getStatusMessage.success) {
          await this.actionAppCars(this.$route.params.appId);
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getStatusMessage.message
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getStatusMessage.message
          });
        }
        this.laoding = false
      }
    },
    async activeTargetCar(target){
      if(confirm(this.$t("Siz chindan ham tasdiqlamoqchimisiz?"))){
        let data = {
          target:target,
          app_id:Number(this.$route.params.appId),
          status:1,
        }
        this.laoding = true
        await this.actionAppTarget(data);
        if (this.getStatusMessage.success) {
          await this.actionAppCars(this.$route.params.appId);
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getStatusMessage.message
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getStatusMessage.message
          });
        }
        this.laoding = false
      }
    },
    async removeCarFile(id){
      if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
        this.laoding = true
        await this.actionControlRemoveFile(id)
        if(this.getStatusMessage.success){
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getStatusMessage.message
          });
          let data = {
            app_id:this.$route.params.appId,
            type:this.carType,
            car_id:this.carId,
          }
          await this.actionControlFiles(data)
        }
        this.laoding = false
      }
    },
    closeFileModal(){
      $('#exampleFileModalCenter').modal('hide')
      this.carId = ''
      this.myFile = ''
    },
    async openFileModal(item,type){
      $("#exampleFileModalCenter").modal('show')
      this.carId = item != '' ? item.toString() : ''
      this.carType = type
      let data = {
        app_id:this.$route.params.appId,
        type:type,
        car_id:this.carId,
      }
      await this.actionControlFiles(data)
    },
    removeFile(){
      this.carItem.file = ''
    },
    changePhoto(event){
      let file = event.target.files[0];
      this.carItem.file = file
    },
    async changeCarFile(event){
      let file = event.target.files[0];
      this.myFile = file
      if(event.target.files[0]['type'].includes('image')){
        if (file.size > 1048576){
            swal.fire({
              type: 'error',
              text:this.$t('Rasm hajmi bilgilangan limitdan kattaroq'),
            })
        }else{
          let reader = new FileReader();
          reader.onload = event=> {
            this.myFileName = event.target.result;
          }
          reader.readAsDataURL(file);
          let formData = new FormData();
          formData.append('file',this.myFile)
          formData.append('app_id',this.$route.params.appId)
          formData.append('type',this.carType)
          formData.append('car_id',this.carId)
          await this.actionControlStoreFile(formData)
          if(this.getStatusMessage.success){
            toast.fire({
              type: "success",
              icon: "success",
              title: this.getStatusMessage.message
            });
            this.myFile = ''
          }
          await this.actionControlFiles(formData)
        }
      }else{
        console.log(false)
      }

    },
    closeModal(){
      this.carItem.id = ''
      this.carItem.file = ''
      this.carItem.text = ''
      this.carItem.technical_status = ''
      this.$refs.fileupload.value='';
      $('#exampleModalCenter').modal('hide')
    },
    async completeLot(){
      // this.laoding = true
      await this.actionCloseLot(this.$route.params.appId)
      if (this.getStatusMessage.success) {
        await this.actionAppCars(this.$route.params.appId);
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getStatusMessage.message
        });
      }
      this.laoding = false
    },
    async denyCar(){
      $('#exampleModalCenter').modal('show')
      let form = new FormData()
      form.append('file', this.carItem.file);
      form.append('text', this.carItem.text);
      form.append('technical_status', this.carItem.technical_status);
      form.append('app_id', this.$route.params.appId);
      form.append('car_id', this.carItem.id);
      form.append('status', 'rejected');
      if(this.carItem.text != ''){
        this.laoding = true
        await this.actionStatusMessage(form)
        if (this.getStatusMessage.success) {
          await this.actionAppCars(this.$route.params.appId);
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getStatusMessage.message
          });
          this.closeModal()
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getStatusMessage.message
          });
        }
        this.laoding = false
      }else{
        toast.fire({
          type: "error",
          icon: "error",
          title: this.$t("Matn kiriting")
        });
      }
    },
    async activeCar(id){
      if(confirm(this.$t("Siz chindan ham tasdiqlamoqchimisiz?"))){
        let data = {
          app_id:this.$route.params.appId,
          car_id:id,
          status:'accepted',
        }
        this.laoding = true
        await this.actionStatusMessage(data)
        if (this.getStatusMessage.success) {
          await this.actionAppCars(this.$route.params.appId);
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getStatusMessage.message
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getStatusMessage.message
          });
        }
        this.laoding = false
      }
    },
    checkBox(check){
      if(check == 1){
        return '<i class="fas fa-check-circle text-success"></i>';
      }else{
        return '<i class="fas fa-times-circle text-danger"></i>';
      }
    },
    getStatusClass(name){
      if (name == 'active') {
        return 'badge-primary'
      }
      else if(name == 'accepted'){
        return 'badge-success'
      }
      else{
        return 'badge-danger'
      }
    },
    getStatusName(name){
      if (name == 'active'){
        return this.$t('Faol')
      }else if(name == 'accepted'){
        return this.$t('Tasdiqlangan')
      }else{
        return this.$t('Nofaol')
      }
    },
    getCarStatusName(status){
      if (status == 'active'){
        return this.$t('Tekshirilmagan')
      }else if(status == 'accepted'){
        return this.$t('Tasdiqlangan')
      }else if(status == 'rejected'){
        return this.$t('Rad etilgan')
      }
    },
    getCarStatusClass(status){
      if (status == 'active'){
        return 'badge-primary'
      }else if(status == 'accepted'){
        return 'badge-success'
      }else if(status == 'rejected'){
        return 'badge-danger'
      }
    },
    getLicenseStatusName(status){
      if(status == 0){
        return this.$t('Litsenziyalanmagan')
      }else if(status == 1){
        return this.$t('Litsenziyalangan')
      }
    },
    getLicenseStatusClass(status){
      if(status == 0){
        return 'badge-warning'
      }else if(status == 1){
        return 'badge-success'
      }
    },
  },
};
</script>
<style scoped>
.cursor_plus{
  cursor: pointer;
}
.hidden{
  display: none;
}
.mb40{
  margin-bottom: 50px;
}
.file_width{
  height: 100px;
}
.file_width img{
  width: 100%;
  height: 100%;
  border: 1px solid #f3dddd;
}
.file_width button{
  width: 101px;
  border-radius: 0;
  padding: 0;
  height: 24px;
}
.wd12{
  width: 12%;
}
tr {
  cursor: pointer !important;
}
tr.active {
  background: #d6d6d6;
}
.check_box_with_label {
}
.check_box_with_label input {
  --active: #275efe;
  --active-inner: #fff;
  --focus: 2px rgba(39, 94, 254, 0.3);
  --border: #bbc1e1;
  --border-hover: #275efe;
  --background: #fff;
  --disabled: #f6f8ff;
  --disabled-inner: #e1e6f9;
  -webkit-appearance: none;
  -moz-appearance: none;
  height: 21px;
  outline: none;
  display: inline-block;
  vertical-align: top;
  position: relative;
  margin: 0;
  cursor: pointer;
  border: 1px solid var(--bc, var(--border));
  background: var(--b, var(--background));
  -webkit-transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
  transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
  width: 38px;
  border-radius: 11px;
  min-height: unset;
}
.check_box_with_label input::after {
  content: "";
  display: block;
  position: absolute;
  -webkit-transition: opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  transition: opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  transition: transform var(--d-t, 0.3s) var(--d-t-e, ease),
    opacity var(--d-o, 0.2s);
  transition: transform var(--d-t, 0.3s) var(--d-t-e, ease),
    opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  left: 2px;
  top: 2px;
  border-radius: 50%;
  width: 15px;
  height: 15px;
  background: var(--ab, var(--border));
  -webkit-transform: translateX(var(--x, 0));
  transform: translateX(var(--x, 0));
}
.check_box_with_label label {
  display: block;
  cursor: pointer;
  margin-bottom: 15px;
}
.check_box_with_label input[type="checkbox"]:checked {
  --ab: var(--active-inner);
  --x: 17px;
  --b: var(--active);
  --bc: var(--active);
  --d-o: 0.3s;
  --d-t: 0.6s;
  --d-t-e: cubic-bezier(0.2, 0.85, 0.32, 1.2);
}
input.disabled {
  cursor: not-allowed;
}
.cardtender {
  padding: 0;
  box-shadow: none;
  background-color: rgba(0, 0, 0, 0.03);
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
}
.cardtender .card-header {
  background: #f3f3f4;
}
.without_padding {
  padding: 0px !important;
}
.without_padding ul {
  margin-bottom: 0px;
}
.without_padding li {
  text-align: center;
}
.list-inline li {
  border-bottom: 1px solid #000;
}
.list-inline li:last-child {
  border: none;
}
</style>
