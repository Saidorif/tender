<template>
  <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
    <h1>Avtobus qatnov yoli tasviri</h1>
    <div class="map_scheme" v-if="schemeData.length">
        <div class="mid_line"></div>
        <template  v-for="(p_item,p_index) in schemeData">
            <div class="stationItem start_point cicle_item"  v-if="p_index == 0" :key="p_index"><h6>{{p_item.whereForm ? p_item.whereForm.name : ""}}</h6></div>

            <div class="sm_cicle_item stationItem" v-if="p_index > 0" :key="p_index"><h6>{{p_item.whereForm ? p_item.whereForm.name : ""}}</h6></div>

            <template v-for="(ch_item, ch_index) in p_item.details">
                <template>
                <div v-if="ch_item.name == 'railway'" class="icon_item">>
                    <img  src="/img/tr_tracks.png"  :key="'icon'+p_index+ch_index+imgItem" width="30">
                    <sup>{{ch_item.count}}</sup>
                </div>
                <div v-if="ch_item.name == 'bridge'" class="icon_item">
                    <img  src="/img/bridge.png"  :key="'icon'+p_index+ch_index+imgItem" width="30">
                    <sup>{{ch_item.count}}</sup>
                </div>
                </template>
            </template>

            <div class="end_point cicle_item stationItem "  v-if="schemeData.length  == p_index + 1" :key="'last'+p_index"><h6>{{p_item.whereTo ? p_item.whereTo.name : ""}}</h6></div>
        </template>
    </div>
  </form>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["titulData"],
  components: {
    DatePicker,
  },
  data() {
    return {
        schemeData: []
    };
  },
  async mounted() {
      this.schemeData = this.titulData ? this.titulData.timing_with : []
      console.log(this.schemeData)
  },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
  },
  methods: {
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable"]),
    async saveData(){

    }
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
.map_scheme{
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 100px;
    padding-bottom: 100px;
    position: relative;
}
.cicle_item{
    height: 20px;
    width: 20px;
    border-radius: 50%;
    border: 3px solid black;
    background: #fff;
    z-index: 9;
    position: relative;
}
.sm_cicle_item{
    height: 15px;
    width: 15px;
    border-radius: 50%;
    border: 3px solid black;
    background: #fff;
    z-index: 9;
    position: relative;
}

.stationItem h6{
    position: absolute;
    top: -30px;
    left: 50%;
    -webkit-transform: translateX(-50%);
    transform: translateX(-50%);
    white-space: nowrap;
}
.mid_line{
    position: absolute;
    left: 0;
    right: 0;
    top: 49.4%;
    width: 100%;
    height: 3px;
    background: #000;
    z-index: 0;
}

.stationItem:nth-child(even) h6{
    top: -30px;
}
.stationItem:nth-child(odd) h6{
    top: 30px;
}
.end_point{

}
.end_point.stationItem h6,
.start_point.stationItem h6{
    font-weight: bold;
    top: -30px;
}
.icon_item{
    position: relative;
}
.icon_item sup{
    font-size: 14px;
    font-weight: bold;
}
</style>