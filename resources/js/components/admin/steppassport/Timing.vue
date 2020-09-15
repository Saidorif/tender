<template>
    <form @submit.prevent.enter="saveData" enctype="multipart/form-data"  class="row tabRow">
        <div class="col-md-12 tabs_block" v-for="(p_item, p_index) in form">
            <div class="col-md-1">
                <h5>{{p_index+1}}</h5>
            </div>
            <div class="form-group col-md-3">
              <label :for="'region_from_id'+p_index">Region from</label>
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
              <label :for="'area_from_id'+p_index">Area from</label>
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
              <label :for="'station_from_id'+p_index">Station from</label>
              <select
                class="form-control input_style"
                v-model="p_item.station_from_id"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in p_item.stationFrom" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label :for="'region_to_id'+p_index">Region to</label>
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
              <label :for="'area_to_id'+p_index">Area to</label>
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
              <label  :for="'station_to_id'+p_index">Station to</label>
              <select
                class="form-control input_style"
                v-model="p_item.station_to_id"
              >
                <option value selected disabled>choose option</option>
                <option :value="s_item.id" v-for="(s_item,s_index) in p_item.stationTo" :key="s_index">{{s_item.name}}</option>
              </select>
            </div>
            <div class="form-group col-md-3">
              <label :for="'start_time'+p_index">start_time</label>
              <date-picker 
                lang="ru" 
                class="input_style" 
                v-model="p_item.start_time"  
                type="datetime" 
                placeholder="Select datetime"></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label for="seria">end_time</label>
              <date-picker 
                lang="ru" 
                class="input_style" 
                v-model="p_item.end_time"  
                type="datetime" 
                placeholder="Select end_time"></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label :for="'start_speedometer'+p_index">start_speedometer</label>
              <input
                type="number"
                v-model="p_item.start_speedometer"
                :id="'start_speedometer'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'end_speedometer'+p_index">end_speedometer</label>
              <input
                type="number"
                v-model="p_item.end_speedometer"
                :id="'end_speedometer'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'distance_from_start_station'+p_index">distance_from_start_station</label>
              <input
                type="number"
                v-model="p_item.distance_from_start_station"
                :id="'distance_from_start_station'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'distance_between_station'+p_index">distance_between_station</label>
              <input
                type="number"
                v-model="p_item.distance_between_station"
                :id="'distance_between_station'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'distance_in_limited_speed'+p_index">distance_in_limited_speed</label>
              <input
                type="number"
                v-model="p_item.distance_in_limited_speed"
                :id="'distance_in_limited_speed'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'spendtime_between_station'+p_index">spendtime_between_station</label>
              <input
                type="number"
                v-model="p_item.spendtime_between_station"
                :id="'spendtime_between_station'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'spendtime_between_limited_space'+p_index">spendtime_between_limited_space</label>
              <input
                type="number"
                v-model="p_item.spendtime_between_limited_space"
                :id="'spendtime_between_limited_space'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'spendtime_to_stay_station'+p_index">spendtime_to_stay_station</label>
              <input
                type="number"
                v-model="p_item.spendtime_to_stay_station"
                :id="'spendtime_to_stay_station'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'speed_between_station'+p_index">speed_between_station</label>
              <input
                type="number"
                v-model="p_item.speed_between_station"
                :id="'speed_between_station'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'speed_between_limited_space'+p_index">speed_between_limited_space</label>
              <input
                type="number"
                v-model="p_item.speed_between_limited_space"
                :id="'speed_between_limited_space'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3">
              <label :for="'details'+p_index">details</label>
              <input
                type="text"
                v-model="p_item.details"
                :id="'details'+p_index"
                class="form-control input_style"
              />
            </div>
            <div class="form-group col-md-3" v-if="p_index > 0">
                <button @click="removeItem(p_index)" class="btn btn-danger" style="margin-top: 30px;" >
                    <i class="fas fa-trash mr-1 "></i>
                    удалять
                </button>
            </div>
        </div>
        <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
          <button @click="addItem()" class="btn btn-info mr-2" >
            <i class="fas fa-plus"></i>
            Добавить
          </button>
          <button type="submit" class="btn btn-primary btn_save_category">
            <i class="fas fa-save"></i>
            Сохранить
          </button>
        </div>
    </form>
</template>
<script>
    import DatePicker from "vue2-datepicker";
	import { mapGetters , mapActions } from 'vuex'
	export default{
        components: {
            DatePicker,
        },
		data(){
			return{
                form: [
                    {
                        direction_id: 1,
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
            ...mapGetters("passportTab", ["getTimingMassage"]),
        },
		methods:{
            ...mapActions("region", ["actionRegionList"]),
            ...mapActions("station", ["actionStationByRegion"]),
            ...mapActions("area", ["actionAreaByRegion"]),
            ...mapActions("passportTab", ["actionAddTiming"]),

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
            addItem(){
                let thisData =  {
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
                    }
                this.form.push(thisData)
            },
            async saveData(){
                await this.actionAddTiming({timing: this.form});
            }
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