<template>
  <div class="add_region">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-file"></i>
          {{$t('Lotlar')}}
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/completed-tenders">
          <span class="peIcon pe-7s-back"></span>
          {{$t('Orqaga')}}
        </router-link>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>{{$t('Yoʼnalish')}}</th>
                <th>{{$t('Tender manzili')}}</th>
                <th>{{$t('Tender sanasi')}}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <ul v-if="tender && tender.direction_ids.length > 0">
                    <li v-for="(item,index) in tender.direction_ids">
                      {{index+1}}) {{item.name}}
                    </li>
                  </ul>
                </td>
                <td>
                  <template v-if="tender">
                    {{tender.address}}
                  </template>
                </td>
                <td>
                  <template v-if="tender">
                    {{tender.time}}
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive" v-for="(lots,lot_index) in getTender.result">
          <h5>Лот <em>№</em> {{lot_index + 1}}</h5>
          <table class="table table-bordered" >
              <thead>
                  <tr>
                    <th>№</th>
                    <th width="15%">{{$t('Yoʼnalish')}}</th>
                    <th width="15%">{{$t('Holati')}}</th>
                    <th width="15%">{{$t('Taklif yuborgan tashuvchilar')}}</th>
                    <th>{{$t('Avto ishlab chiqarilgan yildan boshlab necha yil otgani')}}</th>
                    <th>{{$t('Yoʼlovchilar sigʼimi')}}</th>
                    <th>{{$t('Transport kategoriyasiga mosligi')}}</th>
                    <th>{{$t('Transport rusumining mosligi')}}</th>
                    <th>{{$t('Qatnovlar soni')}}</th>
                    <th>{{$t('Tarif')}}</th>
                    <th>{{$t('Qoʼshimcha qulayliklar mavjudligi')}}</th>
                    <th>{{$t('Tadbirlar rejasi')}}</th>
                    <th>{{$t('Ballar toʼplandi')}}</th>
                    <th>{{$t('Umumiy ballar')}}</th>
                    <th>{{$t('Batafsil')}} </th>
                    <th>{{$t('Shartnomalar')}} </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(directions, d_index) in lots">
                      <td>{{d_index+1}} </td>
                      <td>
                        <template v-for="(p_item,p_index) in directions">
                          <p v-for="(s_item,s_index) in p_item">
                            <router-link :to="'/crm/stepuser/titul-tab/'+s_item.direction_ids">
                              <b>{{s_item.name != null ? s_item.name : ''}}</b>
                              <small class="badge badge-primary" v-if="s_item.reys_status">
                                {{getStatus(s_item.reys_status)}}
                              </small>
                            </router-link>
                          </p>
                        </template>
                      </td>
                      <td>
                            <template v-for="(p_item,p_index) in directions">
                                <p v-for="(s_item,s_index) in p_item">
                                    <router-link :to="'/crm/stepuser/titul-tab/'+s_item.direction_ids">
                                        <b>{{s_item.name != null ? s_item.name : ''}}</b>
                                    </router-link>
                                </p>
                            </template>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                            <template v-for="(p_item,p_index) in directions">
                                <li v-for="(s_item,s_index) in p_item">
                                    <p>
                                        <a href="#" @click.prevent="openModal(s_item.user)">
                                            <b>{{s_item.company_name != null ? s_item.company_name : 'noname'}}</b>
                                        </a>
                                    </p>
                                </li>
                            </template>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                              <p v-for="(s_item,s_index) in p_item">
                                {{s_item.years_ball}}
                              </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                            <p v-for="(s_item,s_index) in p_item">
                                {{s_item.capacity_ball}}
                              </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                            <p v-for="(s_item,s_index) in p_item">
                                {{s_item.categories_ball}}
                            </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                            <p v-for="(s_item,s_index) in p_item">
                                {{s_item.models_ball}}
                            </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                            <p v-for="(s_item,s_index) in p_item">
                              {{s_item.reys_ball}}
                            </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                            <p v-for="(s_item,s_index) in p_item">
                                {{s_item.tarif_ball}}
                            </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                            <p v-for="(s_item,s_index) in p_item">
                              {{s_item.cars_ball}}
                            </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                                <p v-for="(s_item,s_index) in p_item">
                                  {{s_item.tadbirlar_rejasi_ball}}
                                </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                                <p v-for="(s_item,s_index) in p_item">
                                  {{s_item.total_ball}}
                                </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions" style="margin:20px 0 30px 0;">
                              {{summBall(p_item)}}
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <ul class="list-inline">
                          <li v-for="(p_item,index) in directions">
                                <p v-for="(s_item,s_index) in p_item">
                                    <a href="#" @click.prevent="ballItem(s_item)" class="h4">
                                        <i class="fas fa-expand-arrows-alt"></i>
                                    </a>
                                </p>
                          </li>
                        </ul>
                      </td>
                      <td class="without_padding">
                        <template v-for="(p_item,index) in directions">
                            <p v-for="(s_item,s_index) in p_item">
                                <router-link class="" tag="a" :to="{path:`/crm/contract/${s_item.contract.id}`,query:{TID:$route.params.tenderId}}" v-if="s_item.contract">
                                    <b>
                                    <i class="fas fa-file-alt"></i>
                                    {{$t('Shartnoma')}}
                                    </b>
                                </router-link>
                            </p>
                        </template>
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
      </div>

      <!-- Modal For USER-->
      <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{$t('Tashkilot maʼlumotlari')}}</h5>
              <button type="button" class="close" @click.prevent="closeUserModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="table-responsive table">
                <table class="table-bordered table table-hover" v-if="userItem">
                  <thead></thead>
                  <tbody>
                    <tr>
                      <th>{{$t('Tashkilot nomi')}}</th>
                      <td>{{userItem.company_name}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('F.I.Sh')}}</th>
                      <td>{{userItem.surname}}  {{userItem.name}} {{userItem.middlename}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Viloyat')}}</th>
                      <td>{{userItem.region ? userItem.region.name : ''}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Tuman/Shahar')}}</th>
                      <td>{{userItem.area ? userItem.area.name : ''}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Vakolatli shaxs')}}</th>
                      <td>{{userItem.trusted_person}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('INN')}}</th>
                      <td>{{userItem.inn}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Telefon')}}</th>
                      <td>{{userItem.phone}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Manzil')}}</th>
                      <td>{{userItem.address}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('X/raqam')}}</th>
                      <td>{{userItem.bank_number}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('MFO')}}</th>
                      <td>{{userItem.mfo}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('OKED')}}</th>
                      <td>{{userItem.oked}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Bankning manzili')}}</th>
                      <td>{{userItem.city}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Litsenziya raqami')}}</th>
                      <td>{{userItem.license_number}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Litsenziya turi')}}</th>
                      <td>{{userItem.license_type}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Litsenziya sanasi')}}</th>
                      <td>{{userItem.license_date}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click.prevent="closeUserModal">{{$t('Yopish')}}</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal FOR BALL-->
      <div class="modal fade bd-example-modal-lg" id="ballModal" tabindex="-1" role="dialog" aria-labelledby="ballModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{$t('Ballar')}}</h5>
              <button type="button" class="close" @click.prevent="closeBallModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="table-responsive table">
                <table class="table-bordered table table-hover" v-if="ballItems">
                  <thead>
                    <tr>
                      <th>№</th>
                      <th>{{$t('Baxolash mezonlari')}}</th>
                      <th>{{$t('Kiritilgan taklif')}}</th>
                      <th>{{$t('Yoʼnalish talabida')}}</th>
                      <th>{{$t('Hisoblangan ball')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>{{$t('Tarif')}}</td>
                      <td>{{ballItems.app_tarif}}</td>
                      <td>{{ballItems.lot_tarif}}</td>
                      <td>{{ballItems.tarif_ball}}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>{{$t('Reyslar soni')}}</td>
                      <td>{{ballItems.app_reys}}</td>
                      <td>{{ballItems.lot_reys}}</td>
                      <td>{{ballItems.reys_ball}}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>{{$t('Avtomobillarning oʼrtacha yili')}} </td>
                      <td>{{ballItems.app_years}}</td>
                      <td>{{ballItems.lot_years}}</td>
                      <td>{{ballItems.years_ball}}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>{{$t('Avtomobillarning umumiy sigʼimi')}}</td>
                      <td>{{ballItems.app_capacity}}</td>
                      <td>{{ballItems.lot_capacity}}</td>
                      <td>{{ballItems.capacity_ball}}</td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>{{$t('Turi/Sinfi')}}</td>
                      <td>
                        <ul class="list-inline" v-if="ballItems.app_categories">
                            <li v-for="(app_cat,index) in ballItems.app_categories">
                              {{app_cat.name}}
                            </li>
                        </ul>
                      </td>
                      <td>
                        <ul class="list-inline" v-if="ballItems.lot_categories">
                            <li v-for="(lot_cat,index) in ballItems.lot_categories">
                              {{lot_cat.name}}
                            </li>
                        </ul>
                      </td>
                      <td>{{ballItems.categories_ball}}</td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>{{$t('M1 bolsa turning sinfi')}}</td>
                      <td>
                        <ul class="list-inline" v-if="ballItems.app_models">
                            <li v-for="(app_model,index) in ballItems.app_models">
                              {{app_model.name}}
                            </li>
                        </ul>
                      </td>
                      <td>
                        <ul class="list-inline" v-if="ballItems.lot_models">
                            <li v-for="(lot_model,index) in ballItems.lot_models">
                              {{lot_model.name}}
                            </li>
                        </ul>
                      </td>
                      <td>{{ballItems.models_ball}}</td>
                    </tr>
                  </tbody>
                </table>
                <hr>
                <table class="table-bordered table table-hover" v-if="ballItems">
                  <thead>
                    <tr>
                      <th>№</th>
                      <th>
                        {{$t('Yoʼnalishlarda ishlayotganda harakatlanish xavfsizligini taʼminlash boʼyicha qatnashchi tomonidan amalga oshirilgan tadbirlar rejasi (faqat tashuvchi belgilaganlari koʼrinadi)')}}
                      </th>
                      <th>{{$t('Hisoblangan ball')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>
                        {{$t('Аvtotransport vositalarini xar kuni reysdan oldingi texnik koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
                      </td>
                      <td>{{ballItems.daily_technical_job}}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>
                        {{$t('Haydovchilarni har kungi tibbiy koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
                      </td>
                      <td>{{ballItems.daily_medical_job}}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>
                        {{$t('Taklif etilgan avtotransport vositalari sonidan kelib chiqib barcha haydovchilariga 30 soatlik dastur boʼyicha yoʼl harakati qoidalarini oʼrgatilgan')}}
                      </td>
                      <td>{{ballItems.hours_rule}}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>
                        {{$t('Taklif etilgan barcha avtotransport vositalarining old oynalariga videoregistrator oʼrnatilgan')}}
                      </td>
                      <td>{{ballItems.videoregistrator}}</td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>
                        {{$t('Taklif etilgan barcha avtotransport vositalarini GPS rejimida masofadan kuzatish tizimiga ulangan')}}
                      </td>
                      <td>{{ballItems.gps}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click.prevent="closeBallModal">{{$t('Yopish')}}</button>
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
        laoding: true,
        userItem:{},
        ballItems:{},
        result:[],
        tender:{},
    };
  },
  computed: {
    ...mapGetters("completedtender", ["getTender"]),
  },
  async mounted() {
    await this.actionCompletedTendersShow(this.$route.params.tenderId);
    $('#userModal').modal({backdrop: 'static',keyboard: true, show: false});
    $('#ballModal').modal({backdrop: 'static',keyboard: true, show: false});
    this.result = this.getTender
    this.tender = this.getTender.tender

    this.laoding = false
  },
  methods: {
    ...mapActions("completedtender", [
      "actionCompletedTendersShow",
    ]),
    getStatus(status){
      if(status == 'all'){
        return 'Полнoе направлениe'
      }else if(status == 'custom'){
        return 'Часть направления'
      }
    },
    closeUserModal(){
      $('#userModal').modal('hide')
      this.userItem = {}
    },
    openModal(item){
      $('#userModal').modal('show')
      this.userItem = item
    },
    ballItem(item){
      this.ballItems = item
      $('#ballModal').modal('show')
    },
    closeBallModal(){
      $('#ballModal').modal('hide')
      this.ballItems = {}
    },
    summBall(items){
      let count = 0
      if(items){
        items.forEach((item,index)=>{
          count += Number(item.total_ball)
        })
      }
      return count
    }
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
.cardtender{
    padding: 0;
    box-shadow: none;
    background-color: rgba(0,0,0,.03);
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
.cardtender .card-header{
    background: #f3f3f4;
}
.without_padding{
  padding: 0px !important;
}
.without_padding ul{
  margin-bottom: 0px;
}
.without_padding li{
  text-align: center;
}
/*.list-inline li{
  border-bottom: 1px solid #000;
}*/
.list-inline li:last-child{
  border: none;
}
</style>
