<template>
	<div class="certificate">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon fas fa-file"></i>
				    {{$t('Guvoxnomalar')}}
				</h4>
				<!-- v-if="$can('store', 'CertificateController')" -->
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Nomi')}}</th>
							<th scope="col">Moshina raqami</th>
							<th scope="col">Guvoxnoma raqami </th>
							<th scope="col">Guvoxnomani amal qilish muddati </th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getUserCertificates.data">
							<td scope="row">{{reg.id}}</td>
							<td>{{reg.company_name}}</td>
							<td>{{reg.car ? reg.car.auto_number : ''}}</td>
							<td>{{reg.seria}}{{reg.number}}</td>
							<td>{{reg.exp_date}}</td>
							<td>
								<router-link  tag="button" class="btn_transparent" :to='`/crm/certificate/edit/${reg.id}`' v-if="$can('userCertificateShow', 'ApplicationController')">
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getUserCertificates" @pagination-change-page="getResults"></pagination>
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
			await this.actionUserCertificates(page)
			this.laoding = false
		},
		computed:{
			...mapGetters('certificate',['getUserCertificates','getMassage'])
		},
		methods:{
			...mapActions('certificate',['actionUserCertificates']),
			async getResults(page = 1){
				this.laoding = true
				await this.actionUserCertificates(page)
				this.laoding = false
			},
		}
	}
</script>
<style scoped>

</style>
