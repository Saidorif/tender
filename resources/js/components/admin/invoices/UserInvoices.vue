<template>
	<div class="payment">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-money-bill-alt"></i>
				    {{$t('Hisob-faktura')}}
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Tashkilot nomi')}}</th>
							<th scope="col">{{$t('INN')}}</th>
							<th scope="col">{{$t('Miqdor')}}</th>
							<th scope="col">{{$t('Sana')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(reg,index) in getUserInvoice.data">
							<td scope="row">{{reg.id}}</td>
							<td>{{reg.user.company_name}}</td>
                            <td>{{reg.user.inn}}</td>
							<td>{{reg.price}}</td>
							<td>{{reg.date}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/userinvoices/show/${reg.id}`'
								>
									<i class="pe_icon pe-7s-search editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getUserInvoice" @pagination-change-page="getResults"></pagination>
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
			await this.actionInvoiceUser(page)
			this.laoding = false
		},
		computed:{
			...mapGetters('invoices',['getUserInvoice'])
		},
		methods:{
			...mapActions('invoices',['actionInvoiceUser']),
			async getResults(page = 1){
				this.laoding = true
				await this.actionInvoice(page)
				this.laoding = false
			},
			getStatusClass(name){
				if (name == 'active') {
					return 'badge-success';
				}else{
					return 'badge-warning';
				}
			},
			getStatusName(name){
				if (name == 'active') {
					return this.$t('Faol');
				}else{
					return this.$t('Nofaol');
				}
			},
			async deleteRegion(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
					this.laoding = true
					await this.actionDeletePayment(id);
					await this.actionPayments(page);
					this.laoding = false
					if (this.getMassage.success){
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
					}
				}
			}
		}
	}
</script>
<style scoped>

</style>
