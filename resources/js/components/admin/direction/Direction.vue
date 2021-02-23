<template>
	<div class="area">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i class="peIcon fas fa-route"></i>
					    Направления
					</h4>
	            	<div class="add_user_btn">
		                <span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
		            		Количество направления <b>{{ getDirections.total }} шт.</b>
		            	</span>
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
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
				  			<div class="form-group col-lg-2">
				  				<label for="bypass_number">Номер направления</label>
                                  <input class="form-control input_style" placeholder="Поиск по номеру" type="text" v-model="filter.pass_number" id="bypass_number">
              				</div>
				  			<div class="form-group col-lg-2">
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
				  			<div class="form-group col-lg-2">
				  				<label for="status">По статусу закрепления!</label>
			                    <select
			                      id="status"
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected >Выберите статус закрепления!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="status">По статусу размещения!</label>
			                    <select
			                      id="status"
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected >Выберите статус размещения!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="bustype_id">Сортировать по типу авто!</label>
			                    <select
			                      id="bustype_id"
			                      class="form-control input_style"
			                      v-model="filter.bustype_id"
			                    >
			                      <option value="" selected >Выберите тип авто!</option>
			                      <option
				                      :value="busType.id"
				                      v-for="(busType,index) in getTypeofbusList"
			                    	>{{busType.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="profitability">Сортировать по рентабельности!</label>
			                    <select
			                      id="profitability"
			                      class="form-control input_style"
			                      v-model="filter.profitability"
			                    >
			                      <option value="" selected >Выберите рентабельность!</option>
			                      <option value="profitable">Рентабельный</option>
					              <option value="unprofitable">Нерентабельный</option>
					              <option value="middle">Средный</option>
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
				  				<label for="year">Сортировать по дате открытия!</label>
				  				<date-picker
					                lang="ru"
					                type="year" format="YYYY" valueType="format"
					                v-model="filter.year"
					                placeholder="Выберите дату!"
					                class="input_style"
				              	></date-picker>
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
						<!-- <tr>
							<th scope="col" width="2%">№</th>
							<th scope="col">Область</th>
							<th scope="col">Название направления</th>
							<th scope="col"></th>
							<th scope="col"></th>
							<th scope="col"></th>
							<th scope="col"></th>
							<th scope="col">Номер направления</th>
							<th scope="col">Год создания</th>
							<th scope="col">Действия</th>
						</tr> -->
                        <tr>
                            <th scope="col">№</th>
                            <th>Регион</th>
                            <th>Номер и наименования маршрута</th>
                            <th>Наименования организации </th>
                            <th>Срок действитвия контракта </th>
                            <th>Статус</th>
                            <th>Йўналиши тури</th>
                            <th>Дата открытия</th>
                            <th>Потверждения</th>
                            <th scope="col">Действия</th>
                        </tr>
					</thead>
					<tbody>
						<tr v-for="(direct,index) in getDirections.data">
							<td scope="row">{{index + 1}}</td>
							<td>
								<template v-if="direct.created_by">
									{{direct.created_by.region ? direct.created_by.region.name : ''}}
								</template>
							</td>
							<td><b>{{direct.pass_number}}</b> - {{direct.name}}</td>
							<td></td>
							<td></td>
							<td><span class="alert alert-danger pt-1 pb-1">Неразмещен в тендер</span>  </td>
							<td>{{direct.dir_type == 'taxi' ? 'Йўналишли тахи йуналиши' : 'Автобус йуналиши'}}</td>
							<td>{{direct.year}}</td>
							<td>{{ checkApprove(direct) }}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/direction/edit/${direct.id}`'
									v-if="$can('edit', 'DirectionController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deletePassport(direct.id)"
									v-if="$can('destroy', 'DirectionController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getDirections" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
	import DatePicker from "vue2-datepicker";
	import { mapGetters, mapActions } from "vuex";
	import 'vue2-datepicker/index.css';
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
					dir_type:'',
					bustype_id:'',
					type_id:'',
					profitability:'',
                    year:'',
                    pass_number: '',
				},
				filterShow:false,
				laoding: true
			}
		},
		async mounted(){
            let page = 1;
            this.filter = localStorage.getItem("dir_f") ? JSON.parse(localStorage.getItem("dir_f")) : this.filter
			await this.actionDirections({page:page,items:this.filter})
			await this.actionRegionList()
			await this.actionTypeofbusList()
			await this.actionTypeofdirectionList()
            this.laoding = false
		},
		computed:{
			...mapGetters('direction', ['getDirections','getMassage']),
			...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
			...mapGetters("region", ["getRegionList"]),
			...mapGetters('typeofbus', ['getTypeofbusList']),
		},
		methods:{
			...mapActions('direction',['actionDirections','actionDeleteDirection']),
			...mapActions("region", ["actionRegionList"]),
			...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
			...mapActions('typeofbus',['actionTypeofbusList']),
			async getResults(page = 1){
				await this.actionDirections({page:page,items:this.filter})
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.pass_number != '' || this.filter.region_id != '' || this.filter.dir_type != '' || this.filter.type_id != '' || this.filter.year != '' || this.filter.profitability != '' || this.filter.bustype_id != ''){
					let data = {
						page:page,
						items:this.filter
                    }
                    localStorage.setItem("dir_f",  JSON.stringify(this.filter))
					this.laoding = true
					await this.actionDirections(data)
					this.laoding = false
				}
			},
			async clear(){
				// if(this.filter.pass_number != '' ||   this.filter.region_id != '' || this.filter.dir_type != '' || this.filter.type_id != '' || this.filter.year != '' || this.filter.profitability != '' || this.filter.bustype_id != ''){
					this.filter.region_id = ''
					this.filter.dir_type = ''
					this.filter.type_id = ''
					this.filter.year = ''
					this.filter.profitability = ''
					this.filter.bustype_id = ''
					this.filter.pass_number = ''
                    let page  = 1
                    this.laoding = true
                    localStorage.setItem("dir_f",  JSON.stringify(this.filter))
                    await this.actionDirections({page: page,items:this.filter})
                    this.laoding = false
				// }

			},
			async deletePassport(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					this.laoding = true
					await this.actionDeleteDirection(id)
					await this.actionDirections({page: page,items:this.filter})
					this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Passport удалено!',
				    })
				}
			},
            checkApprove(item){
                if(
                    item.xronom_status == 'completed' &&
                    item.xjadval_status == 'completed' &&
                    item.titul_status == 'completed' &&
                    item.sxema_status == 'completed'
                ){
                    return 'да'
                }else{
                    return 'нет'
                }
            }
		}
	}
</script>
<style scoped>
	.toggleFilter{
		margin-right:15px;
	}
</style>
