<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    {{$t('Tender eʼlon qilish')}}
				</h4>
				<router-link class="btn btn-primary" to="/crm/tenderannounce/add">
					<i class="fas fa-plus"></i>
					{{$t('Qoʼshish')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Lotlar')}}</th>
							<th scope="col">{{$t('Manzil')}}</th>
							<th scope="col">{{$t('Viloyat')}}</th>
							<th scope="col">{{$t('Tender sanasi')}}</th>
							<th scope="col">{{$t('Qoldi')}}</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getTenderAnnounceLs.data">
							<td scope="row">{{item.id}}</td>
							<td>
								<em>
							    	{{item.tenderlots.length}}
							    	<span>{{item.tenderlots.length > 1 ? $t('Lotlar') :'лот'}}</span>
							    </em>
							</td>
							<td>{{item.address}}</td>
							<td>{{item.moderator}}</td>
							<td>{{item.time}}</td>
							<td>
								<time-counter :date="item.time"/>
							</td>
							<td>
								<div class="badge" :class="getStatusClass(item.status)">
									{{getStatusName(item.status)}}
								</div>
							</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/tenderannounce/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteRegion(item.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<!-- <pagination :limit="4" :data="actionTenderAnnounceLs" @pagination-change-page="getResults"></pagination> -->
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
            Loader,
        },
		data(){
			return{
                laoding: true,
			}
		},
		async mounted(){
			let page = 1;
            await this.actionTenderAnnounceLs(page)
            this.laoding = false
        },
		computed:{
			// ...mapGetters('tenderannounce',['getTenderAnnounces','getMassage'])
			...mapGetters('tenderannounce',['getTenderAnnounceLs','getMassage'])
		},
		methods:{
			// ...mapActions('tenderannounce',['actionTenderAnnounces','actionDeleteTenderAnnounce']),
			...mapActions('tenderannounce',['actionTenderAnnounceLs','actionDeleteTenderAnnounce']),
			async getResults(page = 1){
				await this.actionTenderAnnounceLs(page)
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
                    await this.actionTenderAnnounceLs(page)
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
