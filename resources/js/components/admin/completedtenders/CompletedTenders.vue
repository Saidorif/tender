<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
			    		<i class="peIcon fas fa-file"></i>
					    Завершенные тендеры
					</h4>
	            	<div class="add_user_btn">
			            <button type="button" class="btn btn-info toggleFilter mr-3" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	Филтр
						</button>
						<router-link class="btn btn-primary" to="/crm/direction/add">
							<i class="fas fa-plus"></i> 
							Добавить
						</router-link>
		            </div>
	            </div>
	            <transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-3">
				  				<label for="region_id">Сортировать по региону!</label>
			                    <select
			                      id="region_id"	
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                    >
			                      <option value="" selected >Выберите регион!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="time">Сортировать по дате открытия!</label>
				  				<date-picker
					                lang="ru"
					                type="date" 
					                v-model="filter.time"
					                format="YYYY-MM-DD" valueType="format"
					                placeholder="Выберите дату!"
					                class="input_style"
				              	></date-picker>

              				</div>
              				<div class="form-group col-lg-3">
				  				<label for="no_lots">Несостоявшиеся тендеры!</label>
				  				<input type="checkbox" v-model="filter.no_lots" class="form-control input_style" id="no_lots">
              				</div>
              				<div class="form-group col-lg-3">
				  				<label for="status">Неподтвержденные тендеры!</label>
				  				<input type="checkbox" v-model="filter.status" class="form-control input_style" id="status">
              				</div>
						  	<div class="col-lg-12 form-group d-flex justify-content-end">
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	сброс
							  	</button>
							  	<button type="button" class="btn btn-primary ml-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	найти
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
								<th scope="col">Статус</th>
								<th scope="col">Дата тендера</th>
								<th scope="col">Обшее количество поступивших предложений</th>
								<th scope="col">Обшее количество выставленных лотов</th>
								<th scope="col">Действия</th>
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
				await this.actionCompletedTendersList({page:page,items:this.filter})
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
					return 'В ожидании'
				}else if(status == 'rejected'){
					return 'Отказано'
				}else if(status == 'completed'){
					return 'Завершен'
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
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteTenderAnnounce(id)
                    await this.actionTenderAnnounces(page)
                    this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Тендер удален!',
				    })
				}
			}
		}
	}
</script>
