<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				   {{$t('Tenderlarni tekshirish')}}
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Tashkilot nomi')}}</th>
							<th scope="col">{{$t('Tender sanasi')}}</th>
							<th scope="col">{{$t('Tender manzili')}}</th>
							<th scope="col">{{$t('Ariza holati')}}</th>
							<th scope="col">{{$t('Avtomobillar soni')}}</th>
							<th scope="col">{{$t('Tahrirlash')}} </th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getCheckContolsList">
							<td scope="row">{{index+1}}</td>
							<td>{{item.user.company_name ? item.user.company_name : 'Без название'}}</td>
							<td scope="row">{{item.tender ? item.tender.time : ''}}</td>
							<td scope="row">{{item.tender ? item.tender.address : ''}}</td>
					<!-- 		<td>
                                <div class="badge" :class="getStatusClass(item.status)">
									{{getStatusName(item.status)}}
								</div>
                            </td> -->
							<td>
                                <div class="badge" :class="getStatusClass(item.tender_status)">
									{{getStatusName(item.tender_status)}}
								</div>
                            </td>
							<td>{{item.cars_count}} {{$t('ta')}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/check-control/show/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<!-- <pagination :limit="4" :data="getTendersList" @pagination-change-page="getResults"></pagination> -->
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
            await this.actionCheckContolsList(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('checkcontrol', ['getCheckContolsList'])
		},
		methods:{
			...mapActions('checkcontrol', ['actionCheckContolsList']),
			async getResults(page = 1){
                this.laoding = true
				await this.actionCheckContolsList(page)
                this.laoding = false
            },
            getStatusClass(status){
				if(status == 'active'){
					return 'badge-secondary'
				}else if(status == 'rejected'){
					return 'badge-danger'
				}else if(status == 'accepted' || status == 'approved'){
					return 'badge-success'
				}
            },
            getStatusName(status){
				if(status == 'active'){
					return this.$t('Kutish jarayonida')
				}else if(status == 'rejected'){
					return this.$t('Rad etilgan')
				}else if(status == 'accepted' || status == 'approved'){
					return this.$t('Yakunlangan')
				}
			},
		}
	}
</script>
