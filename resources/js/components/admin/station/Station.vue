<template>
	<div class="area">
		<Loader v-if="laoding"/>
		<div class="card">
			<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i  class="peIcon pe-7s-box1"></i>
					    {{$t('Avtostansiya')}}
					</h4>
	            	<div class="add_user_btn">
	            		<span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
		            		{{$t('Avtostansiyalar soni')}} <b>{{ getStations.total }} {{$t('ta')}}.</b>
		            	</span>
			            <button type="button" class="btn btn-info toggleFilter mr-3" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	{{$t('Saralash')}}
						</button>
						<router-link v-if="$can('store', 'StationController')" class="btn btn-primary" to="/crm/station/add"><i class="fas fa-plus"></i> {{$t('Qoʼshish')}}</router-link>
		            </div>
	            </div>
	            <transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-3">
				  				<label for="name">{{$t('Nomi')}} !</label>
			                    <input
			                      id="name"
			                      class="form-control input_style"
			                      v-model="filter.name"
			                    />
              				</div>
				  			<div class="form-group col-lg-3" v-if="getUser.role_id == 1">
				  				<label for="region_id">{{$t('Viloyat')}}!</label>
			                    <select
			                      id="region_id"
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                      @change="selectRegion"
			                    >
			                      <option value="" selected >{{$t('Viloyatni tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="area_id">{{$t('Viloyat boʼyicha saralash')}}!</label>
			                    <select
			                      id="area_id"
			                      class="form-control input_style"
			                      v-model="filter.area_id"
			                    >
			                      <option value="" selected >{{$t('Viloyatni tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-md-3">
							    <label for="station_type">{{$t('Turi')}} </label>
							    <select
							    	class="form-control input_style"
							    	v-model="filter.station_type"
						    	>
							    	<option value="" selected>{{$t('Tanlang')}}</option>
							    	<option :value="station.id" v-for="(station,index) in $g.stations()">{{station.name}}</option>
							    </select>
						  	</div>
						  	<div class="col-lg-12 form-group d-flex justify-content-end">
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	{{$t('Tozalash')}}
							  	</button>
							  	<button type="button" class="btn btn-primary ml-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	{{$t('Qidirish')}}
							  	</button>
					  	  	</div>
				  		</div>
				  	</div>
			  	</transition>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Nomi')}}</th>
							<th scope="col">{{$t('Viloyat')}}</th>
							<th scope="col">{{$t('Tuman')}}</th>
							<th scope="col">{{$t('Turi')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(station,index) in getStations.data">
							<td scope="row">{{station.id}}</td>
							<td>{{station.name}}</td>
							<td>{{station.region ? station.region.name : ''}}</td>
							<td>{{station.area ? station.area.name : ''}}</td>
							<td>{{$g.findStation(station.station_type)}}</td>
							<td>
								<router-link v-if="$can('edit', 'StationController')" tag="button" class="btn_transparent" :to='`/crm/station/edit/${station.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button v-if="$can('destroy', 'StationController')" class="btn_transparent" @click="deleteStation(station.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getStations" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
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
				filter:{
					name:'',
					region_id:'',
					station_type:'',
					area_id:'',
				},
                laoding: true,
                filterShow: false,
			}
		},
		async mounted(){
			await this.profileUser()
			let page = 1;
			let data = {
				page:1,
				items:this.filter
			}
			await this.actionStations(data)
			await this.actionRegionList()
			await this.actionAreaByRegion({ region_id: this.filter.region_id })
			this.laoding = false
		},
		computed:{
			...mapGetters('station',['getStations','getMassage']),
			...mapGetters("region", ["getRegionList"]),
			...mapGetters(['getUser']),
			...mapGetters('area',['getAreaList'])
		},
		methods:{
			...mapActions('station',['actionStations','actionDeleteStation']),
			...mapActions("region", ["actionRegionList"]),
			...mapActions('area',['actionAreaByRegion']),
			...mapActions(['profileUser']),
			async selectRegion(){
		      await this.actionAreaByRegion({ region_id: this.filter.region_id });
		      this.filter.area_id = ''
		    },
			async getResults(page = 1){
				this.laoding = true
				let data = {
					page:page,
					items:this.filter
				}
				await this.actionStations(data)
				this.laoding = false
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.region_id != '' || this.filter.name != '' || this.filter.station_type != '' || this.filter.area_id != ''){
					let data = {
						page:page,
						items:this.filter
					}
					this.laoding = true
					await this.actionStations(data)
					this.laoding = false
				}
			},
			async clear(){
				if(this.filter.region_id != '' || this.filter.name != '' || this.filter.station_type != '' || this.filter.area_id != ''){
					this.filter.name = ''
					this.filter.region_id = ''
					this.filter.station_type = ''
					this.filter.area_id = ''
                    let page  = 1
                    this.laoding = true
                    await this.actionStations({page: page,items:this.filter})
                    await this.actionAreaByRegion({ region_id: this.filter.region_id });
                    this.laoding = false
				}

			},
			async deleteStation(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
					this.laoding = true
					await this.actionDeleteStation(id)
					await this.actionStations(page)
					this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: this.$t('Oʼchirildi'),
				    })
				}
			}
		}
	}
</script>
<style scoped>

</style>
