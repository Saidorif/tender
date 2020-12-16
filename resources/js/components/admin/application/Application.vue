<template>
	<div class="application">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    Заявки
				</h4>
	<!-- 			<button type="button" class="btn btn-primary" @click.prevent="getEditId">
					<i class="fas fa-plus"></i> 
					Добавить
				</button> -->
		<!-- 		<router-link class="btn btn-primary" to="/crm/application/add">
					<i class="fas fa-plus"></i> 
					Добавить
				</router-link> -->
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Маршруты</th>
							<th scope="col">Статус</th>
							<th scope="col">Количество автотранспорта</th>
							<th scope="col">Дата</th>
							<th scope="col">Осталось</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getApplications.data">
							<td scope="row">{{reg.id}}</td>
							<td>
								<ul class="list-inline" v-if="reg.lots.direction_id.length > 0">
								    <li v-for="(val,key) in reg.lots.direction_id">
								    	<b>{{val.name}}</b>
								    </li>
								</ul>
							</td>
							<td>
								<div class="badge " :class="getStatusClass(reg.status)">
									{{getStatusName(reg.status)}}
								</div>
							</td>
							<td width="15%">{{reg.cars_with.length}}</td>
							<td>{{reg.lots.time}}</td>
							<td :id="reg.id">{{$g.dateCounter(reg.lots.time,reg.id)}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/application/user/${reg.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteRegion(reg.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getApplications" @pagination-change-page="getResults"></pagination>
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
			await this.actionApplications()
		},
		computed:{
			...mapGetters('application',[
				'getApplications',
				'getApplication',
				'getMassage',
				'getAddMessage'
			])
		},
		methods:{
			...mapActions('application',[
				'actionApplications',
				'actionDeleteApplication',
				'actionAddApplication',
			]),
			async getResults(page = 1){ 
				await this.actionApplications(page)
			},
			async getEditId(){
				await this.actionAddApplication()
				if (this.getAddMessage.success) {
					this.$router.push("/crm/application/edit/"+this.getAddMessage.result.id);
				}
			},
			getStatusName(status){
				if(status == 'active'){
					return 'Активный!'
				}else if(status == 'accepted'){
					return 'Завершен!'
				}
			},
			getStatusClass(status){
				if(status == 'active'){
					return 'badge-success'
				}else if(status == 'accepted'){
					return 'badge-primary'
				}
			},
			async deleteRegion(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteApplication(id)
					await this.actionApplications(page)
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
<style scoped>
	
</style>