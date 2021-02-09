<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
      <div class="card card_with_tabs">
        <div class="card-header tabCard">
            <PassportTab/>
        </div>
        <div class="card-body">
        <form @submit.prevent.enter="saveDirection" enctype="multipart/form-data">
          <div class="row">
            <div class="form-group col-md-3">
              <label for="type_id">Yo'nalish klasifikatsiyasi</label>
              <select
                class="form-control input_style"
                v-model="form.type_id"
                :class="isRequired(form.type_id) ? 'isRequired' : ''"
              >
                <option value selected disabled>choose option</option>
                <option
                  :value="item.id"
                  v-for="(item,index) in getTypeofdirectionList"
                >{{item.name }} {{item.type}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Passport raqami</label>
              <input
                type="text"
                v-model="form.pass_number"
                class="form-control input_style"
                :class="isRequired(form.pass_number) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">
                Shaxardan, viloyatdan
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
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">
                Tumandan, qishloqdan, shaxridan
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
                placeholder="Area"
                @change="selectArea('region_from')"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in areaFrom">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">
                Bekatdan
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
                placeholder="Area"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in stationFrom">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">
                Shaxarga, viloyatga
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
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">
                Tumanga, qishloqga, shaxriga
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
                placeholder="Area"
                @change="selectArea('region_to')"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in areaTo">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">
                Bekatga
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
                :class="isRequired(form.region_to.station_id) ? 'isRequired' : ''"
                placeholder="Area"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in stationTo">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="seasonal">Ishlash mavsumi</label>
              <select
                class="form-control input_style"
                v-model="form.seasonal"
                :class="isRequired(form.seasonal) ? 'isRequired' : ''"
                placeholder="Area"
              >
                <option value selected disabled>choose option</option>
                <option value="always">Doimiy</option>
                <option value="seasonal">Mavsumiy</option>
              </select>
            </div>
            <div class="col-md-4 input_radios_block">
              <p>Qaysi tarafdan</p>
              <div class="form-group input_radio_with_label" v-for="(item,index) in destinations">
                <input
                  type="radio"
                  v-model="form.from_where"
                  name="from_where"
                  :id="'from_where'+index"
                  :value="item"
                />
                <label :for="'from_where'+index">{{item ? item.name : ''}}</label>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Yo'nalish ochilish sanasi</label>
              <date-picker
                lang="ru"
                type="date" format="DD-MM-YYYY" valueType="format"
                v-model="form.year"
                class="input_style"
                :class="isRequired(form.year) ? 'isRequired' : ''"
              ></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label for="profitability">Рентабельность</label>
              <select
                class="form-control input_style"
                v-model="form.profitability"
                :class="isRequired(form.profitability) ? 'isRequired' : ''"
              >
                <option value="profitable">Рентабельный</option>
                <option value="unprofitable">Нерентабельный</option>
                <option value="middle">Средный</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="profitability">Йуналишнинг тури</label>
              <select
                class="form-control input_style"
                v-model="form.dir_type"
                :class="isRequired(form.dir_type) ? 'isRequired' : ''"
              >
                <option value="bus">Автобус йуналиши</option>
                <option value="taxi">Йўналиши тахи йуналиши</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Yonalish masofasi</label>
              <input
                type="number"
                v-model="form.distance"
                class="form-control input_style"
                step="0.01"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="tarif">Tarif</label>
              <input
                type="number"
                v-model="form.tarif"
                class="form-control input_style"
                disabled
              />
            </div>
            <div class="col-lg-12" v-if="cars_with.length > 0">
              <div class="d-flex justify-content-center">
                <h3><strong>Автотранспорты</strong></h3>
              </div>
              <div class="row" v-for="(car,index) in cars_with">
                <div class="form-group col-md-3">
                  <label :for="'bustype_id'+index">Категория Авто</label>
                  <input type="text" class="form-control input_style" :value="car.bustype.name" disabled>
                </div>
                <div class="form-group col-md-2">
                  <label for="tclass_id">Класс Авто</label>
                  <input type="text" class="form-control input_style" :value="car.tclass ? car.tclass.name : ''" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="busmarka_id">Марка Авто</label>
                  <input type="text" class="form-control input_style" :value="car.marka ? car.marka.name : ''" disabled>
                </div>
                <div class="form-group col-md-3">
                  <label for="busmodel_id">Модель Авто</label>
                  <input type="text" class="form-control input_style" :value="car.model ? car.model.name : ''" disabled>
                </div>
                <div class="form-group col-md-1 btn_remove_auto">
                  <button type="button" class="btn btn-dark" @click.prevent="removeEditCar(car.id)">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-lg-12" v-if="cars.length > 0">
              <div class="d-flex justify-content-center">
                <h3><strong>Добавленные автотранспорты</strong></h3>
              </div>
              <div class="row" v-for="(car,index) in cars">
                <h4 class="car_index">{{index+1}})</h4>
                <div class="form-group col-md-2">
                  <label :for="'bustype_id'+index">Категория Авто</label>
                  <select
                    class="form-control input_style"
                    :id="'bustype_id'+index"
                    placeholder="Номер Авто"
                    v-model="car.bustype_id"
                    :class="isRequired(car.bustype_id) ? 'isRequired' : ''"
                    @change="selectClass(car)"
                  >
                    <option value="" selected disabled>Выберите категорию авто!</option>
                    <option
                      :value="busType.id"
                      v-for="(busType,index) in getTypeofbusList"
                    >{{busType.name}}</option>
                  </select>
                </div>
                <div class="form-group col-md-2">
                  <label for="tclass_id">Класс Авто</label>
                  <select
                    class="form-control input_style"
                    id="tclass_id"
                    placeholder="Номер Авто"
                    v-model="car.tclass_id"
                    :class="isRequired(car.tclass_id) ? 'isRequired' : ''"
                    @change="selectMarka(car)"
                  >
                    <option value="" selected disabled>Выберите класс авто!</option>
                    <option :value="busClass.id" v-for="(busClass,index) in car.tclasses">{{busClass.name}}</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label for="busmarka_id">Марка Авто</label>
                  <select
                    class="form-control input_style"
                    id="busmarka_id"
                    placeholder="Номер Авто"
                    v-model="car.busmarka_id"
                    @change="selectModel(car)"
                  >
                    <option value="" selected disabled>Выберите марку авто!</option>
              <!-- <option :value="item.marka.id" v-for="(item,index) in car.bus_marks">{{item.marka.name}}</option> -->
              <option :value="item.id" v-for="(item,index) in getBusBrandList">{{item.name}}</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label for="busmodel_id">Модель Авто</label>
                  <select
                    class="form-control input_style"
                    id="busmodel_id"
                    placeholder="Номер Авто"
                    v-model="car.busmodel_id"
                  >
                    <option value="" selected disabled>Выберите модель авто!</option>
              <!-- <option :value="item.model.id" v-for="(item,index) in car.bus_models">{{item.model.name}}</option> -->
              <option :value="item.id" v-for="(item,index) in getBusmodelFindList">{{item.name}}</option>
                  </select>
                </div>
                <div class="form-group col-md-1 btn_remove_auto">
                  <button type="button" class="btn btn-danger" @click.prevent="removeCar(index)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-12">
              <div class="row">
                <div class="col-md-6">
                  <button type="button" class="btn btn-success btn_save_category" @click.prevent="sendToActivate">
                    <i class="far fa-share-square"></i>
                    Отправить на подтверждение
                  </button>
                </div>
                <div class="col-md-6 form_btn d-flex justify-content-end">
                  <button type="button" class="btn btn-info btn_save_category mr-3" @click.prevent="addCar">
                    <i class="fas fa-plus"></i>
                    Добавить авто
                  </button>
                  <button type="submit" class="btn btn-primary btn_save_category">
                    <i class="fas fa-save"></i>
                    Сохранить
                  </button>
                </div>
              </div>
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
        from_where: {},
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
      laoding: true,
      fromChoosenName:{},
      toChoosenName:{},
    };
  },
  watch:{
    getDirection:{
      handler(){
        this.laoding = false
        this.form.dir_type = this.getDirection.dir_type;
        this.form.pass_number = this.getDirection.pass_number;
        this.form.tarif = this.getDirection.tarif;
        this.form.region_from.region_id = this.getDirection.region_from_id ? this.getDirection.region_from_id : '';
        this.form.region_from.area_id = this.getDirection.area_from_id ? this.getDirection.area_from_id : '';
        this.form.region_from.station_id = this.getDirection.station_from_id ? this.getDirection.station_from_id : '';
        this.form.region_to.region_id = this.getDirection.region_to_id ? this.getDirection.region_to_id : '';
        this.form.region_to.area_id = this.getDirection.area_to_id ? this.getDirection.area_to_id : '';
        this.form.region_to.station_id = this.getDirection.station_to_id ? this.getDirection.station_to_id : '';
        this.form.year = this.getDirection.year.toString();
        this.form.from_type = this.getDirection.from_type;
        this.form.to_type = this.getDirection.to_type;
        this.form.from_where.id = this.getDirection.from_where.id;
        this.form.seasonal = this.getDirection.seasonal;
        this.form.distance = this.getDirection.distance;
        this.form.type_id = this.getDirection.type_id;
        this.cars_with = this.getDirection.cars_with;
        this.areaFrom = this.getDirection.region_from_with.area;
        this.areaTo = this.getDirection.region_to_with.area;
        this.stationFrom =  this.getDirection.area_from_with ? this.getDirection.area_from_with.station : '';
        this.stationTo = this.getDirection.area_to_with ? this.getDirection.area_to_with.station : '';
        this.loaded = true
        console.log(this.getDirection)
      }
    },
    'form.region_from':{
      handler(){

        if(this.getDirection.from_type){
          this.form.from_type = this.getDirection.from_type;
        }else{
          this.form.from_type = ''
        }
      },deep:true
    },
    'form.region_to':{
      handler(){
        if(this.getDirection.to_type){
          this.form.to_type = this.getDirection.to_type;
        }else{
          this.form.to_type = ''
        }
      },deep:true
    },
    'form.from_type':{
      handler(){
        let fromId = this.form.region_from[this.form.from_type + '_id']
        if(this.form.from_type == 'region'){

          if(this.getRegionList.find(item => item.id === fromId)){
            this.fromChoosenName = this.getRegionList.find(item => item.id === fromId)
          }else{
            toast.fire({
              type: "error",
              icon: "error",
              title: 'Shahar yoki viloyat tanlang!'
            });
          }
        }
        else if(this.form.from_type == 'area'){

          if (this.areaFrom.find(item => item.id === fromId)) {
            this.fromChoosenName = this.areaFrom.find(item => item.id === fromId)
          }else{
            toast.fire({
              type: "error",
              icon: "error",
              title: 'Tuman yoki qishloqni tanlang!'
            });
          }
        }
        else if(this.form.from_type == 'station'){
          if(this.stationFrom.find(item => item.id === fromId)){
            this.fromChoosenName = this.stationFrom.find(item => item.id === fromId)
          }else{
            toast.fire({
              type: "error",
              icon: "error",
              title: 'Bekatni tanlang!'
            });
          }
        }
      },deep:true
    },
    'form.to_type':{
      handler(){
        let toId = this.form.region_to[this.form.to_type + '_id']
        if(this.form.to_type == 'region'){
          if (this.getRegionList.find(item => item.id === toId)) {
            this.toChoosenName = this.getRegionList.find(item => item.id === toId)
          }else{
            toast.fire({
              type: "error",
              icon: "error",
              title: 'Shahar yoki viloyat tanlang!'
            });
          }
        }
        else if(this.form.to_type == 'area'){
          if(this.areaTo.find(item => item.id === toId)){
            this.toChoosenName = this.areaTo.find(item => item.id === toId)
          }else{
            toast.fire({
              type: "error",
              icon: "error",
              title: 'Tuman yoki qishloqni tanlang!'
            });
          }
        }
        else if(this.form.to_type == 'station'){
          if(this.stationTo.find(item => item.id === toId)){
            this.toChoosenName = this.stationTo.find(item => item.id === toId)
          }else{
            toast.fire({
              type: "error",
              icon: "error",
              title: 'Bekatni tanlang!'
            });
          }
        }
      },deep:true
    }
  },
  async mounted() {
    // this.$route.push(`/crm/direction/titul-tab/${this.$route.params.directionId}`)
    await this.actionRegionList();
    await this.actionTypeofbusList();
    await this.actionTypeofdirectionList();
    await this.actionEditDirection(this.$route.params.directionId);
    await this.actionBusBrandList();
    this.laoding = false
    this.form.pass_number = this.getDirection.pass_number;
    this.form.dir_type = this.getDirection.dir_type;
    this.form.tarif = this.getDirection.tarif;
    this.form.region_from.region_id = this.getDirection.region_from_id ? this.getDirection.region_from_id : '';
    this.form.region_from.area_id = this.getDirection.area_from_id ? this.getDirection.area_from_id : '';
    this.form.region_from.station_id = this.getDirection.station_from_id ? this.getDirection.station_from_id : '';
    this.form.region_to.region_id = this.getDirection.region_to_id ? this.getDirection.region_to_id : '';
    this.form.region_to.area_id = this.getDirection.area_to_id ? this.getDirection.area_to_id : '';
    this.form.region_to.station_id = this.getDirection.station_to_id ? this.getDirection.station_to_id : '';
    this.form.year = this.getDirection.year.toString();
    // if (this.getDirection.from_type) {
    //   this.form.from_type = this.getDirection.from_type;
    // }else{
    //   this.form.from_type = ''
    // }
    // if (this.getDirection.to_type) {
    //   this.form.to_type = this.getDirection.to_type;
    // }else{
    //   this.form.to_type = ''
    // }
    // this.form.to_type = this.getDirection.to_type;
    this.form.from_where = this.getDirection.from_where;
    this.form.seasonal = this.getDirection.seasonal;
    this.form.distance = this.getDirection.distance;
    this.form.type_id = this.getDirection.type_id;
    this.cars_with = this.getDirection.cars_with;
    this.areaFrom = this.getDirection.region_from_with.area;
    this.areaTo = this.getDirection.region_to_with.area;
    this.stationFrom =  this.getDirection.area_from_with ? this.getDirection.area_from_with.station : '';
    this.stationTo = this.getDirection.area_to_with ? this.getDirection.area_to_with.station : '';
    this.loaded = true
  },
  methods: {
    ...mapActions('typeofbus',['actionTypeofbusList']),
    ...mapActions('busclass',['actionBusclassFind']),
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionXromAreaList"]),
    ...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
    ...mapActions("direction", ["actionEditDirection","actionCarDeleteDirection"]),
    ...mapActions("passportTab", ["actionTarif"]),
    ...mapActions("direction", ["actionUpdateDirection"]),
    ...mapActions("busbrand", ["actionBusBrandList"]),
    ...mapActions("busmodel", ["actionBusmodelFindList"]),
    ...mapActions('confirmtitul',['actionApproveTitul']),
    async sendToActivate(){
      await this.actionApproveTitul(this.$route.params.directionId)
      if (this.getTitulMassage.success){
        await this.actionEditDirection(this.$route.params.directionId);
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
    },
    async removeEditCar(id){
      if(confirm("Вы действительно хотите удалить?")){
        await this.actionCarDeleteDirection(id)
        if (this.getMassage.success){
          await this.actionEditDirection(this.$route.params.directionId);
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getMassage.message,
          });
        }
      }
    },
    async selectClass(car){
      car.tclass_id = ''
      car.busmarka_id = ''
      car.busmodel_id = ''
      if (car.bustype_id) {
        let data = {
          'bustype_id':car.bustype_id,
        }
        await this.actionBusclassFind(data)
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
    //   car.busmodel_id = ''
    //   car.bus_models = car.bus_marks.filter((item,index)=>{
    //     if (item.marka.id == car.busmarka_id){
    //       return item
    //     }
    //   })
      car.busmodel_id = ''
      await this.actionBusmodelFindList(car)
    },
    removeCar(index){
      Vue.delete(this.cars,index)
    },
    addCar(){
      this.cars.push(
        {
          bustype_id:'',
          tclass_id:'',
          busmarka_id:'',
          busmodel_id:'',
          tclasses:[],
          bus_models:[],
          bus_marks:[],
        })
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async sendDirection(){
      this.laoding = true
      await this.actionEditDirection(this.$route.params.directionId);
      this.laoding = false
    },
    async saveDirection() {
      if (
        this.form.pass_number != "" &&
        this.form.year != "" &&
        this.form.type_id != ""  &&
        this.form.region_from.region_id != ""  &&
        this.form.region_to.region_id != ""  &&
        this.form.from_where &&
        this.form.seasonal != ""
      ) {
        if (this.checkCars) {
          this.laoding = true
          this.form['id'] = this.$route.params.directionId
          this.form['cars'] = this.cars
          await this.actionUpdateDirection(this.form);
          this.laoding = false
          if (this.getMassage.success) {
            toast.fire({
              type: "success",
              icon: "success",
              title: this.getMassage.message,
            });
            // this.$router.push(`/crm/direction/edit/${this.getMassage.id}`);
            this.cars = []
            await this.actionEditDirection(this.$route.params.directionId);
          } else {
            toast.fire({
              type: "error",
              icon: "error",
              title: this.getMassage.message,
            });
          }
          this.requiredInput = false;
        }
        else{
          toast.fire({
            type: "error",
            icon: "error",
            title: 'Заполните все поля!'
          });
        }
      } else {
        this.requiredInput = true;
      }
    },
    async selectRegion(input) {
      await this.actionXromAreaList({ region_id: this.form[input].region_id });
      if(input == 'region_from'){
        this.areaFrom = this.getAreaXromLists
        this.fromChoosenName = {}
        this.form.region_from.area_id = ''
        this.form.region_from.station_id = ''
        this.stationFrom = []
      }else if(input == 'region_to'){
        this.areaTo = this.getAreaXromLists
        this.form.region_to.area_id = ''
        this.toChoosenName = {}
        this.form.region_to.station_id = ''
        this.stationTo = []
      }
    },
    async selectArea(input) {
      await this.actionStationByRegion({
        region_id: this.form[input].region_id,
        area_id: this.form[input].area_id,
      });
      if(input == 'region_from'){
        this.stationFrom = this.getStationsList
        this.form.region_from.station_id = ''
        this.fromChoosenName = {}
      }else if(input == 'region_to'){
        this.stationTo = this.getStationsList
        this.form.region_to.station_id = ''
        this.toChoosenName = {}
      }
    },
  },
  computed: {
    ...mapGetters('busclass',['getBusclassFindList']),
    ...mapGetters('typeofbus',['getTypeofbusList']),
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaXromLists"]),
    ...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
    ...mapGetters("station", ["getStationsList"]),
    ...mapGetters("direction", ["getDirection",'getMassage']),
    ...mapGetters("passportTab", ["getTarif"]),
    ...mapGetters("busbrand", ["getBusBrandList"]),
    ...mapGetters("busmodel", ["getBusmodelFindList"]),
    ...mapGetters('confirmtitul',['getTitulMassage']),
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
    destinations(){
      // let from = null;
      // let to = null;
      // let itemsFrom = []
      // let itemsTo = []
      let arr = [null,null];
      if(this.fromChoosenName){
        arr[0] = this.fromChoosenName
      }
      if(this.toChoosenName){
        arr[1] = this.toChoosenName
      }
      return arr
    }
    // destinations() {
    //   let from = null;
    //   let to = null;
    //   let itemsFrom = [];
    //   let itemsTo = [];
    //   let arr = [null, null];
    //   if (this.form.region_from.region_id && this.form.region_to.region_id) {
    //     if (this.form.region_from.region_id == this.form.region_to.region_id) {
    //       // If region_from 'id' is equal to region_to 'id'
    //       if (this.form.region_from.area_id == this.form.region_to.area_id) {
    //         // FROM
    //         itemsFrom = this.form.region_from.station_id
    //           ? this.stationFrom
    //           : this.areaFrom;
    //         from = this.form.region_from.station_id
    //           ? this.form.region_from.station_id
    //           : this.form.region_from.area_id;
    //         itemsFrom.forEach((item) => {
    //           if (item.id == from) {
    //             arr[0] = item;
    //           }
    //         });
    //         // TO
    //         itemsTo = this.form.region_to.station_id
    //           ? this.stationTo
    //           : this.areaTo;
    //         to = this.form.region_to.station_id
    //           ? this.form.region_to.station_id
    //           : this.form.region_to.area_id;
    //         itemsTo.forEach((item) => {
    //           if (item.id == to) {
    //             arr[1] = item;
    //           }
    //         });
    //       } else {
    //         // FROM
    //         itemsFrom = this.form.region_from.area_id
    //           ? this.areaFrom
    //           : this.getRegionList;
    //         from = this.form.region_from.area_id
    //           ? this.form.region_from.area_id
    //           : this.form.region_from.region_id;
    //         itemsFrom.forEach((item) => {
    //           if (item.id == from) {
    //             arr[0] = item;
    //           }
    //         });
    //         // TO
    //         itemsTo = this.form.region_to.area_id
    //           ? this.areaTo
    //           : this.getRegionList;
    //         to = this.form.region_to.area_id
    //           ? this.form.region_to.area_id
    //           : this.form.region_to.region_id;
    //         itemsTo.forEach((item) => {
    //           if (item.id == to) {
    //             arr[1] = item;
    //           }
    //         });
    //       }
    //     } else {
    //       // FROM
    //       itemsFrom = this.form.region_from.area_id
    //         ? this.areaFrom
    //         : this.getRegionList;
    //       from = this.form.region_from.area_id
    //         ? this.form.region_from.area_id
    //         : this.form.region_from.region_id;
    //       itemsFrom.forEach((item) => {
    //         if (item.id == from) {
    //           arr[0] = item;
    //         }
    //       });
    //       // TO
    //       itemsTo = this.form.region_to.area_id
    //         ? this.areaTo
    //         : this.getRegionList;
    //       to = this.form.region_to.area_id
    //         ? this.form.region_to.area_id
    //         : this.form.region_to.region_id;
    //       itemsTo.forEach((item) => {
    //         if (item.id == to) {
    //           arr[1] = item;
    //         }
    //       });
    //     }
    //     return arr;
    //   }
    // },
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
