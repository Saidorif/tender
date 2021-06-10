<template>
	<div class="application">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    Мои Заявки
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
							<th scope="col">Направления</th>
							<th scope="col">Статус</th>
							<th scope="col">Дата</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getUserApps.data">
							<td scope="row">{{reg.id}}</td>
							<td scope="row">
								<ul v-if="reg.lots" class="list-inline">
									<template v-if="reg.lots.direction_id">
										<li v-for="(direct,index) in reg.lots.direction_id">{{direct.name}}</li>
									</template>
								</ul>
							</td>
							<td scope="row">
								<div class="badge " :class="getStatusClass(reg.status)">
									{{getStatusName(reg.status)}}
								</div>
							</td>
							<td scope="row">{{reg.lots ? reg.lots.time : ''}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/user/application/${reg.id}`'
									v-if="$can('index', 'ApplicationController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deleteRegion(reg.id)"
									v-if="$can('destroy', 'ApplicationController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getUserApps" @pagination-change-page="getResults"></pagination>
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
            await this.actionUserApps(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('application',[
				'getUserApps',
				'getApplication',
				'getMassage',
				'getAddMessage'
			])
		},
		methods:{
			...mapActions('application',[
				'actionUserApps',
				'actionDeleteApplication',
				'actionAddApplication',
			]),
			async getResults(page = 1){
				await this.actionUserApps(page)
			},
			async getEditId(){
				await this.actionAddApplication()
				if (this.getAddMessage.success) {
					this.$router.push("/crm/application/edit/"+this.getAddMessage.result.id);
				}
			},
			getStatusName(status){
				if(status == 'active'){
					return 'Незавершен!'
				}else if(status == 'completed'){
					return 'Завершен!'
				}
			},
			getStatusClass(status){
				if(status == 'active'){
					return 'badge-warning'
				}else if(status == 'completed'){
					return 'badge-primary'
				}
			},
			async deleteRegion(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteApplication(id)
					await this.actionUserApps(page)
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
