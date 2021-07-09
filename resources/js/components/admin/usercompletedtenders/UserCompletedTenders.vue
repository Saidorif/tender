<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
			    		<i class="peIcon fas fa-file"></i>
					    {{$t('Yakunlangan tenderlar')}}
					</h4>
	            </div>
	            <transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-3">
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
				  			<div class="form-group col-lg-3">
				  				<label for="time">{{$t('Sanasi boyicha saralash')}} !</label>
				  				<date-picker
					                lang="ru"
					                type="date"
					                v-model="filter.time"
					                format="YYYY-MM-DD" valueType="format"
					                class="input_style"
				              	></date-picker>

              				</div>
              				<div class="form-group col-lg-3">
				  				<label for="no_lots">{{$t('Oʼtqizilmagan tenderlar')}}!</label>
				  				<input type="checkbox" v-model="filter.no_lots" class="form-control input_style" id="no_lots">
              				</div>
              				<div class="form-group col-lg-3">
				  				<label for="status">{{$t('Tasdiqlanmagan tenderlar')}}!</label>
				  				<input type="checkbox" v-model="filter.status" class="form-control input_style" id="status">
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
								<th scope="col">{{$t('Holati')}}</th>
								<th scope="col">{{$t('Tender sanasi')}}</th>
								<th scope="col">{{$t('Kelib tushgan takliflarning umumiy soni')}}</th>
								<th scope="col">{{$t('Ochilgan lotlarning umumiy soni')}}</th>
								<th scope="col">{{$t('Tahrirlash')}}</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item,index) in getTendersList.data">
								<td scope="row">{{index+1}}</td>
								<td>
									<div class="badge" :class="getStatusClass(item.status)">
										{{getStatusName(item.status)}}
									</div>
								</td>
								<td>{{item.time}}</td>
								<td width="20%">{{item.tenderapps_count}}</td>
								<td width="20%">{{item.tenderlots_count}}</td>
								<td>
									<router-link
										tag="button"
										class="btn_transparent"
										:to='`/crm/completed-tenders/show/${item.id}`'
										v-if="$can('completedTenders', 'TenderController')"
									>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
		                            <router-link class="" tag="a" :to="`/crm/protocol/${item.id}`">
		                              <i class="fas fa-edit protocol_btn"></i>
		                              <!-- Протокол -->
		                            </router-link>
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getTendersList" @pagination-change-page="getResults"></pagination>
					</table>
			  	</div>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import DatePicker from "vue2-datepicker";
    import { mapGetters , mapActions } from 'vuex'
    import Loader from '../../Loader'
	export default{
        components:{
            Loader,
            DatePicker,
        },
		data(){
			return{
				filter:{
					region_id:'',
					time:'',
					no_lots:false,
					status:false,
				},
                laoding: true,
                filterShow: false,
			}
		},
		async mounted(){
			let page = 1;
            await this.actionCompletedTendersList({page:page,items:this.filter})
            await this.actionRegionList()
            this.laoding = false
		},
		computed:{
			...mapGetters("region", ["getRegionList"]),
			...mapGetters('completedtender',['getTendersList','getMassage'])
		},
		methods:{
			...mapActions('completedtender',['actionCompletedTendersList']),
			...mapActions("region", ["actionRegionList"]),
			async getResults(page = 1){
                this.laoding = true
				await this.actionCompletedTendersList({page:page,items:this.filter})
                this.laoding = false
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.region_id != '' || this.filter.time != '' || this.filter.no_lots || this.filter.status){
					let data = {
						page:page,
						items:this.filter
					}
					this.laoding = true
					await this.actionCompletedTendersList(data)
					this.laoding = false
				}
			},
			async clear(){
				if(this.filter.region_id != '' || this.filter.time != '' || this.filter.no_lots || this.filter.status){
					this.filter.region_id = ''
					this.filter.time = ''
					this.filter.no_lots = false
					this.filter.status = false
                    let page  = 1
                    this.laoding = true
                    await this.actionCompletedTendersList({page: page,items:this.filter})
                    this.laoding = false
				}

			},
			getStatusName(status){
				if(status == 'pending'){
					return this.$t('Kutish jarayonida')
				}else if(status == 'rejected'){
					return this.$t('Rad etilgan')
				}else if(status == 'completed'){
					return this.$t('Yakunlangan')
				}
			},
			getStatusClass(status){
				if(status == 'pending'){
					return 'badge-secondary'
				}else if(status == 'rejected'){
					return 'badge-danger'
				}else if(status == 'completed'){
					return 'badge-success'
				}
			},
			async deleteRegion(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteTenderAnnounce(id)
                    await this.actionTenderAnnounces(page)
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
	.protocol_btn{
        font-size: 20px;
	}
</style>
