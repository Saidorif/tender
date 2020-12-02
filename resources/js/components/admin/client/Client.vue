<template>
	<div class="employee">
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title">
				    <h4 class="title_user">
				    	<i  class="peIcon pe-7s-users"></i>
					     Перевозчики 
					</h4>
					<div class="add_user_btn">
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	Филтр
						</button>
		            </div>
		  		</div>
		    	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-3">
				                <label for="surname">Фамилия</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="surname"
				                  placeholder="Фамилия"
				                  v-model="filter.surname"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
				                <label for="name">Имя</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="name"
				                  placeholder="Имя"
				                  v-model="filter.name"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
				                <label for="middlename">Отчество</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="middlename"
				                  placeholder="Отчество"
				                  v-model="filter.middlename"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
	  							<label for="inn">ИНН</label>
	  							<input 
	  								type="text" 
	  								class="form-control" 
	  								id="inn" 
	  								placeholder="ИНН..."
	  								v-model="filter.inn"
  								>
				  			</div>
				  			<div class="form-group col-lg-3">
				  				<label for="region_id">Область</label>
			                    <select
			                      id="region_id"
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                      @change="selectRegion()"
			                    >
			                      <option value="" selected disabled>Выберите область!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="area_id">Регион/Город!</label>
			                    <select
			                      id="area_id"	
			                      class="form-control input_style"
			                      v-model="filter.area_id"
			                    >
			                      <option value="" selected disabled>Выберите регин или город!</option>
			                      <option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
			                    </select>
              				</div>
  					  		<div class="form-group col-lg-3">
	  							<label for="company_name">Название компании</label>
	  							<input 
	  								type="text" 
	  								class="form-control" 
	  								id="company_name" 
	  								placeholder="Название компании..."
	  								v-model="filter.company_name"
  								>
				  			</div>
						  	<div class="col-lg-3 form-group btn_search">
							  	<button type="button" class="btn btn-primary mr-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	найти
							  	</button>
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	сброс
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
							<th scope="col">Ф.И.О</th>
							<th scope="col">Название компании</th>
							<th scope="col">ИНН</th>
							<th scope="col">Область</th>
							<th scope="col">Регион/Город</th>
							<th scope="col">E-mail</th>
							<th scope="col">Телефон</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getClients.data">
							<td scope="row">{{item.id}}</td>
							<td>{{item.surname}} {{item.name}} {{item.middlename}}</td>
							<td>{{item.company_name}}</td>
							<td>{{item.inn}}</td>
							<td>{{item.region ? item.region.name : ''}}</td>
							<td>{{item.area ? item.area.name : ''}}</td>
							<td>{{item.email}}</td>
							<td>{{item.phone}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/client/edit/${item.id}`'>
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
	export default{
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
			}
		},
		async mounted(){
			let page = 1;
			await this.actionClients({page:page,items:this.filter})
			await this.actionRegionList();
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
			// 	if(confirm("Вы действительно хотите удалить?")){
			// 		let page = 1
			// 		await this.actionDeleteEmployee(id)
			// 		await this.actionClients({page: page,items:this.filter})
			// 		toast.fire({
			// 	    	type: 'success',
			// 	    	icon: 'success',
			// 			title: 'Пользователь удалено!',
			// 	    })
			// 	}
			// }
		}
	}
</script>
<style scoped>
	
</style>