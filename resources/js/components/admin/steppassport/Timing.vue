<template>
    <div class="row tabRow">
        <template v-for="(item, index) in form">
            <div class="form-group col-md-3">
              <label for="region_id">Region from</label>
              <select
                class="form-control input_style"
                v-model="item.regtion_from_id"
                :class="isRequired(item.region_id) ? 'isRequired' : ''"
                @change="selectRegion('region_from')"
              >
                <option value selected disabled>choose option</option>
                <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
              </select>
            </div>
        </template>
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
                        regtion_from_id: '',
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
                    }
                ]
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
            async selectRegion(input) {
                // await this.actionAreaByRegion({ region_id: this.form[input].region_id });
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
</style>