<template>
	<div class="employee">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title">
				    <h4 class="title_user">
				    	<i  class="peIcon fas fa-users"></i>
					     Сотрудники
					</h4>
					<div class="add_user_btn">
			            <button type="button" class="btn btn-info toggleFilter mr-2" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	Филтр
						</button>
						<router-link class="btn btn-primary" to="/crm/employee/add"><i class="fas fa-plus"></i> Добавить</router-link>
		            </div>
		  		</div>
		    	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-3">
				                <label for="surname">Фамилия</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="surname"
				                  placeholder="Фамилия"
				                  v-model="filter.surname"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
				                <label for="name">Имя</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="name"
				                  placeholder="Имя"
				                  v-model="filter.name"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
				                <label for="middlename">Отчество</label>
				                <input
				                  type="text"
				                  class="form-control input_style"
				                  id="middlename"
				                  placeholder="Отчество"
				                  v-model="filter.middlename"
				                />
			              	</div>
			              	<div class="form-group col-lg-3">
	  							<label for="position_id">Должность</label>
  								<select name="" v-model="filter.position_id" class="form-control" >
  									<option value="">Выберите должность!</option>
  									<option :value="position.id" v-for="(position,index) in getPositionList" :key="position.id">
  										{{position.name}}
  									</option>
  								</select>
				  			</div>
				  			<div class="form-group col-lg-3">
				  				<label for="region_id">Область</label>
			                    <select
			                      id="region_id"
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                      @change="selectRegion()"
			                    >
			                      <option value="" selected disabled>Выберите область!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="area_id">Регион/Город!</label>
			                    <select
			                      id="area_id"
			                      class="form-control input_style"
			                      v-model="filter.area_id"
			                    >
			                      <option value="" selected disabled>Выберите регин или город!</option>
			                      <option :value="item.id" v-for="(item,index) in getAreaList">{{item.name}}</option>
			                    </select>
              				</div>
  					  		<div class="form-group col-lg-3">
	  							<label for="role_id">Рол</label>
  								<select name="" v-model="filter.role_id" class="form-control" >
  									<option value="">Выберите рол!</option>
  									<option :value="role.id" v-for="(role,index) in getRoleList" :key="role.id">
  										{{role.name}}
  									</option>
  								</select>
				  			</div>
						  	<div class="col-lg-3 form-group btn_search">
							  	<button type="button" class="btn btn-primary mr-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	найти
							  	</button>
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	сброс
							  	</button>
					  	  	</div>
				  		</div>
				  	</div>
			  	</transition>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Ф.И.О</th>
							<th scope="col">Должность</th>
							<th scope="col">Рол</th>
							<th scope="col">E-mail</th>
							<th scope="col">Телефон</th>
							<th scope="col">Статус</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getEmployees.data">
							<td scope="row">{{item.id}}</td>
							<td>{{item.surname}} {{item.name}} {{item.middlename}}</td>
							<td>{{item.position ? item.position.name : ''}}</td>
							<td>{{item.role ? item.role.name : ''}}</td>
							<td>{{item.email}}</td>
							<td>{{item.phone}}</td>
							<td>
								<div class="badge" :class="item.status == 'active' ? ' badge-success' : ' badge-warning'">
									{{item.status}}
								</div>
							</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/employee/edit/${item.id}`'
									v-if="$can('edit', 'EmployeeController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deleteEmployee(item.id)"
									v-if="$can('destroy', 'EmployeeController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getEmployees" @pagination-change-page="getResults"></pagination>
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
				filter:{
					region_id:'',
					area_id:'',
					middlename:'',
					surname:'',
					name:'',
					position_id:'',
					role_id:'',
				},
                filterShow:false,
                laoding: true,
			}
		},
		async mounted(){
			let page = 1;
			await this.actionEmployees({page:page,items:this.filter})
			await this.actionRoleList();
			await this.actionPositionList()
            await this.actionRegionList();
            this.laoding = false
		},
		computed:{
			...mapGetters('employee',['getEmployees']),
			...mapGetters('position',['getPositionList']),
			...mapGetters("region", ["getRegionList"]),
			...mapGetters("area", ["getAreaList"]),
			...mapGetters('role',['getRoleList','getMassage'])
		},
		methods:{
			...mapActions('employee',['actionEmployees','actionDeleteEmployee']),
			...mapActions('position',['actionPositionList']),
			...mapActions("region", ["actionRegionList"]),
    		...mapActions("area", ["actionAreaByRegion"]),
    		...mapActions('role',['actionRoleList','actionDeleteRole']),
			async selectRegion(){
		      await this.actionAreaByRegion({ region_id: this.filter.region_id });
		    },
			async getResults(page = 1){
				await this.actionEmployees({page:page,items:this.filter})
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.name || this.filter.region_id || this.filter.area_id || this.filter.position_id || this.filter.role_id){
                    this.laoding = true
                    await this.actionEmployees({page: page,items:this.filter})
                    this.laoding = false
				}
			},
			async clear(){
				if(this.filter.name || this.filter.region_id || this.filter.area_id || this.filter.position_id || this.filter.role_id){
					this.filter.name = ''
					this.filter.region_id = ''
					this.filter.area_id = ''
					this.filter.position_id = ''
					this.filter.role_id = ''
                    let page  = 1
                    this.laoding = true
                    await this.actionEmployees({page: page,items:this.filter})
                    this.laoding = false
				}

			},
			async deleteEmployee(id){
				if(confirm("Вы действительно хотите удалить?")){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteEmployee(id)
                    await this.actionEmployees({page: page,items:this.filter})
                    this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Пользователь удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>
	.add_user_btn{
        display: flex;
        align-items: stretch;
    }
</style>
