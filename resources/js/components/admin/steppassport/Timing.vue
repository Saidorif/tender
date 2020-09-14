<template>
    <div class="row tabRow">
        <div class="col-md-12 tabs_block" v-for="(p_item, p_index) in form">
            <div class="col-md-1">
                <h5>{{p_index+1}}</h5>
            </div>
            <div class="form-group col-md-3">
              <label for="region_id">Region from</label>
              <select
                class="form-control input_style"
                v-model="p_item.region_from_id"
                @change="selectRegion('region_from_id', p_index)"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in getRegionList" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="region_id">Area from</label>
              <select
                class="form-control input_style"
                v-model="p_item.area_from_id"
                placeholder="Area"
                @change="selectArea('area_from_id', p_index, 'region_from_id')"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in p_item.areaFrom" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="region_id">Station from</label>
              <select
                class="form-control input_style"
                v-model="p_item.station_from_id"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in p_item.stationFrom" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="region_id">Region to</label>
              <select
                class="form-control input_style"
                v-model="p_item.region_to_id"
                @change="selectRegion('region_to_id', p_index)"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in getRegionList" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="region_id">Area to</label>
              <select
                class="form-control input_style"
                v-model="p_item.area_to_id"
                placeholder="Area"
                @change="selectArea('area_to_id', p_index, 'region_to_id')"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in p_item.areaTo" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="region_id">Station to</label>
              <select
                class="form-control input_style"
                v-model="p_item.station_to_id"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in p_item.stationTo" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            
        </div>
    </div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	export default{
		data(){
			return{
                form: [
                    {
                        direction_id: '',
                        region_from_id: '',
                        region_to_id: '',
                        area_from_id: '',
                        area_to_id: '',
                        station_from_id: '',
                        station_to_id: '',
                        start_time: '',
                        end_time: '',
                        start_speedometer: '',
                        end_speedometer: '',
                        distance_from_start_station: '',
                        distance_between_station: '',
                        distance_in_limited_speed: '',
                        spendtime_between_station: '',
                        spendtime_between_limited_space: '',
                        spendtime_to_stay_station: '',
                        speed_between_station: '',
                        speed_between_limited_space: '',
                        details: '',
                        areaFrom: [],
                        stationFrom: [],
                        stationTo: [],
                        areaTo:[],
                    },
                    {
                        direction_id: '',
                        region_from_id: '',
                        region_to_id: '',
                        area_from_id: '',
                        area_to_id: '',
                        station_from_id: '',
                        station_to_id: '',
                        start_time: '',
                        end_time: '',
                        start_speedometer: '',
                        end_speedometer: '',
                        distance_from_start_station: '',
                        distance_between_station: '',
                        distance_in_limited_speed: '',
                        spendtime_between_station: '',
                        spendtime_between_limited_space: '',
                        spendtime_to_stay_station: '',
                        speed_between_station: '',
                        speed_between_limited_space: '',
                        details: '',
                        areaFrom: [],
                        stationFrom: [],
                        stationTo: [],
                        areaTo:[],
                    },
                ],
            }
		},
		async mounted(){
            await this.actionRegionList();
        },
		computed:{
            ...mapGetters("region", ["getRegionList"]),
            ...mapGetters("area", ["getAreaList"]),
            ...mapGetters("station", ["getStationsList"]),
        },
		methods:{
            ...mapActions("region", ["actionRegionList"]),
            ...mapActions("station", ["actionStationByRegion"]),
            ...mapActions("area", ["actionAreaByRegion"]),

            async selectArea(this_select, index, parent_select) {
                await this.actionStationByRegion({
                    region_id: this.form[index][parent_select],
                    area_id: this.form[index][this_select],
                });
                if(this_select == 'area_from_id'){
                    this.form[index].stationFrom = this.getStationsList
                }else if(this_select == 'area_to_id'){
                      this.form[index].stationTo = this.getStationsList
                }
            },
            async selectRegion(input, index) {
                await this.actionAreaByRegion({ region_id: this.form[index][input] });
                if(input == 'region_from_id'){
                    this.form[index].areaFrom = this.getAreaList
                }else if(input == 'region_to_id'){
                    this.form[index].areaTo = this.getAreaList
                }
            },
		}
	}
</script>
<style scoped>
	.tabRow{
        padding-left: 30px;
        padding-right: 30px;
    }
    .double_input{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .double_input label{
        width: 100%;
    }
    .double_input input{
        width: 49%;
    }
    .tabs_block{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        border-bottom: 1px solid #000;
        margin-bottom: 30px;
    }
</style>