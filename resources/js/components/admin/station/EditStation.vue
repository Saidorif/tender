<template>
	<div class="edit_area">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Изменить Area
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/station"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveStation" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="region_id">Regions</label>
					    <select
					    	class="form-control input_style"
					    	v-model="form.region_id"
					    	:class="isRequired(form.region_id) ? 'isRequired' : ''"
				    	>
					    	<option value="" selected disabled>{{$t('Tanglang')}}</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-9">
					    <label for="area_id">Area</label>
					    <select
					    	class="form-control input_style"
					    	v-model="form.area_id"
					    	:class="isRequired(form.area_id) ? 'isRequired' : ''"
				    	>
					    	<option value="" selected disabled>{{$t('Tanglang')}}</option>
					    	<option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-9">
					    <label for="name">Area</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	placeholder="Area"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-9">
					    <label for="station_type">Station Type</label>
					    <select
					    	class="form-control input_style"
					    	v-model="form.station_type"
					    	:class="isRequired(form.station_type) ? 'isRequired' : ''"
				    	>
					    	<option value="" selected disabled>{{$t('Tanglang')}}</option>
					    	<option :value="station.id" v-for="(station,index) in $g.stations()">{{station.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-lg-3 form_btn">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	{{$t('Saqlash')}}
						</button>
				  	  </div>
					</div>
				</form>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				form:{
					region_id:'',
					area_id:'',
					station_type:'',
					name:'',
				},
				requiredInput:false,
				laoding: true
			}
		},
		computed:{
			...mapGetters('region',['getRegionList']),
			...mapGetters('station',['getMassage','getStation']),
			...mapGetters('area',['getAreaList']),
		},
		async mounted(){
			await this.actionRegionList()
			await this.actionEditStation(this.$route.params.stationId)
			await this.actionAreaByRegion({region_id: this.getStation.region.id})
			this.laoding = false
			this.form = this.getStation
		},
		methods:{
			...mapActions('region',['actionRegionList']),
			...mapActions('station',['actionUpdateStation','actionEditStation']),
			...mapActions('area',['actionAreaByRegion']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveStation(){
		    	if (this.form.name != '' && this.form.region_id != '' && this.form.area_id != '' && this.form.station_type != ''){
					this.laoding = true
					await this.actionUpdateStation(this.form)
					if(this.getMassage.success){
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
			          	});
						this.$router.push("/crm/station");
						this.requiredInput = false
					}
					this.laoding = false
				}else{
					this.requiredInput = true
				}
			},
			async selectRegion(){
				await this.actionAreaByRegion({region_id: this.form.region_id})
			}
		}
	}
</script>
<style scoped>

</style>
