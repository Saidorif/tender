<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-clipboard-check"></i>
				     {{$t('Tendirni tasdiqlash')}}
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Lotlar')}}</th>
							<th scope="col">{{$t('Manzil')}}</th>
							<th scope="col">{{$t('Tender sanasi')}}</th>
							<th scope="col">{{$t('Qoldi')}}</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getConfirmList.data">
							<td scope="row">{{item.id}}</td>
							<td>
								<em>
							    	{{item.tenderlots.length}}
							    	<span>{{item.tenderlots.length > 1 ? $t('Lotlar') :'лот'}}</span>
							    </em>
							</td>
							<td>{{item.address}}</td>
							<td>{{item.time}}</td>
							<td><time-counter :date="item.time"/></td>
							<td>
								<div class="badge" :class="getStatusClass(item.status)">
									{{getStatusName(item.status)}}
								</div>
							</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/confirm-tender/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getConfirmList" @pagination-change-page="getResults"></pagination>
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
            await this.actionConfirmList(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('tenderannounce',['getTenderAnnounces','getMassage']),
			...mapGetters('confirmtender',['getConfirmList']),
		},
		methods:{
			...mapActions('tenderannounce',['actionTenderAnnounces','actionDeleteTenderAnnounce']),
			...mapActions('confirmtender',['actionConfirmList']),
			async getResults(page = 1){
				await this.actionConfirmList(page)
			},
			getStatusName(status){
				if(status == 'pending'){
					return this.$t('Kutish jarayonida')
				}else if(status == 'rejected'){
					return this.$t('Rad etilgan')
				}else if(status == 'completed'){
					return this.$t('Yakunlangan')
				}
			},
			getStatusClass(status){
				if(status == 'pending'){
					return 'badge-secondary'
				}else if(status == 'rejected'){
					return 'badge-danger'
				}else if(status == 'completed'){
					return 'badge-success'
				}
			},
			async deleteRegion(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteTenderAnnounce(id)
                    await this.actionConfirmList(page)
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
