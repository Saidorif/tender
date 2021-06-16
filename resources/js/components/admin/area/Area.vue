<template>
	<div class="area">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    {{$t('Tuman')}}
				</h4>
				<router-link class="btn btn-primary" to="/crm/area/add"><i class="fas fa-plus"></i> {{$t('Tuman qoʼshish')}}</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Nomi')}} </th>
							<th scope="col">{{$t('Viloyat')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(area,index) in getAreas.data">
							<td scope="row">{{area.id}}</td>
							<td>{{area.name}}</td>
							<td>{{area.region.name}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/area/edit/${area.id}`'
									v-if="$can('edit', 'AreaController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deleteArea(area.id)"
									v-if="$can('destroy', 'AreaController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getAreas" @pagination-change-page="getResults"></pagination>
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
                laoding: true,
			}
		},
		async mounted(){
			let page = 1;
            await this.actionAreas(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('area',['getAreas','getMassage'])
		},
		methods:{
			...mapActions('area',['actionAreas','actionDeleteArea']),
			async getResults(page = 1){
				await this.actionAreas(page)
			},
			async deleteArea(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteArea(id)
					await this.actionAreas(page)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Area удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>

</style>
