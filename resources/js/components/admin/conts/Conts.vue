<template>
	<div class="role">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    Controller 
				</h4>
				<router-link class="btn btn-primary" to="/crm/conts/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Label</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(cont,index) in getConts.data">
							<td scope="row">{{index+1}}</td>
							<td>{{cont.name}}</td>
							<td>{{cont.label}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/conts/edit/${cont.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							<!-- 	<button class="btn_transparent" @click="deleteConts(cont.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button> -->
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getConts" @pagination-change-page="getResults"></pagination>
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
			await this.actionConts()
		},
		computed:{
			...mapGetters('conts',['getConts','getMassage'])
		},
		methods:{
			...mapActions('conts',['actionConts']),
			async getResults(page = 1){ 
				await this.actionConts(page)
			},
		}
	}
</script>
<style scoped>
	
</style>