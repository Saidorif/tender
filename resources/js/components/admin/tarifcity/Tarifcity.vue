<template>
	<div class="area">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    Tarifcity
				</h4>
				<router-link class="btn btn-primary" to="/crm/tarifcity/add"><i class="fas fa-plus"></i> {{$t('Qoʼshish')}}</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Регион</th>
							<th scope="col">Сумма тарифа</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(tarif,index) in getTarifcitys.data">
							<td scope="row">{{tarif.id}}</td>
							<td>{{tarif.region.name}}</td>
							<td>{{tarif.tarif}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/tarifcity/edit/${tarif.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteTarifcity(tarif.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getTarifcitys" @pagination-change-page="getResults"></pagination>
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
            await this.actionTarifcitys(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('tarifcity',['getTarifcitys','getMassage'])
		},
		methods:{
			...mapActions('tarifcity',['actionTarifcitys','actionDeleteTarifcity']),
			async getResults(page = 1){
				await this.actionTarifcitys(page)
            },

			async deleteTarifcity(id){
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteTarifcity(id)
                    await this.actionTarifcitys(page)
                    this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Tarifcity удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>

</style>
