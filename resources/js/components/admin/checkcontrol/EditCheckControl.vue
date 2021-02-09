<template>
  <div class="add_region">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-file"></i>
          Лоты
        </h4>
        <h3 class="ml-5">
          <b>{{getCompanyName}}</b>
        </h3>
        <div class="d-flex align-items-center">
          <button type="button" class="btn btn-info mr-3" @click.prevent="completeLot">
            <i class="fas fa-check"></i>
            Закрыть лот
          </button>
          <router-link class="btn btn-primary back_btn" to="/crm/check-control">
            <span class="peIcon pe-7s-back"></span>
            Назад
          </router-link>
        </div>
      </div>
      <div class="card-body">
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
                        <th>Статус</th>
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
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger mr-2" @click.prevent="openModal(car_items.id)">
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

          <!-- Modal start-->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle"><strong>Примечания</strong></h5>
                  <button type="button" class="close" @click.prevent="closeModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="technical_status">
                        <input type="checkbox" id="technical_status" true-value="1" false-value="0" v-model="carItem.technical_status">
                        Автотранспорт воситаси техник соз ҳолатда
                      </label>
                    </div>
                    <div class="form-group">
                      <label for="textAuto">Текст</label>
                      <textarea class="form-control" id="textAuto" v-model="carItem.text"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="fileAuto">Файл</label>
                      <input 
                        type="file" 
                        class="form-control" 
                        id="fileAuto" 
                        accept=".png, .jpg, .jpeg"
                        @change="changePhoto($event)"
                      />
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click.prevent="closeModal">Закрыть</button>
                  <button type="button" class="btn btn-success" @click.prevent="denyCar">
                    <i class="fas fa-save"></i>
                    Сохранить
                  </button>
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
      cars:[],
      laoding: true,
      carItem: {
        id:'',
        file:'',
        text:'',
        technical_status:0
      },
      tests:[],
      company_name:'',
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
    openModal(id){
      $("#exampleModalCenter").modal('show')
      this.carItem.id = id
    },
    removeFile(){
      this.carItem.file = ''
    },
    changePhoto(event){
      let file = event.target.files[0];
      this.carItem.file = file
    },
    closeModal(){
      this.carItem = {
        id:'',
        file:'',
        text:'',
        technical_status:0
      }
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
          title: "Вводите текст"
        });
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
