<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bus"></i>
				    Модель автобуса
				</h4>
				<router-link class="btn btn-primary" to="/crm/busmodel/add">
					<i class="fas fa-plus"></i> Добавить
				</router-link>
		  	</div>
		  	<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-center table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col">Марка</th>
								<th scope="col">Название</th>
								<th scope="col">Действия</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(model,index) in getBusmodels.data">
								<td scope="row">{{model.id}}</td>
								<td>{{model.marka ? model.marka.name : ''}}</td>
								<td>{{model.name}}</td>
								<td>
									<router-link
										tag="button"
										class="btn_transparent"
										:to='`/crm/busmodel/edit/${model.id}`'
										v-if="$can('edit', 'BusModelController')"
									>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
									<button
										class="btn_transparent"
										@click="deleteType(model.id)"
										v-if="$can('destroy', 'BusModelController')"
									>
										<i class="pe_icon pe-7s-trash trashColor"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getBusmodels" @pagination-change-page="getResults"></pagination>
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
            await this.actionBusmodels()
            this.laoding = false
            console.log(this.getBusmodels)
		},
		computed:{
			...mapGetters('busmodel',['getBusmodels','getMassage'])
		},
		methods:{
			...mapActions('busmodel',['actionBusmodels','actionDeleteBusmodel']),
			async getResults(page = 1){
				await this.actionBusmodels(page)
			},
			async deleteType(id){
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteBusmodel(id)
					if (this.getMassage.success) {
						await this.actionBusmodels(page)
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
