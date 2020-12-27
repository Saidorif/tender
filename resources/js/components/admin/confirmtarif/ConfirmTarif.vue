<template>
	<div class="region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-clipboard-check"></i>
				    Подтвердить тариф
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Направления</th>
							<th scope="col">Тариф</th>
							<th scope="col">Дата создания</th>
							<th scope="col">Статус</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<!-- <tr v-for="(item,index) in getTarifAnnounces.data">
							<td scope="row">{{item.id}}</td>
							<td>
								<em>
							    	{{item.tenderlots.length}}
							    	<span>{{item.tenderlots.length > 1 ? 'лоты' :'лот'}}</span>
							    </em>
							</td>
							<td>{{item.address}}</td>
							<td>{{item.time}}</td>
							<td :id="item.id">{{$g.dateCounter(item.time,item.id)}}</td>
							<td>
								<div class="badge" :class="getStatusClass(item.status)">
									{{getStatusName(item.status)}}
								</div>
							</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/confirm-tender/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr> -->
					</tbody>
					<!-- <pagination :limit="4" :data="getTarifAnnounces" @pagination-change-page="getResults"></pagination> -->
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
			// await this.actionTarifAnnounces(page)
		},
		computed:{
			// ...mapGetters('tarifannounce',['getTarifAnnounces','getMassage'])
		},
		methods:{
			// ...mapActions('tarifannounce',['actionTarifAnnounces','actionDeleteTarifAnnounce']),
			// async getResults(page = 1){
			// 	await this.actionTarifAnnounces(page)
			// },
			// getStatusName(status){
			// 	if(status == 'pending'){
			// 		return 'В ожидании'
			// 	}else if(status == 'rejected'){
			// 		return 'Отказано'
			// 	}else if(status == 'completed'){
			// 		return 'Завершен'
			// 	}
			// },
			// getStatusClass(status){
			// 	if(status == 'pending'){
			// 		return 'badge-secondary'
			// 	}else if(status == 'rejected'){
			// 		return 'badge-danger'
			// 	}else if(status == 'completed'){
			// 		return 'badge-success'
			// 	}
			// },
			// async deleteTarif(id){
			// 	if(confirm("Вы действительно хотите удалить?")){
			// 		let page = 1
			// 		await this.actionDeleteTarifAnnounce(id)
			// 		await this.actionTarifAnnounces(page)
			// 		toast.fire({
			// 	    	type: 'success',
			// 	    	icon: 'success',
			// 			title: 'Тендер удален!',
			// 	    })
			// 	}
			// }
		}
	}
</script>
