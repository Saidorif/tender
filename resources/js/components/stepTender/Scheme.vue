<template>
    <div class="add_area">
        <Loader v-if="laoding"/>
        <PassportTab/>
        <div class="card-body container" style="overflow: visible;">
            <h1 v-if="titulData.type">{{$t('Avtobus qatnov yoʼli tasviri')}} {{titulData.type.type}} - {{titulData.pass_number}} - {{$t('sonli')}} "{{titulData.name}}" </h1>
            <div class="map_scheme" v-if="schemeData.length">
                <div class="mid_line"></div>
                <template v-for="(p_item,p_index) in schemeData">
                <div class="stationItem start_point cicle_item" v-if="p_index == 0" :key="p_index">
                    <h6>{{p_item.whereForm ? p_item.whereForm.name : ""}}</h6>
                </div>

                <div class="sm_cicle_item stationItem" v-if="p_index > 0" :key="p_index">
                    <h6>{{p_item.whereForm ? p_item.whereForm.name : ""}}</h6>
                </div>

                <template v-for="(ch_item, ch_index) in p_item.details">
                    <template>
                    <div class="icon_item">
                        <img
                        v-if="ch_item.name == 'railway'"
                        src="/img/tr_tracks.jpg"
                        :key="'icon'+p_index+ch_index"
                        width="30"
                        />
                        <img
                        v-if="ch_item.name == 'bridge'"
                        src="/img/bridge.png"
                        :key="'icon'+p_index+ch_index"
                        width="30"
                        />
                        <img
                        v-if="ch_item.name == 'food'"
                        src="/img/eat.png"
                        :key="'icon'+p_index+ch_index"
                        width="30"
                        />
                        <img
                        v-if="ch_item.name == 'rest'"
                        src="/img/hotel.png"
                        :key="'icon'+p_index+ch_index"
                        width="30"
                        />
                        <img
                        v-if="ch_item.name == 'danger'"
                        src="/img/danger.png"
                        :key="'icon'+p_index+ch_index"
                        width="30"
                        />
                        <sup>{{ch_item.count}}</sup>
                    </div>
                    </template>
                </template>

                <div
                    class="end_point cicle_item stationItem"
                    v-if="schemeData.length  == p_index + 1"
                    :key="'last'+p_index"
                >
                    <h6>{{p_item.whereTo ? p_item.whereTo.name : ""}}</h6>
                </div>
                </template>
            </div>
            <div class="road_signs col-xl-6">
                <h6>{{$t('Shartli belgilar')}}</h6>
                <ul>
                <li>
                    <div class="icon_item bdn">
                        <div class="cicle_item"></div>
                    </div>
                    <span>{{$t('Avtostansiya')}}</span>
                </li>
                <li>
                    <div class="icon_item bdn">
                        <div class="sm_cicle_item"></div>
                    </div>
                    <span>{{$t('Toʼxtash joylari')}}</span>
                </li>
                <li>
                    <div class="icon_item">
                    <img src="/img/tr_tracks.jpg" width="30" />
                    </div>
                    <span>{{$t('Temir yoʼlni kesib oʼtish joylari')}} </span>
                </li>
                <li>
                    <div class="icon_item">
                    <img src="/img/bridge.png" width="30" />
                    </div>
                    <span>{{$t('Kesishgan yoʼl ustidan oʼtkazilgan kondalang yoʼllar')}}</span>
                </li>
                <li>
                    <div class="icon_item">
                    <img src="/img/eat.png" width="30" />
                    </div>
                    <span>{{$t('Ovqatlanish joylari')}}</span>
                </li>
                <li>
                    <div class="icon_item">
                    <img src="/img/hotel.png" width="30" />
                    </div>
                    <span>{{$t('Dam olish joylari')}} </span>
                </li>
                <li>
                    <div class="icon_item">
                    <img src="/img/danger.png" width="30" />
                    </div>
                    <span>{{$t('Harkatlanish uchun xafli boʼlgan yoʼl uchastkalari')}}</span>
                </li>
                </ul>
            </div>
            <div class="row col-md-12"  v-if="agreedData.length">
                <div class="form-group col-md-3 agree_item" v-for="(p_item,p_index) in agreedData">
                <h6>"{{$t('Kelishilgan')}}"</h6>
                <p>{{p_item.organ }} {{ p_item.job}}:</p>
                <p><span></span>{{p_item.fio }}. {{ p_item.date}}</p>
                <p></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import PassportTab from "./PassportTab";
import Loader from '../Loader'
export default {
  components: {
    DatePicker,
    PassportTab,
    Loader
  },
  data() {
    return {
      titulData: {},
      schemeData: [],
      form:{
          organ: '',
          job: "",
          fio: '',
          date: '',
          direction_id: this.$route.params.directionId,
      },
      agreedData: [],
      requiredInput: false,
      laoding: true
    };
  },
  async mounted() {
    await this.actionDirection(this.$route.params.directionId);
    this.laoding = false
    this.titulData = this.getDirection
    this.schemeData = this.titulData ? this.titulData.timing_with : [];
  },
  computed: {
    ...mapGetters("front", ["getDirection"]),
  },
  methods: {
    ...mapActions("front", ["actionDirection"]),
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
.map_scheme {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 100px;
  padding-bottom: 100px;
  position: relative;
}
.cicle_item {
  height: 20px;
  width: 20px;
  border-radius: 6px;
  border: 3px solid black;
  background: #fff;
  z-index: 9;
  position: relative;
}
.sm_cicle_item {
  height: 15px;
  width: 15px;
  border-radius: 50%;
  border: 3px solid black;
  background: #fff;
  z-index: 9;
  position: relative;
}

.stationItem h6 {
  position: absolute;
  top: -30px;
  left: 50%;
  -webkit-transform: translateX(-50%);
  transform: translateX(-50%);
  white-space: nowrap;
}
.mid_line {
  position: absolute;
  left: 0;
  right: 0;
  top: 49.4%;
  width: 100%;
  height: 3px;
  background: #000;
  z-index: 0;
}

.stationItem:nth-child(even) h6 {
  top: -30px;
}
.stationItem:nth-child(odd) h6 {
  top: 30px;
}
.end_point {
}
.end_point.stationItem h6,
.start_point.stationItem h6 {
  font-weight: bold;
  top: -30px;
}
.start_point.stationItem h6{
    left: 30px;
}
.icon_item {
  position: relative;
  border: 1px solid #000;
  border-radius: 6px;
  padding: 2px;
  height: 35px;
  width: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
}
.icon_item img {
  max-width: 80%;
  max-height: 80%;
}
.icon_item sup {
  position: absolute;
  top: -7px;
  right: -7px;
  font-size: 10px;
  font-weight: bold;
  border-radius: 50%;
  width: 15px;
  height: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
  border: 1px solid #000;
}
.road_signs h6 {
  text-align: center;
  font-weight: bold;
  font-size: 20px;
  margin-bottom: 10px;
}
.road_signs ul{
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}
.road_signs ul li{
    list-style: none;
    width: 50%;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    padding-right: 15px;

}
.road_signs ul li .bdn{
    border: none;
}
.road_signs ul li .icon_item{
    margin-right: 10px;
}
.agree_item h6{
    text-transform: uppercase;
    font-weight: bold;
    font-size: 18px;
    text-align: center;
}
.agree_item p span{
    display: inline-flex;
    width: 150px;
    border-bottom: 1px solid #000;
    margin-right: 5px;
}
</style>
