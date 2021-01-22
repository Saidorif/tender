<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-clipboard-check"></i>
				    Подтвердить титул
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
						<tr v-for="(item,index) in getPassportList">
							<td scope="row">{{item.id}}</td>
							<td scope="row">{{item.name}}</td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tituls" >
                                        {{ch_item.summa}}
                                    </li>
                                </ul>
                            </td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tituls" >
                                        {{ch_item.summa_bagaj}}
                                    </li>
                                </ul>
                            </td>
                            <td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tituls" >
                                    	<div class="badge" :class="getStatusClass(ch_item.status)">
	                                        {{ch_item.status == 'pending' ? 'не подтвержден' : 'подтвержден'}}
                                    	</div>
                                    </li>
                                </ul>
                            </td>
							<td style="padding:0;">
                                <ul class="table_item_list">
                                    <li v-for="(ch_item,ch_index) in item.tituls" >
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
					<!-- <pagination :limit="4" :data="getTitulAnnounces" @pagination-change-page="getResults"></pagination> -->
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
            await this.actionPortTitulList();
            this.laoding = false
		},
		computed:{
			...mapGetters('titulannounce',['getPassportList', 'getMassage'])
		},
		methods:{
            ...mapActions('titulannounce',['actionPortTitulList', 'actionApprovePassportTitulList']),
            async completedTender(id){
                this.laoding = true
                await this.actionApprovePassportTitulList({titul_id: id})
                if(this.getMassage.success){
                    await this.actionPortTitulList();
                    toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Тендер тариф подтверждена!',
				    })
                }
                this.laoding = false
            },
			// async getResults(page = 1){
			// 	await this.actionTitulAnnounces(page)
			// },
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
			// async deleteTitul(id){
			// 	if(confirm("Вы действительно хотите удалить?")){
			// 		let page = 1
			// 		await this.actionDeleteTitulAnnounce(id)
			// 		await this.actionTitulAnnounces(page)
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
