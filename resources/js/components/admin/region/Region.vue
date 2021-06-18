<template>
	<div class="region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    Region
				</h4>
				<router-link class="btn btn-primary" to="/crm/region/add" v-if="$can('store', 'RegionController')">
						<i class="fas fa-plus"></i>
					{{$t('Qoʼshish')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getRegions.data">
							<td scope="row">{{reg.id}}</td>
							<td>{{reg.name}}</td>
							<td>
								<router-link v-if="$can('edit', 'RegionController')" tag="button" class="btn_transparent" :to='`/crm/region/edit/${reg.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button v-if="$can('destroy', 'RegionController')" class="btn_transparent" @click="deleteRegion(reg.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getRegions" @pagination-change-page="getResults"></pagination>
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
			await this.actionRegions(page)
			this.laoding = false
		},
		computed:{
			...mapGetters('region',['getRegions','getMassage'])
		},
		methods:{
			...mapActions('region',['actionRegions','actionDeleteRegion']),
			async getResults(page = 1){
				this.laoding = true
				await this.actionRegions(page)
				this.laoding = false
			},
			async deleteRegion(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					this.laoding = true
					await this.actionDeleteRegion(id)
					await this.actionRegions(page)
					this.laoding = false
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
