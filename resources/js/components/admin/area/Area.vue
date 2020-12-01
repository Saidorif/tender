<template>
	<div class="area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    Area 
				</h4>
				<router-link class="btn btn-primary" to="/crm/area/add"><i class="fas fa-plus"></i> Добавить</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Регион</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(area,index) in getAreas.data">
							<td scope="row">{{index+1}}</td>
							<td>{{area.name}}</td>
							<td>{{area.region.name}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/area/edit/${area.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteArea(area.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getAreas" @pagination-change-page="getResults"></pagination>
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
			await this.actionAreas(page)
		},
		computed:{
			...mapGetters('area',['getAreas','getMassage'])
		},
		methods:{
			...mapActions('area',['actionAreas','actionDeleteArea']),
			async getResults(page = 1){ 
				await this.actionAreas(page)
			},
			async deleteArea(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteArea(id)
					await this.actionAreas(page)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Area удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>
	
</style>