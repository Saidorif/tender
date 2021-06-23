<template>
	<div class="oldcontract">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon fas fa-file-alt"></i>
				    {{$t('Mening shartnomalar')}}
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Viloyat')}}</th>
							<th scope="col">{{$t('Yoʼnalish')}}</th>
							<th scope="col">{{$t('Shartnoma raqami')}}</th>
							<th scope="col">{{$t('Tashkilot nomi')}}</th>
							<th scope="col">{{$t('Protokol raqami')}}</th>
							<th scope="col">{{$t('Shartnoma tuzilgan sana')}}</th>
							<th scope="col">{{$t('Amal qilish muddati')}}</th>
							<th scope="col">{{$t('Shartnoma periodi')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getMycontracts.data">
							<td scope="row">{{item.id}}</td>
							<td>{{item.region ? item.region.name : ''}}</td>
							<td>
								<ul class="list-inline" v-if="item.direction_ids.length > 0">
								    <li v-for="(direct,key) in item.direction_ids">{{direct.name}}</li>
								</ul>
							</td>
							<td>{{item.number}}</td>
							<td>{{item.user ? item.user.company_name : ''}}</td>
							<td>{{item.protocol ? item.protocol.number : ''}}</td>
							<td>{{item.date}}</td>
							<td>{{item.exp_date}}</td>
							<td>{{getPeriod(item.contract_period)}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/mycontract/edit/${item.id}`'
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getMycontracts" @pagination-change-page="getResults"></pagination>
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
			await this.actionMycontracts(page)
			this.laoding = false
		},
		computed:{
			...mapGetters('mycontract',['getMycontracts','getMassage'])
		},
		methods:{
			...mapActions('mycontract',['actionMycontracts','actionDeleteMycontract']),
			async getResults(page = 1){
				this.laoding = true
				await this.actionMycontracts(page)
				this.laoding = false
			},
			getPeriod(item){
				return item+' ' + this.$t('yil');
			},
			async deleteMycontract(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
					this.laoding = true
					await this.actionDeleteMycontract(id)
					await this.actionMycontracts(page)
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
