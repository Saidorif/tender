<template>
  <div class="add_region">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-file"></i>
           {{$t('Avtomobillar')}}
        </h4>
        <h3 class="ml-5">
          <b>{{getCompanyName}}</b>
        </h3>
        <div class="d-flex align-items-center">
          <button type="button" class="btn btn-info mr-3" @click.prevent="completeLot">
            <i class="fas fa-check"></i>
            {{$t('Lotni yopish')}}
          </button>
          <router-link class="btn btn-primary back_btn" to="/crm/check-control">
            <span class="peIcon pe-7s-back"></span>
            {{$t('Orqaga')}}
          </router-link>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>{{$t('Аvtomobil tartib raqami')}}</th>
                <th colspan="2">{{$t('Kiritilgan maʼlumotalar')}}</th>
                <th>{{$t('GAI maʼlumoti')}}</th>
                <th>{{$t('Natarius maʼlumoti')}}</th>
                <th colspan="2">{{$t('Nazorat')}}</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(car,index) in cars">
                <tr>
                  <td rowspan="5">
                    <div class="text-center d-flex flex-column">
                      <b>{{index+1}}</b>
                      <div class="badge mt-2 mb-2" :class="getCarStatusClass(car.status)">
                        {{getCarStatusName(car.status)}}
                      </div>
                      <div class="badge" :class="getLicenseStatusClass(car.license_status)">
                        {{getLicenseStatusName(car.license_status)}}
                      </div>
                    </div>
                  </td>
                  <td><b>{{$t('Davlat raqami')}}</b></td>
                  <td>{{car.auto_number}}</td>
                  <td>{{car.gai ? car.gai.pNameOfClient : ''}}</td>
                  <td rowspan="5">
                      <h2 class="text-primary text-center" v-if="car.adliya">
                        <i class="fas fa-file-alt" @click.prevent="showAdliya(car.adliya)"></i>
                      </h2>
                      <h2 class="text-secondary text-center" v-else>
                        <i class="fas fa-file-alt"></i>
                      </h2>
                  </td>
                  <td rowspan="5">
                    <div class="d-flex flex-column">
                      <button type="button" class="btn btn-danger mb-2" @click.prevent="denyCar(car.id)">
                        <i class="fas fa-minus-circle"></i>
                        {{$t('Rad etish')}}
                      </button>
                      <button type="button" class="btn btn-success" @click.prevent="activeCar(car.id)">
                        <i class="fas fa-check-circle"></i>
                        {{$t('Tasdiqlash')}}
                      </button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><b>{{$t('Avtomobil yili')}}</b></td>
                  <td>{{car.date}}</td>
                  <td>{{car.gai ? car.gai.pMadeofYear : ''}}</td>
                </tr>
                <tr>
                  <td><b>{{$t('Avtomobil turi')}}</b></td>
                  <td>{{car.bustype ? car.bustype.name : ''}}</td>
                  <td>{{car.gai ? car.gai.pTypeOfAuto : ''}}</td>
                </tr>
                <tr>
                  <td><b>{{$t('Avtomobil rusumi')}}</b></td>
                  <td>{{car.busmodel ? car.busmodel.name : ''}}</td>
                  <td>{{car.gai ? car.gai.pMarka : ''}}</td>
                </tr>
                <tr>
                  <td><b>{{$t('capacity')}}</b></td>
                  <td>{{car.capacity}}</td>
                  <td>{{car.gai ? car.gai.pNumberofplace : ''}}</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal start-->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle"><strong>{{$t('Adliya vazirligi maʼlumotlari')}}</strong></h5>
              <button type="button" class="close" @click.prevent="closeModal">
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
                <tbody v-if="modalItem">
                  <tr>
                    <td>{{modalItem.auto_number}}</td>
                    <td>{{modalItem.nameOwner}}</td>
                    <td>{{modalItem.pINN}}</td>
                    <td>{{modalItem.pDateNatarius}}</td>
                    <td>{{modalItem.pNumberNatarius}}</td>
                    <td>{{modalItem.expirationDate}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click.prevent="closeModal">{{$t('Yopish')}}</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal end -->
  <!--     <div class="card-body">
        <div class="accordion" id="accordionExample" v-if="cars.length > 0">
          <div class="card" v-for="(car_items,car_index) in cars">
            <div class="card-header btn-block d-flex justify-content-between">
                <button
                  class="text-left"
                  type="button"
                  :id="'headingOne'+car_index"
                  data-toggle="collapse"
                  data-target="#collapseOne"
                  aria-expanded="true"
                  aria-controls="collapseOne"
                >
                  <b>{{car_items.auto_number}}</b>
                </button>
                <div>
                  <div class="badge" :class="getCarStatusClass(car_items.status)">
                    {{getCarStatusName(car_items.status)}}
                  </div>
                  <div class="badge" :class="getLicenseStatusClass(car_items.license_status)">
                    {{getLicenseStatusName(car_items.license_status)}}
                  </div>
                </div>
            </div>
            <div
              id="collapseOne"
              class="collapse"
              :class="car_index == 0 ? 'show' : ''"
              :aria-labelledby="'headingOne'+car_index"
              data-parent="#accordionExample"
            >
              <div class="card-body">
                <h3><strong>Вводные данные</strong></h3>
                <div class=" table-responsive table">
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th>{{$t('Holati')}}</th>
                        <th>Категория Авто</th>
                        <th>Класс Авто</th>
                        <th>Марка Авто</th>
                        <th>Модель Авто</th>
                        <th>Дата выпуска</th>
                        <th>Количество рейсов</th>
                        <th>Вместимость</th>
                        <th>Количество сидящих</th>
                        <th>Кондиционер (климат-назорати тизими)</th>
                        <th>Интернет</th>
                        <th>Биохожатхона</th>
                        <th>Автобуснинг ногиронларга ва аҳолининг бошқа харакатланиши чекланган мослашганлиги</th>
                        <th>Телефон қувватлагичлари</th>
                        <th>Хар бир ўриндиқда монитор (планшет)</th>
                        <th>Бекатларни эълон қилиш аудио тизими</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="badge" :class="getStatusClass(car_items.status)">
                            {{getStatusName(car_items.status)}}
                          </div>
                        </td>
                        <td>{{car_items.bustype ? car_items.bustype.name : ''}}</td>
                        <td width="5%">{{car_items.tclass ? car_items.tclass.name : ''}}</td>
                        <td>{{car_items.busmarka ? car_items.busmarka.name : ''}}</td>
                        <td>{{car_items.busmodel ? car_items.busmodel.name : ''}}</td>
                        <td>{{car_items.date}}</td>
                        <td>{{car_items.qty_reys}}</td>
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
                      </tr>
                    </tbody>
                  </table>
                </div>
                <hr>
                <template v-if="car_items.adliya.length > 0">
                  <h3><strong>Минюст данные</strong></h3>
                  <div class=" table-responsive table">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Номер Авто</th>
                          <th>Хозяин</th>
                          <th>ИНН</th>
                          <th>Дата нотариального {{$t('Tahrirlash')}}</th>
                          <th>Номер реестра нотариального {{$t('Tahrirlash')}}</th>
                          <th>Срок нотариального {{$t('Tahrirlash')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(adliya,adliya_index) in car_items.adliya">
                          <td>{{adliya.auto_number}}</td>
                          <td>{{adliya.nameOwner}}</td>
                          <td>{{adliya.pINN}}</td>
                          <td>{{adliya.pDateNatarius}}</td>
                          <td>{{adliya.pNumberNatarius}}</td>
                          <td>{{adliya.expirationDate}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </template>
                <hr>
                <template v-if="car_items.gai.length > 0">
                  <h3><strong>ГАИ данные</strong></h3>
                  <div class=" table-responsive table">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Номер Авто</th>
                          <th>Хозяин</th>
                          <th>Марка</th>
                          <th>Вместимость</th>
                          <th>Тип машины</th>
                          <th>Дата выпуска</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(gai,gai_index) in car_items.gai">
                          <td>{{gai.pPlateNumber}}</td>
                          <td>{{gai.pNameOfClient}}</td>
                          <td>{{gai.pMarka}}</td>
                          <td>{{gai.pNumberofplace}}</td>
                          <td>{{gai.pTypeOfAuto}}</td>
                          <td>{{gai.pMadeofYear}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </template>
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger mr-2" @click.prevent="denyCar(car_items.id)">
                      <i class="fas fa-minus-circle"></i>
                      Отказ
                    </button>
                    <button type="button" class="btn btn-success" @click.prevent="activeCar(car_items.id)">
                      <i class="fas fa-check-circle"></i>
                      Подтвердить
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
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
      cars:[],
      laoding: true,
      company_name:'',
      modalItem:{},
    };
  },
  watch:{
    getAppCars:{
      handler(){
        this.cars = this.getAppCars.cars_with;
        this.company_name = this.getAppCars.user.company_name;
      }
    }
  },
  computed: {
    ...mapGetters("checkcontrol", ["getAppCars",'getStatusMessage']),
    getCompanyName(){
      return this.company_name  ? this.company_name : 'Без название'
    },
  },
  async mounted() {
    await this.actionAppCars(this.$route.params.appId);
    this.laoding = false
  },
  methods: {
    ...mapActions("checkcontrol", ["actionAppCars",'actionStatusMessage','actionCloseLot']),
    showAdliya(item){
      this.modalItem = item
      $('#exampleModalCenter').modal('show')
    },
    closeModal(){
      this.modalItem = {}
      $('#exampleModalCenter').modal('hide')
    },
    async completeLot(){
      this.laoding = true
      await this.actionCloseLot(this.$route.params.appId)
      if(this.getStatusMessage.success){
        await this.actionAppCars(this.$route.params.appId);
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getStatusMessage.message
        });
      }
      this.laoding = false
    },
    async denyCar(id){
      if(confirm("Вы действительно хотите отказаться?")){
        let data = {
          app_id:this.$route.params.appId,
          car_id:id,
          status:'rejected',
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
        }
        this.laoding = false
      }
    },
    async activeCar(id){
      if(confirm("Вы действительно хотите подтвердить?")){
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
        }
        this.laoding = false
      }
    },
    checkBox(check){
      if (check == 0) {
        return '<i class="fas fa-times-circle text-danger"></i>';
      }else if(check == 1){
        return '<i class="fas fa-check-circle text-success"></i>';
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
        return 'Активный'
      }else if(name == 'accepted'){
        return 'Подтверждено'
      }else{
        return 'Неактивный'
      }
    },
    getCarStatusName(status){
      if (status == 'active'){
        return 'Неподтверждено'
      }else if(status == 'accepted'){
        return 'Подтверждено'
      }else if(status == 'rejected'){
        return 'Отказано'
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
        return 'Нелицензирован'
      }else if(status == 1){
        return 'Лицензирован'
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
