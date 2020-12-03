<template>
	<div class="region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-clipboard-check"></i>
				    Подтвердить тендер
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Адрес</th>
							<th scope="col">Дата тендера</th>
							<th scope="col">Статус</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getTendersList.data">
							<td scope="row">{{index+1}}</td>
							<td>{{item.address}}</td>
							<td>{{item.time}}</td>
							<td>
								<div class="badge" :class="getStatusClass(item.status)">
									{{getStatusName(item.status)}}
								</div>
							</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/completed-tenders/show/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<!-- <pagination :limit="4" :data="getTendersList" @pagination-change-page="getResults"></pagination> -->
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
            await this.actionCompletedTendersList(page)
		},
		computed:{
			...mapGetters('completedtender',['getTendersList','getMassage'])
		},
		methods:{
			...mapActions('completedtender',['actionCompletedTendersList']),
			async getResults(page = 1){
				await this.actionCompletedTendersList(page)
			},
			getStatusName(status){
				if(status == 'pending'){
					return 'В ожидании'
				}else if(status == 'rejected'){
					return 'Отказано'
				}else if(status == 'completed'){
					return 'Завершен'
				}
			},
			getStatusClass(status){
				if(status == 'pending'){
					return 'badge-secondary'
				}else if(status == 'rejected'){
					return 'badge-danger'
				}else if(status == 'completed'){
					return 'badge-success'
				}
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
