<template>
	<div class="application">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    {{$t('Mening arizalarim')}}
				</h4>
	<!-- 			<button type="button" class="btn btn-primary" @click.prevent="getEditId">
					<i class="fas fa-plus"></i>
					{{$t('Qoʼshish')}}
				</button> -->
		<!-- 		<router-link class="btn btn-primary" to="/crm/application/add">
					<i class="fas fa-plus"></i>
					{{$t('Qoʼshish')}}
				</router-link> -->
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Yoʼnalishlar')}}</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Sana')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
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
									v-if="$can('userShow', 'ApplicationController')"
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
                this.laoding = true
				await this.actionUserApps(page)
                this.laoding = false
			},
			async getEditId(){
                 this.laoding = true
				await this.actionAddApplication()
                 this.laoding = false
				if (this.getAddMessage.success) {
					this.$router.push("/crm/application/edit/"+this.getAddMessage.result.id);
				}
			},
			getStatusName(status){
				if(status == 'active'){
					return this.$t('Yakunlanmagan')
				}else if(status == 'accepted'){
					return this.$t('Yakunlangan')
				}else if(status == 'rejected'){
					return this.$t('Rad etilgan')
				}else if(status == 'winner'){
					return this.$t('G‘olib')
				}
			},
			getStatusClass(status){
				if(status == 'active'){
					return 'badge-warning'
				}else if(status == 'accepted'){
					return 'badge-primary'
				}else if(status == 'rejected'){
					return 'badge-danger'
				}else if(status == 'winner'){
					return 'badge-success'
				}
			},
			async deleteRegion(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
                    this.laoding = true
					await this.actionDeleteApplication(id)
					await this.actionUserApps(page)
                    this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: this.$t('Oʼchirildi'),
				    })
				}
			}
		}
	}
</script>
<style scoped>

</style>
