<template>
	<div class="application">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				     {{$t('Arizalar')}}
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
							<th scope="col">{{$t('Manzil')}}</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Sana')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getApplications.data">
							<td scope="row">{{reg.id}}</td>
							<td scope="row">{{reg.address}}</td>
							<td scope="row">
								<div class="badge " :class="getStatusClass(reg.status)">
									{{getStatusName(reg.status)}}
								</div>
							</td>
							<td scope="row">{{reg.time}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/application/${reg.id}`'
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
					<pagination :limit="4" :data="getApplications" @pagination-change-page="getResults"></pagination>
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
            await this.actionApplications(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('application',[
				'getApplications',
				'getApplication',
				'getMassage',
				'getAddMessage'
			])
		},
		methods:{
			...mapActions('application',[
				'actionApplications',
				'actionDeleteApplication',
				'actionAddApplication',
			]),
			async getResults(page = 1){
				this.laoding = true
				await this.actionApplications(page)
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
				}else if(status == 'completed'){
					return this.$t('Yakunlangan')
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
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
                    this.laoding = true
					await this.actionDeleteApplication(id)
					await this.actionApplications(page)
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
