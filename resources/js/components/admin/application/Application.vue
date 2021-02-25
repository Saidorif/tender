<template>
	<div class="application">
        <Loader v-if="laoding"/>
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
				<router-link class="btn btn-primary" to="/crm/tender/application">
					<span class="peIcon pe-7s-back"></span>
						Назад
				</router-link>
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
						<tr v-for="(reg,index) in getShowApplications.data">
							<td scope="row">{{reg.id}}</td>
							<td>
								<ul class="list-inline" v-if="reg.lots && reg.lots.direction_id.length > 0">
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
							<td>{{reg.lots ? reg.lots.time : ''}}</td>
							<td>
								<template v-if="reg.lots && reg.lots.time">
	                                <time-counter :date="reg.lots.time"/>
								</template>
								<template v-else></template>
                            </td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/application/user/${reg.id}?tId=${$route.params.tenderAppId}`'
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
					<pagination :limit="4" :data="getShowApplications" @pagination-change-page="getResults"></pagination>
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
			let data = {
				page:1,
				id:this.$route.params.tenderAppId
			}
            await this.actionShowApplications(data)
            this.laoding = false
		},
		computed:{
			...mapGetters('application',[
				'getShowApplications',
				'getApplication',
				'getMassage',
				'getAddMessage'
			])
		},
		methods:{
			...mapActions('application',[
				'actionShowApplications',
				'actionDeleteApplication',
				'actionAddApplication',
			]),
			async getResults(page = 1){
				let data = {
					page:page,
					id:this.$route.params.tenderAppId
				}
	            await this.actionShowApplications(data)
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
				}else if(status == 'accepted'){
					return 'Завершен!'
				}
			},
			getStatusClass(status){
				if(status == 'active'){
					return 'badge-warning'
				}else if(status == 'accepted'){
					return 'badge-primary'
				}
			},
			async deleteRegion(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteApplication(id)
					let data = {
						page:page,
						id:this.$route.params.tenderAppId
					}
		            await this.actionShowApplications(data)
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
