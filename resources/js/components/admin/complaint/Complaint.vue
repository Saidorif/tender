<template>
	<div class="complaint">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    Вариант жалобы 
				</h4>
				<router-link class="btn btn-primary" to="/crm/complaint/add"><i class="fas fa-plus"></i> Добавить</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Заголовок</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<!-- <tr v-for="(compl,index) in getComplaint.data">
							<td scope="row">{{index+1}}</td>
							<td>{{compl.name}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/complaint/edit/${compl.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteComplaint(compl.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr> -->
					</tbody>
					<!-- <pagination :limit="4" :data="getComplaint" @pagination-change-page="getResults"></pagination> -->
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
			await this.actionComplaints()
		},
		computed:{
			...mapGetters('complaint',['getComplaints','getMassage'])
		},
		methods:{
			...mapActions('complaint',['actionComplaints']),
			async getResults(page = 1){ 
				await this.actionComplaints(page)
			},
			deleteComplaint(id){
				console.log(id)
			}
		}
	}
</script>
<style scoped>
	
</style>