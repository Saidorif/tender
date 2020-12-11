<template>
	<div class="region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    Проверка тендеры
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Company name</th>
							<th scope="col">status</th>
							<th scope="col">tarif</th>
							<th scope="col">gps</th>
							<th scope="col">videoregistrator</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getCheckContolsList">
							<td scope="row">{{index+1}}</td>
							<td>{{item.user.company_name}}</td>
							<td>
                                <div class="badge" :class="getStatusClass(item.status)">
									{{getStatusName(item.status)}}
								</div>
                            </td>
							<td>{{item.tarif}}</td>
							<td>{{item.gps}}</td>
							<td>{{item.videoregistrator}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/check-control/show/${item.id}`'>
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
            await this.actionCheckContolsList(page)
            console.log(this.getCheckContolsList)
		},
		computed:{
			...mapGetters('checkcontrol',['getCheckContolsList'])
		},
		methods:{
			...mapActions('checkcontrol',['actionCheckContolsList']),
			async getResults(page = 1){
				await this.actionCheckContolsList(page)
            },
            getStatusClass(status){
				if(status == 'pending'){
					return 'badge-secondary'
				}else if(status == 'rejected'){
					return 'badge-danger'
				}else if(status == 'accepted'){
					return 'badge-success'
				}
            },
            getStatusName(status){
				if(status == 'pending'){
					return 'В ожидании'
				}else if(status == 'rejected'){
					return 'Отказано'
				}else if(status == 'accepted'){
					return 'Завершен'
				}
			},
		}
	}
</script>
