<template>
	<div class="conditionalsign">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-sign"></i>
				    Условные символы
				</h4>
				<router-link class="btn btn-primary" to="/crm/conditionalsign/add"><i class="fas fa-plus"></i> Добавить</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(sign,index) in getConditionalSigns.data">
							<td scope="row">{{sign.id}}</td>
							<td>{{sign.name}}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/conditionalsign/edit/${sign.id}`'
									v-if="$can('edit', 'ConditionalSignController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deleteSign(sign.id)"
									v-if="$can('destroy', 'ConditionalSignController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getConditionalSigns" @pagination-change-page="getResults"></pagination>
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
            await this.actionConditionalSigns(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('conditionalsign',['getConditionalSigns','getMassage'])
		},
		methods:{
			...mapActions('conditionalsign',['actionConditionalSigns','actionDeleteConditionalSign']),
			async getResults(page = 1){
				await this.actionConditionalSigns(page)
			},
			async deleteSign(id){
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteConditionalSign(id)
                    await this.actionConditionalSigns(page)
                    this.laoding = false
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
					}
				}
			}
		}
	}
</script>
<style scoped>

</style>
