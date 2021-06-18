<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    Объявить тендер
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
							<th scope="col">Лоты</th>
							<th scope="col">Адрес</th>
							<th scope="col">Регион</th>
							<th scope="col">{{$t('Tender sanasi')}}</th>
							<th scope="col">Осталось</th>
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
							    	<span>{{item.tenderlots.length > 1 ? 'лоты' :'лот'}}</span>
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
					return 'В ожидании'
				}else if(status == 'rejected'){
					return 'Отказано'
				}else if(status == 'completed'){
					return 'Завершен'
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
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteTenderAnnounce(id)
                    await this.actionTenderAnnounceLs(page)
                    this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Тендер удален!',
				    })
				}
			}
		}
	}
</script>
