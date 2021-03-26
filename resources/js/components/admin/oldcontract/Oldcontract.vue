<template>
	<div class="oldcontract">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon fas fa-file-alt"></i>
				    Старые контракты 
				</h4>
				 <!-- v-if="$can('store', 'RegionController')" -->
				<router-link class="btn btn-primary" to="/crm/oldcontract/add">
					<i class="fas fa-plus"></i> 
					Добавить
				</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Регион</th>
							<th scope="col">Направления</th>
							<th scope="col">Название Компании</th>
							<th scope="col">Номер контракта</th>
							<th scope="col">Протокол рақами</th>
							<th scope="col">Контракт тузилган сана</th>
							<th scope="col">Амал қилиш муддати</th>
							<th scope="col">Контракт периоди</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getOldcontracts.data">
							<td scope="row">{{item.id}}</td>
							<td>{{item.region ? item.region.name : ''}}</td>
							<td>Направления</td>
							<td>{{item.number}}</td>
							<td>{{item.user ? item.user.company_name : ''}}</td>
							<td>{{item.protocol ? item.protocol.number : ''}}</td>
							<td>{{item.date}}</td>
							<td>{{item.exp_date}}</td>
							<td>{{getPeriod(item.contract_period)}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/oldcontract/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteOldcontract(item.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getOldcontracts" @pagination-change-page="getResults"></pagination>
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
				laoding: true
			}
		},
		async mounted(){
			let page = 1;
			await this.actionOldcontracts(page)
			this.laoding = false
		},
		computed:{
			...mapGetters('oldcontract',['getOldcontracts','getMassage'])
		},
		methods:{
			...mapActions('oldcontract',['actionOldcontracts','actionDeleteOldcontract']),
			async getResults(page = 1){ 
				this.laoding = true
				await this.actionOldcontracts(page)
				this.laoding = false
			},
			getPeriod(item){
				return item+' йил'
			},
			async deleteOldcontract(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					this.laoding = true
					await this.actionDeleteOldcontract(id)
					await this.actionOldcontracts(page)
					this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Oldcontract удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>
	
</style>