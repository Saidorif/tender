<template>
	<div class="role">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon fas fa-file"></i>
				   {{$t('Shartnomalar ro‘yxati')}}
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
							<th scope="col">{{$t('Shartnoma raqami')}} </th>
							<th scope="col">{{$t('Tashkilot nomi')}}</th>
							<th scope="col">{{$t('Protokol raqami')}}</th>
							<th scope="col">{{$t('Shartnoma tuzilgan sana')}}</th>
							<th scope="col">{{$t('Amal qilish muddati')}}</th>
							<th scope="col">{{$t('Shartnoma periodi')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getContractList.data">
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
									:to='`/crm/oldcontract/edit/${item.id}`'
									v-if="$can('edit', 'ContractController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deleteOldcontract(item.id)"
								 	v-if="$can('destroy', 'ContractController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getContractList" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex'
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
			await this.actionContractList({type: 'new', page: 1})
            console.log(this.getContractList)
			this.laoding = false
		},
		computed:{
			...mapGetters('contract',['getContractList'])
		},
		methods:{
			...mapActions('contract',['actionContractList']),
            async getResults(page = 1){
				this.laoding = true
				await this.actionContractList({type: 'new', page: page})
				this.laoding = false
			},
            getPeriod(item){
				return item+' ' + this.$t('yil')
			},
		}
	}
</script>
<style scoped>

</style>
