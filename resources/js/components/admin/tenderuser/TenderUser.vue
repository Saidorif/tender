<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i class="peIcon fas fa-bullhorn"></i>
					    {{$t('Tanderlar')}}
					</h4>
	            	<div class="add_user_btn">
	            		<span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
		            		{{$t('Tanderlar soni')}}<b>{{ getTenderAnnounces.total }} {{$t('ta')}}.</b>
		            	</span>
			            <button type="button" class="btn btn-info toggleFilter mr-3" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	{{$t('Saralash')}}
						</button>
		            </div>
	            </div>
	            <transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-xl-4 col-md-6">
				  				<label for="region_id">{{$t('Viloyat boʼyicha saralash')}}!</label>
			                    <select
			                      id="region_id"
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                    >
			                      <option value="" selected >{{$t('Viloyatni tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-xl-4 col-md-6">
				  				<label for="type_id">{{$t('Avtomobil turi boʼyicha saralash')}}!</label>
			                    <select
			                      id="type_id"
			                      class="form-control input_style"
			                      v-model="filter.type_id"
			                    >
			                      <option value="" selected >{{$t('Viloyatni tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getTypeofdirectionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-xl-4 col-md-6">
				  				<label for="time">{{$t('Sanasi boyicha saralash')}}!</label>
				  				<date-picker
					                lang="ru"
					                type="date"
					                v-model="filter.time"
					                format="YYYY-MM-DD" valueType="format"
					                class="input_style"
				              	></date-picker>

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
							<th scope="col">{{$t('Lotlar')}}</th>
							<th scope="col">{{$t('Manzil')}}</th>
							<th scope="col">{{$t('Viloyat')}}</th>
							<th scope="col">{{$t('Tender sanasi')}}</th>
							<th scope="col">{{$t('Qoldi')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getTenderAnnounces.data">
							<td scope="row">{{item.id}}</td>
							<td>
								<em>
							    	{{item.tenderlots.length}}
							    	<span>{{item.tenderlots.length > 1 ? $t('Lotlar') :'лот'}}</span>
							    </em>
							</td>
							<td>{{item.address}}</td>
							<td>{{item.moderator}}</td>
							<td>{{item.time}}</td>
							<td>
								<time-counter :date="item.time"/>
							</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/tenderuser/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" v-if="$can('destroy', 'TenderController')"  @click="deleteRegion(item.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getTenderAnnounces" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
    import { mapGetters , mapActions } from 'vuex'
    import Loader from '../../Loader'
    import Multiselect from 'vue-multiselect';
    import DatePicker from "vue2-datepicker";
	export default{
		components:{
            Loader,
            DatePicker,
            Multiselect,
		},
		data(){
			return{
				filter:{
					region_id:'',
					time:'',
					type_id:'',
				},
                laoding: true,
                filterShow: false,
			}
		},
		async mounted(){
			let page = 1;
            await this.actionTenderAnnounces({page:page,items:this.filter})
            await this.actionTypeofdirectionList()
            await this.actionRegionList()
            this.laoding = false
		},
		computed:{
			...mapGetters('tenderannounce',['getTenderAnnounces','getMassage']),
			...mapGetters("region", ["getRegionList"]),
			...mapGetters('typeofdirection',['getTypeofdirectionList'])
		},
		methods:{
			...mapActions('tenderannounce',['actionTenderAnnounces','actionDeleteTenderAnnounce']),
			...mapActions("region", ["actionRegionList"]),
			...mapActions('typeofdirection',['actionTypeofdirectionList',]),
			async getResults(page = 1){
				await this.actionTenderAnnounces({page:page,items:this.filter})
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.region_id != '' || this.filter.time != '' || this.filter.type_id != ''){
					let data = {
						page:page,
						items:this.filter
					}
					this.laoding = true
					await this.actionTenderAnnounces(data)
					this.laoding = false
				}
			},
			async clear(){
				if(this.filter.region_id != '' || this.filter.time != '' || this.filter.type_id != ''){
					this.filter.region_id = ''
					this.filter.time = ''
					this.filter.type_id = ''
                    let page  = 1
                    this.laoding = true
                    await this.actionTenderAnnounces({page: page,items:this.filter})
                    this.laoding = false
				}

			},
			async deleteRegion(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteTenderAnnounce(id)
                    await this.actionTenderAnnounces({page:page,items:this.filter})
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
