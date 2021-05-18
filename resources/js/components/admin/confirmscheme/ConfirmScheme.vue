<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i class="peIcon fas fa-clipboard-check"></i>
					    Подтвердить схема
					</h4>
	            	<div class="add_user_btn">
		                <span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
		            		Количество направления <b>{{ getSchemes.total }} шт.</b>
		            	</span>
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	Филтр
						</button>
						<router-link class="btn btn-primary" to="/crm/direction/add">
							<i class="fas fa-plus"></i>
							Добавить
						</router-link>
		            </div>
	            </div>
	            <transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-2">
				  				<label for="bypass_number">Номер направления</label>
                                  <input class="form-control input_style" placeholder="Поиск по номеру" type="text" v-model="filter.pass_number" id="bypass_number">
              				</div>
				  			<div class="form-group col-lg-2">
				  				<label for="status">По статусу закрепления!</label>
			                    <select
			                      id="status"
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected >Выберите статус закрепления!</option>
			                      <option value="pending">Не подтвержден</option>
			                      <option value="completed">Подтвержден!</option>
			                    </select>
              				</div>
                            <div class="form-group col-lg-3">
				  				<label for="dir_name">Наименования  маршрута</label>
                              	<input class="form-control input_style" placeholder="Поиск по наименования маршрута" type="text" v-model="filter.name" id="dir_name">
              				</div>
						  	<div class="col-lg-5 form-group d-flex justify-content-end align-items-center mb-4">
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	сброс
							  	</button>
							  	<button type="button" class="btn btn-primary ml-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	найти
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
							<th scope="col">Направления</th>
							<th scope="col">Тариф</th>
							<th scope="col">Сумма багажа</th>
							<th scope="col">Дата</th>
							<th scope="col">Статус</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(direct,index) in getSchemes.data">
							<td scope="row">{{index + 1}}</td>
							<td>
								<template v-if="direct.created_by">
									{{direct.created_by.region ? direct.created_by.region.name : ''}}
								</template>
							</td>
							<td>{{direct.name}}</td>
							<td>{{direct.pass_number}}</td>
							<td>{{direct.year}}</td>
                            <td>
                                <div class="badge" :class="getStatusClass(direct.sxema_status)">
	                                {{direct.sxema_status == 'completed' ? 'подтвержден' : 'не подтвержден'}}
                                </div>
                            </td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/confirm-scheme/edit/${direct.id}`'
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getSchemes" @pagination-change-page="getResults"></pagination>
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
				filter:{
                    status:'',
                    pass_number: '',
                    name: '',
				},
                laoding: true,
                filterShow: false,
			}
		},
		async mounted(){
            let data = {
            	page:1,
            	items:this.filter
            }
            await this.actionSchemes(data);
            this.laoding = false
		},
		computed:{
			...mapGetters('confirmscheme',['getSchemes', 'getSchemeMassage'])
		},
		methods:{
            ...mapActions('confirmscheme',['actionSchemes','actionActivateScheme']),
			async getResults(page = 1){
				let data = {
	            	page:page,
	            	items:this.filter
	            }
				await this.actionSchemes(data)
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				let data = {
	            	page:page,
	            	items:this.filter
	            }
				await this.actionSchemes(data)
			},
			async clear(){
				this.filter.pass_number = ''
				this.filter.status = ''
				this.filter.name = ''
                let page  = 1
                this.laoding = true
                let data = {
	            	page:page,
	            	items:this.filter
	            }
				await this.actionSchemes(data)
                this.laoding = false
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
					return 'badge-warning'
				}else if(status == 'completed'){
					return 'badge-success'
				}
			},
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
    .toggleFilter{
		margin-right:15px;
	}
</style>
