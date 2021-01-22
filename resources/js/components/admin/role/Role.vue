<template>
	<div class="role">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-id"></i>
				    Role
				</h4>
				<router-link v-if="$can('store', 'RoleController')" class="btn btn-primary" to="/crm/role/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Label</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(role,index) in getRoles.data">
							<td scope="row">
								{{role.id}}
							</td>
							<td>
								<router-link tag="a" :to='`/crm/role/${role.id}`'>
									{{role.name}}
								</router-link>
							</td>
							<td>{{role.label}}</td>
							<td>
								<router-link v-if="$can('edit', 'RoleController')" tag="button" class="btn_transparent" :to='`/crm/role/edit/${role.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button v-if="$can('destroy', 'RoleController')" class="btn_transparent" @click="deleteRole(role.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getRoles" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex'
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
            await this.actionRoles()
            this.laoding = false
		},
		computed:{
			...mapGetters('role',['getRoles','getMassage'])
		},
		methods:{
			...mapActions('role',['actionRoles','actionDeleteRole']),
			async getResults(page = 1){
				await this.actionRoles(page)
			},
			async deleteRole(id){
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteRole(id)
                    await this.actionRoles(page)
                    this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Рол удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>

</style>
