<template>
	<div class="area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    Автостанция 
				</h4>
				<router-link class="btn btn-primary" to="/crm/station/add"><i class="fas fa-plus"></i> Добавить</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Области</th>
							<th scope="col">Регион</th>
							<th scope="col">Тип станции</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(station,index) in getStations.data">
							<td scope="row">{{index+1}}</td>
							<td>{{station.name}}</td>
							<td>{{station.region ? station.region.name : ''}}</td>
							<td>{{station.area ? station.area.name : ''}}</td>
							<td>{{station.station_type}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/station/edit/${station.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteStation(station.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getStations" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	export default{
		data(){
			return{

			}
		},
		async mounted(){
			let page = 1;
			await this.actionStations()
		},
		computed:{
			...mapGetters('station',['getStations','getMassage'])
		},
		methods:{
			...mapActions('station',['actionStations','actionDeleteStation']),
			async getResults(page = 1){ 
				await this.actionStations(page)
			},
			async deleteStation(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteStation(id)
					await this.actionStations(page)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Station удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>
	
</style>