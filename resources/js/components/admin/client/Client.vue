<template>
	<div class="employee">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title">
				    <h4 class="title_user">
				    	<i  class="peIcon pe-7s-users"></i>
					     {{$t('Tashuvchilar')}}
					</h4>
					<div class="add_user_btn">
                        <span  class="alert alert-info" style="margin: 0px 15px 0px auto;">
		            		{{$t('Soni')}}  <b >{{getClients.total}}   {{$t('ta')}}.</b></span>
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	{{$t('Saralash')}}
						</button>
		            </div>
		  		</div>
		    	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-3">
				                <label for="surname">{{$t('Familiya')}}</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="surname"
				                  v-model="filter.surname"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
				                <label for="name">{{$t('Ism')}}</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="name"
				                  v-model="filter.name"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
				                <label for="middlename">{{$t('Sharif')}}</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="middlename"
				                  v-model="filter.middlename"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
	  							<label for="inn">{{$t('INN')}}</label>
	  							<input
	  								type="text"
	  								class="form-control"
	  								id="inn"
	  								v-model="filter.inn"
  								>
				  			</div>
				  			<div class="form-group col-lg-3">
				  				<label for="region_id">{{$t('Viloyat')}}</label>
			                    <select
			                      id="region_id"
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                      @change="selectRegion()"
			                    >
			                      <option value="" selected disabled>{{$t('Viloyatni tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="area_id">{{$t('Tuman/Shahar')}}!</label>
			                    <select
			                      id="area_id"
			                      class="form-control input_style"
			                      v-model="filter.area_id"
			                    >
			                      <option value="" selected disabled>{{$t('Tuman/Shahar tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
			                    </select>
              				</div>
  					  		<div class="form-group col-lg-3">
	  							<label for="company_name">{{$t('Tashkilot nomi')}}</label>
	  							<input
	  								type="text"
	  								class="form-control"
	  								id="company_name"
	  								v-model="filter.company_name"
  								>
				  			</div>
						  	<div class="col-lg-3 form-group btn_search">
							  	<button type="button" class="btn btn-primary mr-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	{{$t('Qidirish')}}
							  	</button>
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	{{$t('Tozalash')}}
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
							<th scope="col">{{$t('Tashkilot nomi')}}</th>
							<th scope="col">{{$t('INN')}}</th>
							<th scope="col">{{$t('Viloyat')}}</th>
							<th scope="col">{{$t('Tuman/Shahar')}}</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Telefon')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getClients.data">
							<td scope="row">{{item.id}}</td>
							<td>{{item.company_name}}</td>
							<td>{{item.inn}}</td>
							<td>{{item.region ? item.region.name : ''}}</td>
							<td>{{item.area ? item.area.name : ''}}</td>
							<td>
                                <span v-if="item.status == 'active'" class="alert alert-success" style="padding:2px;" >{{$t('Faol')}}</span>
                                <span v-if="item.status == 'inactive'" class="alert alert-danger" style="padding:2px;">{{$t('Nofaol')}}</span>
                            </td>
							<td>{{item.phone}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/client/edit/${item.id}`'
									 v-if="$can('carrierEdit', 'UserController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<!-- <button class="btn_transparent" @click="deleteEmployee(item.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button> -->
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getClients" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex'
    import Loader from '../../Loader'
	export default{
        components:{
            Loader
        },
		data(){
			return{
				filter:{
					region_id:'',
					area_id:'',
					name:'',
					middlename:'',
					surname:'',
					inn:'',
					company_name:'',
				},
                filterShow:false,
                laoding: true,
			}
		},
		async mounted(){
			let page = 1;
			await this.actionClients({page:page,items:this.filter})
            await this.actionRegionList();
            this.laoding = false
		},
		computed:{
			...mapGetters('client',['getClients']),
			...mapGetters("region", ["getRegionList"]),
			...mapGetters("area", ["getAreaList"]),
		},
		methods:{
			...mapActions("region", ["actionRegionList"]),
    		...mapActions("area", ["actionAreaByRegion"]),
			...mapActions('client',['actionClients']),
			async getResults(page = 1){
				await this.actionClients({page:page,items:this.filter})
			},
			async selectRegion(){
		      await this.actionAreaByRegion({ region_id: this.filter.region_id });
		      this.filter.area_id = ''
		    },
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.name || this.filter.inn || this.filter.company_name || this.filter.region_id || this.filter.area_id){
					await this.actionClients({page: page,items:this.filter})
				}
			},
			async clear(){
				if(this.filter.name || this.filter.inn || this.filter.company_name || this.filter.region_id || this.filter.area_id){
					this.filter.name = ''
					this.filter.inn = ''
					this.filter.region_id = ''
					this.filter.area_id = ''
					this.filter.company_name = ''
					let page  = 1
					await this.actionClients({page: page,items:this.filter})
				}

			},
			// async deleteEmployee(id){
			// 	if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
			// 		let page = 1
			// 		await this.actionDeleteEmployee(id)
			// 		await this.actionClients({page: page,items:this.filter})
			// 		toast.fire({
			// 	    	type: 'success',
			// 	    	icon: 'success',
			// 			title: this.$t('Oʼchirildi'),
			// 	    })
			// 	}
			// }
		}
	}
</script>
<style scoped>

</style>
