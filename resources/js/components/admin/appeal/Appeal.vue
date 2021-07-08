<template>
	<div class="myappeal">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon fas fa-file"></i>
				    Appeal
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Nomi')}}</th>
							<th scope="col">{{$t('Shartnoma raqami')}}</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getMyAppeals.data">
							<td scope="row">{{reg.id}}</td>
							<td>{{reg.company_name}}</td>
							<td>{{reg.contract ? reg.contract.number : ''}}</td>
							<td>{{reg.status}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/myappeal/edit/${reg.id}`'
									v-if="$can('appealUserEdit', 'ContractController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getMyAppeals" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				laoding: true
			}
		},
		async mounted(){
			let page = 1;
			await this.actionMyAppeals(page)
			this.laoding = false
		},
		computed:{
			...mapGetters('myappeal',['getMyAppeals','getMassage'])
		},
		methods:{
			...mapActions('myappeal',['actionMyAppeals','actionDeleteMyAppeal']),
			async getResults(page = 1){
				this.laoding = true
				await this.actionMyAppeals(page)
				this.laoding = false
			},
			async deleteMyAppeal(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					this.laoding = true
					await this.actionDeleteMyAppeal(id)
					await this.actionMyAppeals(page)
					this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'MyAppeal удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>

</style>
