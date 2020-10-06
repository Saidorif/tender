<template>
	<div class="region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    Объявить тендер 
				</h4>
				<router-link class="btn btn-primary" to="/crm/tenderannounce/add">
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
							<th scope="col">Название маршрута</th>
							<th scope="col">Адрес</th>
							<th scope="col">Дата тендера</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<!-- <tr v-for="(reg,index) in getRegions.data">
							<td scope="row">{{index+1}}</td>
							<td>{{reg.name}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/region/edit/${reg.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteRegion(reg.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr> -->
					</tbody>
					<!-- <pagination :limit="4" :data="getRegions" @pagination-change-page="getResults"></pagination> -->
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
			await this.actionTenderAnnounces()
		},
		computed:{
			...mapGetters('tenderannounce',['getRegions','getMassage'])
		},
		methods:{
			...mapActions('tenderannounce',['actionTenderAnnounces','actionDeleteTenderAnnounce']),
			async getResults(page = 1){ 
				await this.actionTenderAnnounces(page)
			},
			async deleteRegion(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteTenderAnnounce(id)
					await this.actionTenderAnnounces(page)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Region удалено!',
				    })
				}
			}
		}
	}
</script>