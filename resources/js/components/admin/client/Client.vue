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
	  							<label for="name">Ф.И.О</label>
	  							<input 
	  								type="text" 
	  								class="form-control" 
	  								id="name" 
	  								placeholder="Ф.И.О..."
	  								v-model="filter.name"
  								>
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
							<th scope="col">E-mail</th>
							<th scope="col">Телефон</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getClients.data">
							<td scope="row">{{index+1}}</td>
							<td>{{item.name}}</td>
							<td>{{item.company_name}}</td>
							<td>{{item.inn}}</td>
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
					name:'',
					inn:'',
					company_name:'',
				},
				filterShow:false,
			}
		},
		async mounted(){
			let page = 1;
			await this.actionClients({page:page,items:this.filter})
		},
		computed:{
			...mapGetters('client',['getClients']),
		},
		methods:{
			...mapActions('client',['actionClients']),
			async getResults(page = 1){ 
				await this.actionClients({page:page,items:this.filter})
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.name || this.filter.inn || this.filter.company_name){
					await this.actionClients({page: page,items:this.filter})
				}
			},
			async clear(){
				if(this.filter.name || this.filter.inn || this.filter.company_name){
					this.filter.name = ''
					this.filter.inn = ''
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