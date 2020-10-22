<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-route"></i>
          Добавить направление
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/direction">
          <span class="peIcon pe-7s-back"></span> 
          Назад
        </router-link>
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
                <option value selected disabled>Variantni tanlang</option>
                <option
                  :value="item.id"
                  v-for="(item,index) in getTypeofdirectionList"
                >{{item.name }} {{item.type}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Passport raqami</label>
              <input
                type="number"
                v-model="form.pass_number"
                class="form-control input_style"
                :class="isRequired(form.pass_number) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Shaxardan, viloyatdan</label>
              <select
                class="form-control input_style"
                v-model="form.region_from.region_id"
                :class="isRequired(form.region_from.region_id) ? 'isRequired' : ''"
                @change="selectRegion('region_from')"
              >
                <option value selected disabled>Variantni tanlang</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Tumandan, qishloqdan, shaxridan</label>
              <select
                class="form-control input_style"
                v-model="form.region_from.area_id"
                placeholder="Area"
                @change="selectArea('region_from')"
              >
                <option value selected disabled>Variantni tanlang</option>
                <option :value="item.id" v-for="(item,index) in areaFrom">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Bekatdan</label>
              <select
                class="form-control input_style"
                v-model="form.region_from.station_id"
                placeholder="Area"
              >
                <option value selected disabled>Variantni tanlang</option>
                <option :value="item.id" v-for="(item,index) in stationFrom">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Shaxarga, viloyatga</label>
              <select
                class="form-control input_style"
                v-model="form.region_to.region_id"
                :class="isRequired(form.region_to.region_id) ? 'isRequired' : ''"
                @change="selectRegion('region_to')"
              >
                <option value selected disabled>Variantni tanlang</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="region_id">Tumanga, qishloqga, shaxriga,</label>
              <select
                class="form-control input_style"
                v-model="form.region_to.area_id"
                placeholder="Area"
                @change="selectArea('region_to')"
              >
                <option value selected disabled>Variantni tanlang</option>
                <option :value="item.id" v-for="(item,index) in areaTo">{{item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="region_id">Bakatga</label>
              <select
                class="form-control input_style"
                v-model="form.region_to.station_id"
                placeholder="Area"
              >
                <option value selected disabled>Variantni tanlang</option>
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
                <option value selected disabled>Variantni tanlang</option>
                <option value="always">Doimiy</option>
                <option value="seasonal">Mavsumiy</option>
              </select>
            </div>
            <div class="col-md-3 input_radios_block">
              <p>Qaysi tarafdan</p>
              <div class="form-group input_radio_with_label" v-for="(item,index) in destinations">
                <input
                  type="radio"
                  v-model="form.from_where"
                  name="from_where"
                  :id="'from_where'+index"
                  :value="item"
                />
                <label :for="'from_where'+index">{{item.name}}</label>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Yo'nalish ochilish sanasi</label>
              <date-picker 
                lang="ru" 
                type="year"
                v-model="form.year" 
                valueType="format" 
                class="input_style"
                :class="isRequired(form.year) ? 'isRequired' : ''"
                format="YYYY"
              ></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">Yonalish masofasi</label>
              <input
                type="number"
                v-model="form.distance"
                class="form-control input_style"
                :class="isRequired(form.distance) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="profitability">Рентабельность</label>
              <select
                class="form-control input_style"
                v-model="form.profitability"
                :class="isRequired(form.profitability) ? 'isRequired' : ''"
                placeholder="Area"
              >
                <option value="profitable">Рентабельный</option>
                <option value="unprofitable">Нерентабельный</option>
                <option value="middle">Средный</option>
              </select>
            </div>
            <div class="col-lg-12">
              <div class="d-flex justify-content-center">
                <h3><strong>Автотранспорты</strong></h3>
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
                    :class="isRequired(car.busmarka_id) ? 'isRequired' : ''"
                    @change="selectModel(car)"
                  >
                    <option value="" selected disabled>Выберите марку авто!</option>
                    <option :value="item.marka.id" v-for="(item,index) in car.bus_marks">{{item.marka.name}}</option>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label for="busmodel_id">Модель Авто</label>
                  <select
                    class="form-control input_style"
                    id="busmodel_id"
                    placeholder="Номер Авто"
                    v-model="car.busmodel_id"
                    :class="isRequired(car.busmodel_id) ? 'isRequired' : ''"
                  >
                    <option value="" selected disabled>Выберите модель авто!</option>
                    <option :value="item.model.id" v-for="(item,index) in car.bus_models">{{item.model.name}}</option>
                  </select>
                </div>
                <div class="form-group col-md-1 btn_remove_auto" v-if="cars.length > 1">
                  <button type="button" class="btn btn-danger" @click.prevent="removeCar(index)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
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
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import 'vue2-datepicker/index.css';
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Loader
  },
  data() {
    return {
      form: {
        pass_number: "",
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
        year: "",
        from_where: "",
        seasonal: "",
        distance: "",
        type_id: "",
        profitability: "profitability",
      },
      cars:[
        {
          bustype_id:'',
          tclass_id:'',
          busmarka_id:'',
          busmodel_id:'',
          tclasses:[],
          bus_models:[],
          bus_marks:[],
        }
      ],
      areaFrom:[],
      areaTo:[],
      stationFrom:[],
      stationTo:[],
      requiredInput: false,
      laoding: true
    };
  },
  async mounted() {
    await this.actionRegionList();
    await this.actionTypeofbusList();
    await this.actionTypeofdirectionList();
    this.laoding = false
  },
  methods: {
    ...mapActions('typeofbus',['actionTypeofbusList']),
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("station", ["actionStationByRegion"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
    ...mapActions("direction", ["actionAddDirection"]),
    ...mapActions('busclass',['actionBusclassFind']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async selectClass(car){
      // this.car.tclass_id = ''
      // this.car.busmarka_id = ''
      // this.car.busmodel_id = ''
      if (car.bustype_id) {
        let data = {
          'bustype_id':car.bustype_id,
        }
        await this.actionBusclassFind(data)
        car.tclasses = this.getBusclassFindList
      }
    },
    async selectMarka(car){
      // this.car.busmarka_id = ''
      // this.car.busmodel_id = ''
      car.bus_marks = car.tclasses.filter((item,index)=>{
        if (item.id == car.tclass_id) {
          return item
        }
      })
    },
    async selectModel(car){
      // this.car.busmodel_id = ''
      car.bus_models = car.bus_marks.filter((item,index)=>{
        if (item.marka.id == car.busmarka_id) {
          return item
        }
      })
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
    async saveDirection() {
      if (
        this.form.pass_number != "" &&
        this.form.year != "" &&
        this.form.distance != "" &&
        this.form.type_id != ""  &&
        this.form.region_from.region_id != ""  &&
        this.form.region_to.region_id != ""  &&
        this.form.from_where != "" &&
        this.form.seasonal != "" 
      ) {
        this.form['cars'] = this.cars
        this.laoding = true
        await this.actionAddDirection(this.form)
        this.laoding = false
    		if(this.getMassage.success){
    			toast.fire({
    				type: "success",
    				icon: "success",
    				title: this.getMassage.message
    			 });
    			this.$router.push(`/crm/direction/edit/${this.getMassage.result.id}`);
    		}else{
    			toast.fire({
    				type: "error",
    				icon: "error",
    				title: 'Whoops..Something went wrong!'
    			 });
    		}
      this.requiredInput = false;
      } else {
        this.requiredInput = true;
      }
    },
    async selectRegion(input) {
      await this.actionAreaByRegion({ region_id: this.form[input].region_id });
      if(input == 'region_from'){
        this.areaFrom = this.getAreaList
        this.form.region_from.area_id = '' 
      }else if(input == 'region_to'){
        this.areaTo = this.getAreaList
        this.form.region_to.area_id = '' 
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
      }else if(input == 'region_to'){
        this.stationTo = this.getStationsList
        this.form.region_to.station_id = '' 
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
    ...mapGetters("direction", ["getMassage"]),
    destinations(){
      let from = null;
      let to = null;
      let itemsFrom = []
      let itemsTo = []
      let arr = [null,null];
      if (this.form.region_from.region_id && this.form.region_to.region_id) {
        if(this.form.region_from.region_id == this.form.region_to.region_id){
        // If region_from 'id' is equal to region_to 'id'
          if (this.form.region_from.area_id == this.form.region_to.area_id){
            // FROM
            itemsFrom = this.form.region_from.station_id ? this.stationFrom : this.areaFrom
            from = this.form.region_from.station_id ? this.form.region_from.station_id : this.form.region_from.area_id
            itemsFrom.forEach(item =>{
              if (item.id == from) {
                arr[0] = item
              }
            })
            // TO
            itemsTo = this.form.region_to.station_id ? this.stationTo : this.areaTo
            to = this.form.region_to.station_id ? this.form.region_to.station_id : this.form.region_to.area_id
            itemsTo.forEach(item =>{
              if (item.id == to) {
                arr[1] = item
              }
            })
          }else{
            // FROM
            itemsFrom = this.form.region_from.area_id ? this.areaFrom : this.getRegionList
            from = this.form.region_from.area_id ? this.form.region_from.area_id : this.form.region_from.region_id
            itemsFrom.forEach(item =>{
              if (item.id == from) {
                arr[0] = item
              }
            })
            // TO
            itemsTo = this.form.region_to.area_id ? this.areaTo : this.getRegionList
            to = this.form.region_to.area_id ? this.form.region_to.area_id : this.form.region_to.region_id
            itemsTo.forEach(item =>{
              if (item.id == to) {
                arr[1] = item
              }
            })
          }
        }
        else{
          // FROM
          itemsFrom = this.form.region_from.area_id ? this.areaFrom : this.getRegionList
          from = this.form.region_from.area_id ? this.form.region_from.area_id : this.form.region_from.region_id
          itemsFrom.forEach(item =>{
            if (item.id == from) {
              arr[0] = item
            }
          })
          // TO
          itemsTo = this.form.region_to.area_id ? this.areaTo : this.getRegionList
          to = this.form.region_to.area_id ? this.form.region_to.area_id : this.form.region_to.region_id
          itemsTo.forEach(item =>{
            if (item.id == to) {
              arr[1] = item
            }
          })
        }
        return arr
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