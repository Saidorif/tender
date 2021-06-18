<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i class="peIcon fas fa-clipboard-check"></i>
					    Подтвердить тариф
					</h4>
	            	<div class="add_user_btn">
		                <span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
		            		Количество <b>{{ getPassportList.total }} шт.</b>
		            	</span>
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
				  				<label for="dir_type">Сортировать по типу маршрута!</label>
			                    <select
			                      id="dir_type"
			                      class="form-control input_style"
			                      v-model="filter.dir_type"
			                    >
			                      <option value="" selected >Выберите тип маршрута!</option>
			                      <option value="bus">Автобус йуналиши</option>
                      			  <option value="taxi">Йўналиши тахи йуналиши</option>
			                    </select>
              				</div>
              				<div class="form-group col-lg-3">
				  				<label for="type_id">Сортировать по локацию маршрута!</label>
			                    <select
			                      id="type_id"
			                      class="form-control input_style"
			                      v-model="filter.type_id"
			                    >
			                      <option value="" selected >Выберите локацию маршрута!</option>
			                      <option
					                  :value="item.id"
					                  v-for="(item,index) in getTypeofdirectionList"
				                  >{{item.name }} {{item.type}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="range">Сортировать!</label>
				  				<select
			                      id="range"
			                      class="form-control input_style"
			                      v-model="range"
			                      @change="rangeChange"
			                    >
			                      <option value="" selected >Выберите локацию маршрута!</option>
			                      <option value="min" >По снижению</option>
			                      <option value="max" >По возрастанию</option>
								</select>
              				</div>
                            <div class="form-group col-lg-3">
				  				<label for="dir_name">Наименования  маршрута</label>
                                  <input class="form-control input_style" placeholder="Поиск по наименования маршрута" type="text" v-model="filter.name" id="dir_name">
              				</div>
                            <div class="form-group col-lg-2">
				  				<label for="bypass_number">Номер направления</label>
                                  <input class="form-control input_style" placeholder="Поиск по номеру" type="text" v-model="filter.pass_number" id="bypass_number">
              				</div>
                            <div class="form-group col-lg-2">
				  				<label for="status">По статусу</label>
			                    <select
			                      id="status"
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected >Выберите статус!</option>
			                      <option value="approved"  >Потвержден</option>
			                      <option value="pending"  >Не потвержден</option>
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
							<th scope="col">Направления</th>
							<th scope="col">Номер направление</th>
							<th scope="col">Тариф</th>
							<th scope="col">Сумма багажа</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getPassportList.data">
							<td scope="row">{{item.id}}</td>
							<td scope="row">{{item.name}}</td>
							<td scope="row">{{item.pass_number}}</td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.passport_tarif" >
                                        {{ch_item.summa}}
                                    </li>
                                </ul>
                            </td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.passport_tarif" >
                                        {{ch_item.summa_bagaj}}
                                    </li>
                                </ul>
                            </td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.passport_tarif" >
                                    	<div class="badge" :class="getStatusClass(ch_item.status)">
	                                        {{ch_item.status == 'pending' ? 'не подтвержден' : 'подтвержден'}}
                                    	</div>
                                    </li>
                                </ul>
                            </td>
							<td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.passport_tarif" >
                                        <button type="button" class="btn" :class="ch_item.status == 'approved' ? 'btn-success' : 'fas btn-warning'" style="padding: 2px 9px;"
                                        	@click="completedTender(ch_item.id)"
                                    	>
                                            <i :class="ch_item.status == 'approved' ? 'far fa-check-circle' : 'fas fa-times'"></i>
                                        </button>
                                    </li>
                                </ul>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getPassportList" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
    import { mapGetters , mapActions } from 'vuex'
    import Loader from '../../Loader'
    import DatePicker from "vue2-datepicker";
	export default{
        components:{
            Loader,
            DatePicker,
        },
		data(){
			return{
	            filter:{
	            	region_id:'',
					type_id:'',
					dir_type:'',
					max:false,
					min:false,
                    name: '',
                    pass_number: '',
                    status: '',
	            },
				range:'',
				page:1,
                laoding: true,
                filterShow: false,
			}
		},
		async mounted(){
            await this.actionPortTarifList({page:this.page,items:this.filter});
            await this.actionRegionList()
			await this.actionTypeofdirectionList()
            this.laoding = false
		},
		computed:{
			...mapGetters('tarifannounce',['getPassportList', 'getMassage']),
			...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
			...mapGetters("region", ["getRegionList"]),
		},
		methods:{
            ...mapActions('tarifannounce',['actionPortTarifList', 'actionApprovePassportTarifList']),
            ...mapActions("region", ["actionRegionList"]),
			...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
            async completedTender(id){
                this.laoding = true
                await this.actionApprovePassportTarifList({tarif_id: id})
                if(this.getMassage.success){
                    await this.actionPortTarifList({page:this.page,item:this.filter});
                    toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Тендер тариф подтверждена!',
				    })
                }
                this.laoding = false
            },
            toggleFilter(){
				this.filterShow = !this.filterShow
			},
			rangeChange(){
				if(this.range == 'min'){
					this.filter.min = true
					this.filter.max = false
				}else if(this.range == 'max'){
					this.filter.min = false
					this.filter.max = true
				}
			},
			async search(){
				if(this.filter.status != '' || this.filter.pass_number != '' || this.filter.name != '' || this.filter.region_id != '' || this.filter.type_id != ''  || this.filter.dir_type != '' || this.filter.max || this.filter.min ){
					let data = {
						page:this.page,
						items:this.filter
					}
					this.laoding = true
					await this.actionPortTarifList(data)
					this.laoding = false
				}
			},
			async clear(){
				this.filter.region_id = ''
				this.filter.type_id = ''
				this.filter.dir_type = ''
				this.filter.status = ''
				this.filter.pass_number = ''
				this.filter.name = ''
				this.filter.min = false
				this.filter.max = false
				this.range = ''
                let page  = 1
                this.laoding = true
                await this.actionPortTarifList({page: page,items:this.filter})
                this.laoding = false
			},
			async getResults(page = 1){
				await this.actionPortTarifList({page:page,items:this.filter})
			},
			// getStatusName(status){
			// 	if(status == 'pending'){
			// 		return 'В ожидании'
			// 	}else if(status == 'rejected'){
			// 		return 'Отказано'
			// 	}else if(status == 'completed'){
			// 		return 'Завершен'
			// 	}
			// },
			getStatusClass(status){
				if(status == 'pending'){
					return 'badge-warning'
				}else if(status == 'approved'){
					return 'badge-success'
				}
			},
			// async deleteTarif(id){
			// 	if(confirm("Вы действительно хотите удалить?")){
			// 		let page = 1
			// 		await this.actionDeleteTarifAnnounce(id)
			// 		await this.actionTarifAnnounces(page)
			// 		toast.fire({
			// 	    	type: 'success',
			// 	    	icon: 'success',
			// 			title: 'Тендер удален!',
			// 	    })
			// 	}
			// }
		}
	}
</script>
<style  scoped>
    .table_item_list{
        margin-bottom: 0;
    }
    .table_item_list li{
        list-style: none;
        border-bottom: 1px solid #000;
    }
        .table_item_list li:last-child{
            border: 0px;
        }
</style>
