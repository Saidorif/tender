<template>
	<div class="complaint">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    Список жалобы 
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">ФИО</th>
							<th scope="col">Направление</th>
							<th scope="col">Телефон</th>
							<th scope="col">Статус</th>
							<th scope="col">Файл</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(compl,index) in getComplaintListAll.data">
							<td scope="row">{{index+1}}</td>
							<td>{{compl.surname}}{{compl.name}}{{compl.middlename}}</td>
							<td>{{compl.direction_id}}</td>
							<td>{{compl.phone}}</td>
							<td>
								<div class="badge" :class="getStatusClass(compl.status)">
									{{getStatusText(compl.status)}}
								</div>
							</td>
							<td>
								<img :src="compl.file" alt="" v-if="compl.file" width="40">
							</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/complaint-list/edit/${compl.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							<!-- 	<button class="btn_transparent" @click="deleteComplaint(compl.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button> -->
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getComplaintListAll" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
	import {mapActions, mapGetters} from 'vuex'
	export default{
		data(){
			return{

			}
		},
		async mounted(){
			let page = 1
			await this.actionComplaintListAll({page:page})
			console.log(this.getComplaintListAll)
		},
		computed:{
			...mapGetters('complaint',['getComplaintListAll','getMassage'])
		},
		methods:{
			...mapActions('complaint',['actionComplaintListAll']),
			async getResults(page = 1){ 
				await this.actionComplaintListAll(page)
			},
			getStatusText(text){
				if (text == 'pending') {
					return 'Новая жалоба'
				}else{
					return 'Рассмотрено'
				}
			},
			getStatusClass(text){
				if (text == 'pending') {
					return 'badge-warning'
				}else{
					return 'badge-seccuss'
				}
			},
			// async deleteComplaint(id){
			// 	if(confirm("Вы действительно хотите удалить?")){
			// 		let page = 1
			// 		await this.actionDeleteComplaint(id)
			// 		await this.getComplaintListAll(page)
			// 		toast.fire({
			// 	    	type: 'success',
			// 	    	icon: 'success',
			// 			title: 'Вариант жалобы удалено!',
			// 	    })
			// 	}
			// }
		}
	}
</script>
<style scoped>
	
</style>