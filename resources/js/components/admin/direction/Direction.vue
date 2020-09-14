<template>
	<div class="area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-route"></i>
				    Направления 
				</h4>
				<router-link class="btn btn-primary" to="/crm/direction/add"><i class="fas fa-plus"></i> Добавить</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Серия направления</th>
							<th scope="col">Название направления</th>
							<th scope="col">Номер направления</th>
							<th scope="col">Регион (From)</th>
							<th scope="col">Area (From)</th>
							<th scope="col">Регион (To)</th>
							<th scope="col">Area (To)</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<!-- <tr v-for="(direct,index) in getDirections.data">
							<td scope="row">{{index+1}}</td>
							<td>{{direct.name}}</td>
							<td>{{direct.region_from.name}}</td>
							<td>{{direct.area_from ? direct.area_from.name : ''}}</td>
							<td>{{direct.region_to.name}}</td>
							<td>{{direct.area_to ? direct.area_to.name : ''}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/direction/edit/${direct.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deletePassport(direct.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr> -->
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
	export default{
		data(){
			return{

			}
		},
		async mounted(){
			let page = 1;
			await this.actionDirections()
		},
		computed:{
			...mapGetters('direction',['getDirections','getMassage'])
		},
		methods:{
			...mapActions('direction',['actionDirections','actionDeleteDirection']),
			async getResults(page = 1){ 
				await this.actionDirections(page)
			},
			async deletePassport(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteDirection(id)
					await this.actionDirections(page)
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
	
</style>