<template>
	<div class="region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    Подтверждение тендера 
				</h4>
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
						<tr v-for="(item,index) in getTenderAnnounces.data">
							<td scope="row">{{index+1}}</td>
							<td>
								<ul class="list-inline">
								    <li v-for="(val,key) in item.direction_ids">
								    	<b>{{val.name}}</b>
								    	<em v-if="item.tenderlots[key].reys_id.length > 0">
									    	({{item.tenderlots[key].reys_id.length}} рейс)
									    </em>
								    </li>
								</ul>
							</td>
							<td>{{item.address}}</td>
							<td>{{item.time}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/confirm-tender/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getTenderAnnounces" @pagination-change-page="getResults"></pagination>
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
			await this.actionTenderAnnounces(page)
		},
		computed:{
			...mapGetters('tenderannounce',['getTenderAnnounces','getMassage'])
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
						title: 'Тендер удален!',
				    })
				}
			}
		}
	}
</script>