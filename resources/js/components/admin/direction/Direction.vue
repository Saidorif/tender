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
				  			<div class="form-group col-lg-3">
				  				<label for="region_id">Сортировать по региону!</label>
			                    <select
			                      id="region_id"	
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                    >
			                      <option value="" selected disabled>Выберите регион!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="status">Сортировать по статусу закрепления!</label>
			                    <select
			                      id="status"	
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected disabled>Выберите статус закрепления!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="status">Сортировать по статусу размещения!</label>
			                    <select
			                      id="status"	
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected disabled>Выберите статус размещения!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="type_id">Сортировать по типу авто!</label>
			                    <select
			                      id="type_id"	
			                      class="form-control input_style"
			                      v-model="filter.type_id"
			                    >
			                      <option value="" selected disabled>Выберите тип авто!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="bustype_id">Сортировать по рентабельности!</label>
			                    <select
			                      id="bustype_id"	
			                      class="form-control input_style"
			                      v-model="filter.bustype_id"
			                    >
			                      <option value="" selected disabled>Выберите рентабельность!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="bustype_id">Сортировать по локацию маршрута!</label>
			                    <select
			                      id="bustype_id"	
			                      class="form-control input_style"
			                      v-model="filter.bustype_id"
			                    >
			                      <option value="" selected disabled>Выберите локацию маршрута!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="dir_type">Сортировать по типу маршрута!</label>
			                    <select
			                      id="dir_type"	
			                      class="form-control input_style"
			                      v-model="filter.dir_type"
			                    >
			                      <option value="" selected disabled>Выберите тип маршрута!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="year">Сортировать по дате открытия!</label>
			                    <select
			                      id="year"	
			                      class="form-control input_style"
			                      v-model="filter.year"
			                    >
			                      <option value="" selected disabled>Выберите дату!</option>
			                    </select>
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
							<th scope="col">Название направления</th>
							<th scope="col">Номер направления</th>
							<th scope="col">Год создания</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(direct,index) in getDirections.data">
							<td scope="row">{{index + 1}}</td>
							<td>{{direct.name}}</td>
							<td>{{direct.pass_number}}</td>
							<td>{{direct.year}}</td>
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
					<!-- <pagination :limit="4" :data="getDirections" @pagination-change-page="getResults"></pagination> -->
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
					region_id:'',
					dir_type:'',
					type_id:'',
					profitability:'',
					status:'',
					year:'',
					bustype_id:'',
				},
				filterShow:false,
				laoding: true
			}
		},
		async mounted(){
			let page = 1;
			await this.actionDirections()
            this.laoding = false
		},
		computed:{
			...mapGetters('direction',['getDirections','getMassage'])
		},
		methods:{
			...mapActions('direction',['actionDirections','actionDeleteDirection']),
			async getResults(page = 1){
				await this.actionDirections(page)
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				
			},
			async clear(){
				

			},
			async deletePassport(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					this.laoding = true
					await this.actionDeleteDirection(id)
					await this.actionDirections(page)
					this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Passport удалено!',
				    })
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
