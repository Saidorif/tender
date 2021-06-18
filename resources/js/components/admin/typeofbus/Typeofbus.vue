<template>
	<div class="region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bus"></i>
				    Категория  автобуса
				</h4>
				<router-link class="btn btn-primary" to="/crm/typeofbus/add">
					<i class="fas fa-plus"></i> {{$t('Qoʼshish')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-center table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col">Название</th>
								<th scope="col">{{$t('Tahrirlash')}}</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(type,index) in getTypeofbuss.data">
								<td scope="row">{{type.id}}</td>
								<td>{{type.name}}</td>
								<td>
									<router-link tag="button" class="btn_transparent" :to='`/crm/typeofbus/edit/${type.id}`'>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
									<button class="btn_transparent" @click="deleteType(type.id)">
										<i class="pe_icon pe-7s-trash trashColor"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getTypeofbuss" @pagination-change-page="getResults"></pagination>
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
			await this.actionTypeofbuss()
			this.laoding = false
		},
		computed:{
			...mapGetters('typeofbus',['getTypeofbuss','getMassage'])
		},
		methods:{
			...mapActions('typeofbus',['actionTypeofbuss','actionDeleteTypeofbus']),
			async getResults(page = 1){
				await this.actionTypeofbuss(page)
			},
			async deleteType(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					this.laoding = true
					await this.actionDeleteTypeofbus(id)
					if (this.getMassage.error) {
						await this.actionTypeofbuss(page)
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
				          });
						this.$router.push("/crm/typeofbus");
						this.requiredInput = false
                    }
					this.laoding = false
				}
			}
		}
	}
</script>
<style scoped>

</style>
