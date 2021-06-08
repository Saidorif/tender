<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
			<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i class="peIcon fas fa-bus"></i>
					    Модель автобуса
					</h4>
		          	<div class="add_user_btn">
			            <span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
			          		Количество модель <b>{{ getBusmodels.total }} шт.</b>
			          	</span>
			            <button type="button" class="btn btn-info toggleFilter mr-3" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	Филтр
						</button>
						<router-link class="btn btn-primary" to="/crm/busmodel/add">
							<i class="fas fa-plus"></i>
							Добавить
						</router-link>
		            </div>
	          	</div>
	          	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-3">
				  				<label for="model_id">Сортировать по моделу авто!</label>
			                    <select
			                      id="model_id"
			                      class="form-control input_style"
			                      v-model="filter.model_id"
			                    >
			                      <option value="" selected >Выберите моделу авто!</option>
			                      <option
				                      :value="busType.id"
				                      v-for="(busType,index) in getBusmodelList"
			                    	>{{busType.name}}</option>
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
				  				<label for="tclass_id">Сортировать по классу авто!</label>
			                    <select
			                      id="tclass_id"
			                      class="form-control input_style"
			                      v-model="filter.tclass_id"
			                    >
			                      <option value="" selected >Выберите класс авто!</option>
			                      <option
				                      :value="busType.id"
				                      v-for="(busType,index) in getBusclassList"
			                    	>{{busType.name}}</option>
			                    </select>
	          				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="busmarka_id">Сортировать по марку авто!</label>
			                    <select
			                      id="busmarka_id"
			                      class="form-control input_style"
			                      v-model="filter.busmarka_id"
			                    >
			                      <option value="" selected >Выберите марку авто!</option>
			                      <option
				                      :value="busType.id"
				                      v-for="(busType,index) in getBusBrandList"
			                    	>{{busType.name}}</option>
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
								<th scope="col">Марка</th>
								<th scope="col">Категория автобуса</th>
								<th scope="col">Модель </th>
								<th scope="col">Название класса </th>
								<th scope="col">Количество сидящих</th>
								<!-- <th scope="col">Количество сидящих (по)</th> -->
								<th scope="col">Пассажировместимость</th>
								<!-- <th scope="col">Пассажировместимость (по)</th> -->
								<th scope="col">Действия</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(model,index) in getBusmodels.data">
								<td scope="row">{{model.id}}</td>
								<td>{{model.marka ? model.marka.name : ''}}</td>
								<td>{{model.bustype ? model.bustype.name : ''}}</td>
								<td>{{model.name}}</td>
								<td>{{model.tclass ? model.tclass.name : ''}}</td>
								<td>{{model.seat_from}}</td>
								<!-- <td>{{model.seat_to}}</td> -->
								<td>{{model.stay_from}}</td>
								<!-- <td>{{model.stay_to}}</td> -->
								<td>
									<router-link
										tag="button"
										class="btn_transparent"
										:to='`/crm/busmodel/edit/${model.id}`'
										v-if="$can('edit', 'BusModelController')"
									>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
									<button
										class="btn_transparent"
										@click="deleteType(model.id)"
										v-if="$can('destroy', 'BusModelController')"
									>
										<i class="pe_icon pe-7s-trash trashColor"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getBusmodels" @pagination-change-page="getResults"></pagination>
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
					model_id:'',
					bustype_id:'',
					tclass_id:'',
					busmarka_id:'',
				},
                laoding: true,
                filterShow: false,
			}
		},
		async mounted(){
			let page = 1;
			let data = {
				page:page,
				items:this.filter
			}
            await this.actionBusmodels(data)
            await this.actionBusmodelList()
            await this.actionTypeofbusList()
            await this.actionBusclassList()
            await this.actionBusBrandList()
            this.laoding = false
		},
		computed:{
			...mapGetters('busmodel',['getBusmodels','getMassage','getBusmodelList']),
			...mapGetters('typeofbus', ['getTypeofbusList']),
			...mapGetters("busbrand", ["getBusBrandList"]),
			...mapGetters('busclass',['getBusclassList']),
		},
		methods:{
			...mapActions('busmodel',['actionBusmodels','actionDeleteBusmodel','actionBusmodelList']),
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions("busbrand", ["actionBusBrandList"]),
			...mapActions('busclass',['actionBusclassList']),
			async getResults(page = 1){
				let data = {
					page:page,
					items:this.filter
				}
	            await this.actionBusmodels(data)
			},
			async search(){
				let page = 1
				if(this.filter.model_id != '' || this.filter.bustype_id != '' || this.filter.tclass_id != '' || this.filter.busmarka_id != ''){
					let data = {
						page:page,
						items:this.filter
                    }
					this.laoding = true
					await this.actionBusmodels(data)
					this.laoding = false
				}
			},
			async clear(){
				this.filter.model_id = ''
				this.filter.bustype_id = ''
				this.filter.tclass_id = ''
				this.filter.busmarka_id = ''
                let page  = 1
                this.laoding = true
                await this.actionBusmodels({page: page,items:this.filter})
                this.laoding = false
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async deleteType(id){
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteBusmodel(id)
					if (this.getMassage.success) {
						let data = {
							page:page,
							items:this.filter
						}
			            await this.actionBusmodels(data)
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
				          });
						this.$router.push("/crm/typeofbus");
						this.requiredInput = false
                    }
                    this.laoding = false
				}
			}
		}
	}
</script>
<style scoped>

</style>
