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
							<th scope="col">{{$t('Avtomobil raqami')}} </th>
							<th scope="col">{{$t('Guvoxnoma raqami')}}  </th>
							<th scope="col">{{$t('Guvoxnoma amal qilish muddati')}}  </th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getCertificates.data">
							<td scope="row">{{reg.id}}</td>
							<td>{{reg.company_name}}</td>
							<td>{{reg.car ? reg.car.auto_number : ''}}</td>
							<td>{{reg.seria}}{{reg.number}}</td>
							<td>{{reg.exp_date}}</td>
							<td>
								<!-- v-if="$can('edit', 'CertificateController')" -->
								<router-link  tag="button" class="btn_transparent" :to='`/crm/certificate/edit/${reg.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getCertificates" @pagination-change-page="getResults"></pagination>
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
			await this.actionCertificates(page)
			this.laoding = false
		},
		computed:{
			...mapGetters('certificate',['getCertificates','getMassage'])
		},
		methods:{
			...mapActions('certificate',['actionCertificates','actionDeleteCertificate']),
			async getResults(page = 1){
				this.laoding = true
				await this.actionCertificates(page)
				this.laoding = false
			},
			async deleteCertificate(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
					this.laoding = true
					await this.actionDeleteCertificate(id)
					await this.actionCertificates(page)
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
