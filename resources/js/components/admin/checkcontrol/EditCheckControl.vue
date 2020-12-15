<template>
  <div class="add_region">
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-file"></i>
          Лоты
        </h4>
        <h3 class="ml-5">
          <b>{{getCompanyName}}</b>
        </h3>
        <router-link class="btn btn-primary back_btn" to="/crm/check-control">
          <span class="peIcon pe-7s-back"></span>
          Назад
        </router-link>
      </div>
      <div class="card-body">
        <div class="accordion" id="accordionExample" v-if="cars.length > 0">

          <div class="card" v-for="(car_items,car_index) in cars">
            <div class="card-header btn-block d-flex justify-content-center"
              :id="'headingOne'+car_index"   
              data-toggle="collapse"
              data-target="#collapseOne"
              aria-expanded="true"
              aria-controls="collapseOne"
            >
              <h2 class="mb-0">
                <button
                  class="text-left"
                  type="button"
                >
                  <b>{{car_items.auto_number}}</b>
                </button>
              </h2>
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
                        <th>Статус</th>
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
                          <th>Номер реестра нотариального действия</th>
                          <th>Дата нотариального действия</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(adliya,adliya_index) in car_items.adliya">
                          <td>{{adliya.auto_number}}</td>
                          <td>{{adliya.nameOwner}}</td>
                          <td>{{adliya.pINN}}</td>
                          <td>{{adliya.pNumberNatarius}}</td>
                          <td>{{adliya.pDateNatarius}}</td>
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
                          <th>Адрес</th>
                          <th>Дата выпуска</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(gai,gai_index) in car_items.gai">
                          <td>{{gai.pPlateNumber}}</td>
                          <td>{{gai.pNameOfClient}}</td>
                          <td>{{gai.pMarka}}</td>
                          <td>{{gai.pAdressOfClient}}</td>
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
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    DatePicker,
    Multiselect,
  },
  data() {
    return {
      cars:[],
      company_name:''
    };
  },
  computed: {
    ...mapGetters("checkcontrol", ["getAppCars",'getDenyCar','getActiveCar']),
    getCompanyName(){
      return this.company_name  ? this.company_name : 'Без название'
    },
  },
  async mounted() {
    await this.actionAppCars(this.$route.params.appId);
    this.cars = this.getAppCars.cars_with;
    this.company_name = this.getAppCars.user.company_name;
    console.log(this.getAppCars)
  },
  methods: {
    ...mapActions("checkcontrol", ["actionAppCars",'actionActiveCar','actionDenyCar']),
    denyCar(id){
      if(confirm("Вы действительно хотите отказаться?")){
        console.log(id)
      }
    },
    activeCar(id){
      if(confirm("Вы действительно хотите подтвердить?")){
        console.log(id)
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
        return 'badge-success'
      }else{
        return 'badge-danger'
      }
    },
    getStatusName(name){
      if (name == 'active') {
        return 'Активный'
      }else{
        return 'Неактивный'
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
