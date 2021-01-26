<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-clipboard-check"></i>
				    Подтвердить тариф
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Направления</th>
							<th scope="col">Тариф</th>
							<th scope="col">Сумма багажа</th>
							<th scope="col">Статус</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getPassportList.data">
							<td scope="row">{{item.id}}</td>
							<td scope="row">{{item.name}}</td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tarifs" >
                                        {{ch_item.summa}}
                                    </li>
                                </ul>
                            </td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tarifs" >
                                        {{ch_item.summa_bagaj}}
                                    </li>
                                </ul>
                            </td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tarifs" >
                                    	<div class="badge" :class="getStatusClass(ch_item.status)">
	                                        {{ch_item.status == 'pending' ? 'не подтвержден' : 'подтвержден'}}
                                    	</div>
                                    </li>
                                </ul>
                            </td>
							<td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tarifs" >
                                        <button type="button" class="btn" :class="ch_item.status == 'approved' ? 'btn-success' : 'fas btn-warning'" style="padding: 2px 9px;"
                                        	@click="completedTender(ch_item.id)"
                                    	>
                                            <i :class="ch_item.status == 'approved' ? 'far fa-check-circle' : 'fas fa-times'"></i>
                                        </button>
                                    </li>
                                </ul>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getPassportList" @pagination-change-page="getResults"></pagination>
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
            await this.actionPortTarifList(page);
            console.log(this.getPassportList)
            this.laoding = false
		},
		computed:{
			...mapGetters('tarifannounce',['getPassportList', 'getMassage'])
		},
		methods:{
            ...mapActions('tarifannounce',['actionPortTarifList', 'actionApprovePassportTarifList']),
            async completedTender(id){
            	let page = 1;
                this.laoding = true
                await this.actionApprovePassportTarifList({tarif_id: id})
                if(this.getMassage.success){
                    await this.actionPortTarifList(page);
                    toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Тендер тариф подтверждена!',
				    })
                }
                this.laoding = false
            },
			async getResults(page = 1){
				await this.actionPortTarifList(page)
			},
			// getStatusName(status){
			// 	if(status == 'pending'){
			// 		return 'В ожидании'
			// 	}else if(status == 'rejected'){
			// 		return 'Отказано'
			// 	}else if(status == 'completed'){
			// 		return 'Завершен'
			// 	}
			// },
			getStatusClass(status){
				if(status == 'pending'){
					return 'badge-warning'
				}else if(status == 'approved'){
					return 'badge-success'
				}
			},
			// async deleteTarif(id){
			// 	if(confirm("Вы действительно хотите удалить?")){
			// 		let page = 1
			// 		await this.actionDeleteTarifAnnounce(id)
			// 		await this.actionTarifAnnounces(page)
			// 		toast.fire({
			// 	    	type: 'success',
			// 	    	icon: 'success',
			// 			title: 'Тендер удален!',
			// 	    })
			// 	}
			// }
		}
	}
</script>
<style  scoped>
    .table_item_list{
        margin-bottom: 0;
    }
    .table_item_list li{
        list-style: none;
        border-bottom: 1px solid #000;
    }
        .table_item_list li:last-child{
            border: 0px;
        }
</style>
