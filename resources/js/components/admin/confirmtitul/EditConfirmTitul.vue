<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
      <div class="card card_with_tabs">
        <div class="card-header">
          <h4 class="title_user">
            <i class="peIcon fas fa-clipboard-check"></i>
            {{$t('Titulni tasdiqlash')}}
          </h4>
          <router-link class="btn btn-primary back_btn" to="/crm/confirm-titul">
            <span class="peIcon pe-7s-back"></span>
            {{$t('Orqaga')}}
          </router-link>
        </div>
        <div class="card-body">
        <form >
                <div class="row">
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="type_id">{{$t('Yoʼnalish klasifikatsiyasi')}}</label>
                    <select
                      class="form-control input_style"
                      v-model="form.type_id"
                      :class="isRequired(form.type_id) ? 'isRequired' : ''"
                      disabled
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option
                        :value="item.id"
                        v-for="(item,index) in getTypeofdirectionList"
                      >{{item.name }} {{item.type}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="seria">{{$t('Passport raqami')}}</label>
                    <input
                      disabled
                      type="text"
                      v-model="form.pass_number"
                      class="form-control input_style"
                      :class="isRequired(form.pass_number) ? 'isRequired' : ''"
                    />
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="region_id">
                      {{$t('Shaxardan, viloyatdan')}}
                      <input
                        type="radio"
                        name="name_from"
                        value="region"
                        v-model="form.from_type"
                        id="from_type_region"
                      />
                    </label>
                    <select
                      class="form-control input_style"
                      v-model="form.region_from.region_id"
                      :class="isRequired(form.region_from.region_id) ? 'isRequired' : ''"
                      @change="selectRegion('region_from')"
                      disabled
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="region_id">
                      {{$t('Tumandan, qishloqdan, shaxridan')}}
                      <input
                        v-model="form.from_type"
                        type="radio"
                        name="name_from"
                        value="area"
                        id="from_type_area"
                      />
                    </label>
                    <select
                      class="form-control input_style"
                      v-model="form.region_from.area_id"
                      :class="isRequired(form.region_from.area_id) ? 'isRequired' : ''"
                      disabled
                      @change="selectArea('region_from')"
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option :value="item.id" v-for="(item,index) in areaFrom">{{item.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="region_id">
                      {{$t('Bekatdan')}}
                      <input
                        v-model="form.from_type"
                        type="radio"
                        name="name_from"
                        value="station"
                        id="from_type_station"
                      />
                    </label>
                    <select
                      class="form-control input_style"
                      v-model="form.region_from.station_id"
                      :class="isRequired(form.region_from.station_id) ? 'isRequired' : ''"
                      disabled
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option :value="item.id" v-for="(item,index) in stationFrom">{{item.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                     <label for="region_id">
                      {{$t('Shaxarga, viloyatga')}}
                      <input
                        v-model="form.to_type"
                        type="radio"
                        name="name_to"
                        value="region"
                        id="to_type_region"
                      />
                    </label>
                    <select
                      class="form-control input_style"
                      v-model="form.region_to.region_id"
                      :class="isRequired(form.region_to.region_id) ? 'isRequired' : ''"
                      @change="selectRegion('region_to')"
                      disabled
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="region_id">
                      {{$t('Tumanga, qishloqga, shaxriga')}}
                      <input
                        v-model="form.to_type"
                        type="radio"
                        name="name_to"
                        value="area"
                        id="to_type_area"
                      />
                    </label>
                    <select
                      class="form-control input_style"
                      v-model="form.region_to.area_id"
                      :class="isRequired(form.region_to.area_id) ? 'isRequired' : ''"
                      disabled
                      @change="selectArea('region_to')"
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option :value="item.id" v-for="(item,index) in areaTo">{{item.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="region_id">
                      {{$t('Bekatga')}}
                      <input
                        v-model="form.to_type"
                        type="radio"
                        name="name_to"
                        value="station"
                        id="to_type_station"
                      />
                    </label>
                    <select
                      class="form-control input_style"
                      v-model="form.region_to.station_id"
                      disabled
                      :class="isRequired(form.region_to.station_id) ? 'isRequired' : ''"
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option :value="item.id" v-for="(item,index) in stationTo">{{item.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-2 col-md-6">
                    <label for="seasonal">{{$t('Ishlash mavsumi')}}</label>
                    <select
                      class="form-control input_style"
                      v-model="form.seasonal"
                      disabled
                      :class="isRequired(form.seasonal) ? 'isRequired' : ''"
                    >
                      <option value selected disabled>{{$t('Tanglang')}}</option>
                      <option value="always">{{$t('Doimiy')}}</option>
                      <option value="seasonal">{{$t('Mavsumiy')}}</option>
                    </select>
                  </div>
                  <div class="col-xl-4 col-md-6 input_radios_block">
                    <p>{{$t('Qaysi tarafdan')}}</p>
                    <div class="form-group input_radio_with_label" v-for="(item,index) in destinations">
                      <input
                        type="radio"
                        v-model="form.from_where"
                        name="from_where"
                        disabled
                        :id="'from_where'+index"
                        :value="item"
                      />
                      <label :for="'from_where'+index">{{item ? item.name : ''}}</label>
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="seria">{{$t('Yoʼnalish ochilish sanasi')}}</label>
                    <date-picker
                      lang="ru"
                      type="date" format="DD-MM-YYYY" valueType="format"
                      v-model="form.year"
                      class="input_style"
                      disabled
                      :class="isRequired(form.year) ? 'isRequired' : ''"
                    ></date-picker>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="profitability">{{$t('Rentabillik')}}</label>
                    <select
                      class="form-control input_style"
                      v-model="form.profitability"
                      disabled
                      :class="isRequired(form.profitability) ? 'isRequired' : ''"
                    >
                      <option value="profitable">{{$t('Samarali')}}</option>
                      <option value="unprofitable">{{$t('Samarasiz')}}</option>
                      <option value="middle">{{$t('Oʼrta')}}</option>
                    </select>
                  </div>
            <div class="form-group col-xl-3 col-md-6">
                    <label for="profitability">{{$t('Yoʼnalish turi')}}</label>
                    <select
                      class="form-control input_style"
                      v-model="form.dir_type"
                      disabled
                      :class="isRequired(form.dir_type) ? 'isRequired' : ''"
                    >
                      <option value="bus">{{$t('Avtobus yoʼnalishi')}}</option>
                      <option value="taxi">{{$t('Yoʼnalishli taxi yoʼnalishi')}}</option>
                    </select>
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="seria">{{$t('Yoʼnalish masofasi')}}</label>
                    <input
                      type="number"
                      v-model="form.distance"
                      disabled
                      class="form-control input_style"
                      step="0.01"
                    />
                  </div>
                  <div class="form-group col-xl-3 col-md-6">
                    <label for="tarif">{{$t('Tarif')}}</label>
                    <input
                      type="number"
                      v-model="form.tarif"
                      disabled
                      class="form-control input_style"
                      disabled
                    />
                  </div>
                  <div class="col-lg-12" v-if="cars_with.length > 0">
                    <div class="d-flex justify-content-center">
                      <h3><strong>{{$t('Avtotransportlar')}}</strong></h3>
                    </div>
                    <div class="row" v-for="(car,index) in cars_with">
                      <div class="form-group col-xl-3 col-md-6">
                        <label :for="'bustype_id'+index">{{$t('Avtomobil turi')}}</label>
                        <input type="text" class="form-control input_style" :value="car.bustype.name" disabled>
                      </div>
                      <div class="form-group col-xl-2 col-md-6">
                        <label for="tclass_id">{{$t('Avtomobil sinfi')}}</label>
                        <input type="text" class="form-control input_style" :value="car.tclass ? car.tclass.name : ''" disabled>
                      </div>
                      <div class="form-group col-xl-3 col-md-6">
                        <label for="busmarka_id">{{$t('Avtobus markasi')}}</label>
                        <input type="text" class="form-control input_style" :value="car.marka ? car.marka.name : ''" disabled>
                      </div>
                      <div class="form-group col-xl-3 col-md-6">
                        <label for="busmodel_id">{{$t('Avtomobil rusumi')}}</label>
                        <input type="text" class="form-control input_style" :value="car.model ? car.model.name : ''" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12" v-if="cars.length > 0">
                    <div class="d-flex justify-content-center">
                      <h3><strong>{{$t('Qoʼshilgan transport vositalari')}}</strong></h3>
                    </div>
                    <div class="row" v-for="(car,index) in cars">
                      <h4 class="car_index">{{index+1}})</h4>
                      <div class="form-group col-xl-2 col-md-6">
                        <label :for="'bustype_id'+index">{{$t('Avtomobil turi')}}</label>
                        <select
                          class="form-control input_style"
                          :id="'bustype_id'+index"
                          v-model="car.bustype_id"
                          disabled
                          :class="isRequired(car.bustype_id) ? 'isRequired' : ''"
                          @change="selectClass(car)"
                        >
                          <option value="" selected disabled>{{$t('Tanlang')}}!</option>
                          <option
                            :value="busType.id"
                            v-for="(busType,index) in getTypeofbusList"
                          >{{busType.name}}</option>
                        </select>
                      </div>
                      <div class="form-group col-xl-2 col-md-6">
                        <label for="tclass_id">{{$t('Avtomobil sinfi')}}</label>
                        <select
                          class="form-control input_style"
                          id="tclass_id"
                          disabled
                          v-model="car.tclass_id"
                          :class="isRequired(car.tclass_id) ? 'isRequired' : ''"
                          @change="selectMarka(car)"
                        >
                          <option value="" selected disabled>{{$t('Tanlang')}}!</option>
                          <option :value="busClass.id" v-for="(busClass,index) in car.tclasses">{{busClass.name}}</option>
                        </select>
                      </div>
                      <div class="form-group col-xl-3 col-md-6">
                        <label for="busmarka_id">{{$t('Avtobus markasi')}}</label>
                        <select
                          class="form-control input_style"
                          id="busmarka_id"
                          disabled
                          v-model="car.busmarka_id"
                          @change="selectModel(car)"
                        >
                          <option value="" selected disabled>{{$t('Tanlang')}}!</option>
                          <!-- <option :value="item.marka.id" v-for="(item,index) in car.bus_marks">{{item.marka.name}}</option> -->
                          <option :value="item.id" v-for="(item,index) in getBusBrandList">{{item.name}}</option>
                        </select>
                      </div>
                      <div class="form-group col-xl-3 col-md-6">
                        <label for="busmodel_id">{{$t('Avtomobil rusumi')}}</label>
                        <select
                          class="form-control input_style"
                          id="busmodel_id"
                          disabled
                          v-model="car.busmodel_id"
                        >
                          <option value="" selected disabled>{{$t('Tanlang')}}!</option>
                          <!-- <option :value="item.model.id" v-for="(item,index) in car.bus_models">{{item.model.name}}</option> -->
                          <option :value="item.id" v-for="(item,index) in getBusmodelFindList">{{item.name}}</option>
                        </select>
                      </div>
                      <div class="form-group col-md-1 btn_remove_auto"></div>
                    </div>
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
                </div>
            </form>
          </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Timing from "../steppassport/Timing";
import Scheme from "../steppassport/Scheme";
import Schedule from "../steppassport/Schedule";
import PassportTab from "../steppassport/PassportTab";
import Tarif from "../steppassport/Tarif";
import { mapGetters, mapActions } from "vuex";
import "vue2-datepicker/index.css";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Timing,
    Scheme,
    Tarif,
    PassportTab,
    Schedule,
    Loader
  },
  data() {
    return {
      form: {
        pass_number: "",
        tarif: "",
        region_from: {
          region_id: "",
          area_id: "",
          station_id: "",
        },
        region_to: {
          region_id: "",
          area_id: "",
          station_id: "",
        },
        from_type: "",
        to_type: "",
        year: "",
        from_where: "",
        seasonal: "",
        distance: "",
        type_id: "",
        dir_type: 'bus',
        profitability: "profitable",
      },
      cars:[],
      cars_with:[],
      areaFrom:[],
      areaTo:[],
      stationFrom:[],
      stationTo:[],
      requiredInput: false,
      laoding: true
    };
  },
  watch:{
    getShowTitul:{
      handler(){
        this.laoding = false
        this.form.dir_type = this.getShowTitul.dir_type;
        this.form.pass_number = this.getShowTitul.pass_number;
        this.form.tarif = this.getShowTitul.tarif;
        this.form.region_from.region_id = this.getShowTitul.region_from_id;
        this.form.region_from.area_id = this.getShowTitul.area_from_id;
        this.form.region_from.station_id = this.getShowTitul.station_from_id;
        this.form.region_to.region_id = this.getShowTitul.region_to_id;
        this.form.region_to.area_id = this.getShowTitul.area_to_id;
        this.form.region_to.station_id = this.getShowTitul.station_to_id;
        this.form.year = this.getShowTitul.year.toString();
        this.form.from_type = this.getShowTitul.from_type;
        this.form.to_type = this.getShowTitul.to_type;
        this.form.from_where = this.getShowTitul.from_where;
        this.form.seasonal = this.getShowTitul.seasonal;
        this.form.distance = this.getShowTitul.distance;
        this.form.type_id = this.getShowTitul.type_id;
        this.cars_with = this.getShowTitul.cars_with;
        this.areaFrom = this.getShowTitul.region_from_with.area;
        this.areaTo = this.getShowTitul.region_to_with.area;
        this.stationFrom =  this.getShowTitul.area_from_with ? this.getShowTitul.area_from_with.station : '';
        this.stationTo = this.getShowTitul.area_to_with ? this.getShowTitul.area_to_with.station : '';
        this.loaded = true
      }
    }
  },
  async mounted() {
    await this.actionRegionList();
    await this.actionTypeofbusList();
    await this.actionTypeofdirectionList();
    await this.actionTitulShow(this.$route.params.confirmtitulId);
    await this.actionBusBrandList();
    this.laoding = false
    this.form.pass_number = this.getShowTitul.pass_number;
    this.form.dir_type = this.getShowTitul.dir_type;
    this.form.tarif = this.getShowTitul.tarif;
    this.form.region_from.region_id = this.getShowTitul.region_from_id;
    this.form.region_from.area_id = this.getShowTitul.area_from_id;
    this.form.region_from.station_id = this.getShowTitul.station_from_id;
    this.form.region_to.region_id = this.getShowTitul.region_to_id;
    this.form.region_to.area_id = this.getShowTitul.area_to_id;
    this.form.region_to.station_id = this.getShowTitul.station_to_id;
    this.form.year = this.getShowTitul.year.toString();
    this.form.from_type = this.getShowTitul.from_type;
    this.form.to_type = this.getShowTitul.to_type;
    this.form.from_where = this.getShowTitul.from_where;
    this.form.seasonal = this.getShowTitul.seasonal;
    this.form.distance = this.getShowTitul.distance;
    this.form.type_id = this.getShowTitul.type_id;
    this.cars_with = this.getShowTitul.cars_with;
    this.areaFrom = this.getShowTitul.region_from_with.area;
    this.areaTo = this.getShowTitul.region_to_with.area;
    this.stationFrom =  this.getShowTitul.area_from_with ? this.getShowTitul.area_from_with.station : '';
    this.stationTo = this.getShowTitul.area_to_with ? this.getShowTitul.area_to_with.station : '';
    this.loaded = true
  },
  methods: {
    ...mapActions('typeofbus',['actionTypeofbusList']),
    ...mapActions('busclass',['actionBusclassFind']),
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
    ...mapActions("passportTab", ["actionTarif"]),
    ...mapActions("direction", ["actionUpdateDirection"]),
    ...mapActions("busbrand", ["actionBusBrandList"]),
    ...mapActions("busmodel", ["actionBusmodelFindList"]),
    ...mapActions('confirmtitul',['actionActivateTitul','actionRejectTitul','actionTitulShow']),
    async rejectTitul(){
      if(confirm("Вы действительно хотите отказатся?")){
        this.laoding = true
        await this.actionRejectTitul(this.$route.params.confirmtitulId)
        if (this.getTitulMassage.success){
          await this.actionTitulShow(this.$route.params.confirmtitulId);
          this.$router.push('/crm/confirm-titul')
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getTitulMassage.message,
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getTitulMassage.message,
          });
        }
        this.laoding = false
      }
    },
    async sendToActivate(){
        this.laoding = true
      await this.actionActivateTitul(this.$route.params.confirmtitulId)
      if (this.getTitulMassage.success){
        await this.actionTitulShow(this.$route.params.confirmtitulId);
        this.$router.push('/crm/confirm-titul')
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getTitulMassage.message,
        });
      }else{
        toast.fire({
          type: "error",
          icon: "error",
          title: this.getTitulMassage.message,
        });
      }
      this.laoding = false
    },
    async selectClass(car){
      car.tclass_id = ''
      car.busmarka_id = ''
      car.busmodel_id = ''
      if (car.bustype_id) {
        this.laoding = true
        let data = {
          'bustype_id':car.bustype_id,
        }
        await this.actionBusclassFind(data)
        this.laoding = false
        car.tclasses = this.getBusclassFindList
      }
    },
    async selectMarka(car){
      car.busmarka_id = ''
      car.busmodel_id = ''
      car.bus_marks = car.tclasses.filter((item,index)=>{
        if (item.id == car.tclass_id){
          return item
        }
      })
    },
    async selectModel(car){
      car.busmodel_id = ''
      this.laoding = true
      await this.actionBusmodelFindList(car)
      this.laoding = false
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async selectRegion(input) {
        this.laoding = true
        await this.actionAreaByRegion({ region_id: this.form[input].region_id });
        this.laoding = false
      if (input == "region_from") {
        this.areaFrom = this.getAreaList;
        this.form.area_from_id = "";
      } else if (input == "region_to") {
        this.areaTo = this.getAreaList;
        this.form.area_to_id = "";
      }
    },
    async selectArea(input) {
        this.laoding = true
      await this.actionStationByRegion({
        region_id: this.form[input].region_id,
        area_id: this.form[input].area_id,
      });
      this.laoding = false
      if (input == "region_from") {
        this.stationFrom = this.getStationsList;
        this.form.station_from_id = "";
      } else if (input == "region_to") {
        this.stationTo = this.getStationsList;
        this.form.station_to_id = "";
      }
    },
  },
  computed: {
    ...mapGetters('busclass',['getBusclassFindList']),
    ...mapGetters('typeofbus',['getTypeofbusList']),
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
    ...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("passportTab", ["getTarif"]),
    ...mapGetters("busbrand", ["getBusBrandList"]),
    ...mapGetters("busmodel", ["getBusmodelFindList"]),
    ...mapGetters('confirmtitul',['getTitulMassage','getShowTitul']),
    checkCars(){
      if(this.cars.length > 0){
        let result = true
        this.cars.forEach((item,index)=>{
          if (item.bustype_id != '' && item.tclass_id != '') {
            result = true
          }else{
            result = false
          }
        })
        return result;
      }else{
        return true
      }
    },
    destinations() {
      let from = null;
      let to = null;
      let itemsFrom = [];
      let itemsTo = [];
      let arr = [null, null];
      if (this.form.region_from.region_id && this.form.region_to.region_id) {
        if (this.form.region_from.region_id == this.form.region_to.region_id) {
          // If region_from 'id' is equal to region_to 'id'
          if (this.form.region_from.area_id == this.form.region_to.area_id) {
            // FROM
            itemsFrom = this.form.region_from.station_id
              ? this.stationFrom
              : this.areaFrom;
            from = this.form.region_from.station_id
              ? this.form.region_from.station_id
              : this.form.region_from.area_id;
            itemsFrom.forEach((item) => {
              if (item.id == from) {
                arr[0] = item;
              }
            });
            // TO
            itemsTo = this.form.region_to.station_id
              ? this.stationTo
              : this.areaTo;
            to = this.form.region_to.station_id
              ? this.form.region_to.station_id
              : this.form.region_to.area_id;
            itemsTo.forEach((item) => {
              if (item.id == to) {
                arr[1] = item;
              }
            });
          } else {
            // FROM
            itemsFrom = this.form.region_from.area_id
              ? this.areaFrom
              : this.getRegionList;
            from = this.form.region_from.area_id
              ? this.form.region_from.area_id
              : this.form.region_from.region_id;
            itemsFrom.forEach((item) => {
              if (item.id == from) {
                arr[0] = item;
              }
            });
            // TO
            itemsTo = this.form.region_to.area_id
              ? this.areaTo
              : this.getRegionList;
            to = this.form.region_to.area_id
              ? this.form.region_to.area_id
              : this.form.region_to.region_id;
            itemsTo.forEach((item) => {
              if (item.id == to) {
                arr[1] = item;
              }
            });
          }
        } else {
          // FROM
          itemsFrom = this.form.region_from.area_id
            ? this.areaFrom
            : this.getRegionList;
          from = this.form.region_from.area_id
            ? this.form.region_from.area_id
            : this.form.region_from.region_id;
          itemsFrom.forEach((item) => {
            if (item.id == from) {
              arr[0] = item;
            }
          });
          // TO
          itemsTo = this.form.region_to.area_id
            ? this.areaTo
            : this.getRegionList;
          to = this.form.region_to.area_id
            ? this.form.region_to.area_id
            : this.form.region_to.region_id;
          itemsTo.forEach((item) => {
            if (item.id == to) {
              arr[1] = item;
            }
          });
        }
        return arr;
      }
    },
  },
};
</script>
<style scoped>
  .btn_remove_auto{
    display:flex;
    align-items: center;
    margin-top: 30px;
  }
  .car_index{
    margin-top: 35px;
    margin-left: 15px;
  }
</style>
