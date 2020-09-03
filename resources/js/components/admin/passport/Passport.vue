<template>
	<div class="area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    Passport 
				</h4>
				<router-link class="btn btn-primary" to="/crm/passport/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название Пасспорта</th>
							<th scope="col">Регион (From)</th>
							<th scope="col">Area (From)</th>
							<th scope="col">Регион (To)</th>
							<th scope="col">Area (To)</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(passport,index) in getPassports.data">
							<td scope="row">{{index+1}}</td>
							<td>{{passport.name}}</td>
							<td>{{passport.region_from.name}}</td>
							<td>{{passport.area_from ? passport.area.name : ''}}</td>
							<td>{{passport.region_to.name}}</td>
							<td>{{passport.area_to ? passport.area.name : ''}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/passport/edit/${passport.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deletePassport(passport.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getPassports" @pagination-change-page="getResults"></pagination>
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
			await this.actionPassports()
		},
		computed:{
			...mapGetters('passport',['getPassports','getMassage'])
		},
		methods:{
			...mapActions('passport',['actionPassports','actionDeletePassport']),
			async getResults(page = 1){ 
				await this.actionPassports(page)
			},
			async deletePassport(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeletePassport(id)
					await this.actionPassports(page)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Passport удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>
	
</style>