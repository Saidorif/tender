<template>
	<div class="area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-vote-yea"></i>
				    Доступ 
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Регион</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(area,index) in getApplies.data">
							<td scope="row">{{apply.id}}</td>
							<td>{{apply.name}}</td>
							<td>{{apply.region.name}}</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getApplies" @pagination-change-page="getResults"></pagination>
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
			await this.actionApplies(page)
		},
		computed:{
			...mapGetters('apply',['getApplies','getMassage'])
		},
		methods:{
			...mapActions('apply',['actionApplies']),
			async getResults(page = 1){ 
				await this.actionApplies(page)
			},
		}
	}
</script>
<style scoped>
	
</style>