<template>
	<div class="area">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i class="peIcon fas fa-route"></i>
					    {{$t('Yoʼnalish')}}
					</h4>
	            	<div class="add_user_btn">
		                <span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
		            		{{$t('Yoʼnalish soni')}} <b>{{ getDirections.total }} {{$t('ta')}}.</b>
		            	</span>
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	{{$t('Saralash')}}
						</button>
						<router-link class="btn btn-primary" to="/crm/direction/add">
							<i class="fas fa-plus"></i>
							{{$t('Qoʼshish')}}
						</router-link>
		            </div>
	            </div>
	            <transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-lg-2">
				  				<label for="bypass_number">{{$t('Yoʼnalish soni')}}</label>
                                  <input class="form-control input_style"  type="text" v-model="filter.pass_number" id="bypass_number">
              				</div>
				  			<div class="form-group col-lg-2">
				  				<label for="region_id">{{$t('Viloyat boʼyicha saralash')}}!</label>
			                    <select
			                      id="region_id"
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                    >
			                      <option value="" selected >{{$t('Viloyatni tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-2">
				  				<label for="status">{{$t('Holati boʼyicha')}}!</label>
			                    <select
			                      id="status"
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected >{{$t('Tanlang')}}!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="status">{{$t('Holati boʼyicha')}}<!--  размещения-->!</label>
			                    <select
			                      id="status"
			                      class="form-control input_style"
			                      v-model="filter.status"
			                    >
			                      <option value="" selected >{{$t('Tanlang')}}!</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="bustype_id">{{$t('Avtomobil turi boʼyicha saralash')}}!</label>
			                    <select
			                      id="bustype_id"
			                      class="form-control input_style"
			                      v-model="filter.bustype_id"
			                    >
			                      <option value="" selected >{{$t('Tanlang')}}!</option>
			                      <option
				                      :value="busType.id"
				                      v-for="(busType,index) in getTypeofbusList"
			                    	>{{busType.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-2">
				  				<label for="profitability">{{$t('Rentabillik boʼyicha saralash')}}!</label>
			                    <select
			                      id="profitability"
			                      class="form-control input_style"
			                      v-model="filter.profitability"
			                    >
			                      <option value="" selected >{{$t('Tanlang')}}!</option>
			                      <option value="profitable">{{$t('Samarali')}}</option>
					              <option value="unprofitable">{{$t('Samarasiz')}}</option>
					              <option value="middle">{{$t('Oʼrta')}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-3">
				  				<label for="type_id">{{$t('Marshrut joylashuvi boʼyicha saralash')}}!</label>
			                    <select
			                      id="type_id"
			                      class="form-control input_style"
			                      v-model="filter.type_id"
			                    >
			                      <option value="" selected >{{$t('Tanlang')}}!</option>
			                      <option
					                  :value="item.id"
					                  v-for="(item,index) in getTypeofdirectionList"
				                  >{{item.name }} {{item.type}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-2">
				  				<label for="dir_type">{{$t('Avtomobil turi boʼyicha saralash')}}!</label>
			                    <select
			                      id="dir_type"
			                      class="form-control input_style"
			                      v-model="filter.dir_type"
			                    >
			                      <option value="" selected >{{$t('Tanlang')}}!</option>
			                      <option value="bus">{{$t('Avtobus yoʼnalishi')}}</option>
                      			  <option value="taxi">{{$t('Yoʼnalishli taxi yoʼnalishi')}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-lg-2">
				  				<label for="year">{{$t('Sanasi boyicha saralash')}}!</label>
				  				<date-picker
					                lang="ru"
					                type="year" format="YYYY" valueType="format"
					                v-model="filter.year"
					                class="input_style"
				              	></date-picker>
              				</div>
                            <div class="form-group col-lg-3">
				  				<label for="dir_name">{{$t('Marshrut nomi')}}</label>
                                  <input class="form-control input_style" type="text" v-model="filter.name" id="dir_name">
              				</div>
						  	<div class="col-lg-12 form-group d-flex justify-content-end">
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	{{$t('Tozalash')}}
							  	</button>
							  	<button type="button" class="btn btn-primary ml-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	{{$t('Qidirish')}}
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
						<!-- <tr>
							<th scope="col" width="2%">№</th>
							<th scope="col">{{$t('Viloyat')}}</th>
							<th scope="col">Название направления</th>
							<th scope="col"></th>
							<th scope="col"></th>
							<th scope="col"></th>
							<th scope="col"></th>
							<th scope="col">{{$t('Yoʼnalish soni')}}</th>
							<th scope="col">Год создания</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr> -->
                        <tr>
                            <th scope="col">№</th>
                            <th>{{$t('Viloyat')}}</th>
                            <th>{{$t('Yoʼnalish raqami va nomi')}}</th>
                            <th>{{$t('Tashkilot nomi')}} </th>
                            <th>{{$t('Shartnoma muddati')}} </th>
                            <th>{{$t('Holati')}}</th>
                            <th>{{$t('Yoʼnalish turi')}}</th>
                            <th>{{$t('Ochilish sanasi')}}</th>
                            <th>{{$t('Tasdiqlash')}}</th>
                            <th scope="col">{{$t('Tahrirlash')}}</th>
                        </tr>
					</thead>
					<tbody>
						<tr v-for="(direct,index) in getDirections.data">
							<td scope="row">{{index + 1}}</td>
							<td>
								<template v-if="direct.created_by">
									{{direct.created_by.region ? direct.created_by.region.name : ''}}
								</template>
							</td>
							<td><b>{{direct.pass_number}}</b> - {{direct.name}}</td>
							<td>
                <a href="#" @click.prevent="openModal(direct)">
                  <b></b>
                </a>
              </td>
							<td></td>
							<td>
                <span class="alert pt-1 pb-1" :class="getStatusClass(direct)">
                	{{getStatusname(direct)}}
                </span>
              </td>
							<td>{{direct.dir_type == 'taxi' ? $t('Yoʼnalishli taxi yoʼnalishi')  : $t('Avtobus yoʼnalishi')}}</td>
							<td>{{direct.year}}</td>
							<td>{{ checkApprove(direct) }}</td>
							<td>
								<router-link
									tag="button"
									class="btn_transparent"
									:to='`/crm/direction/edit/${direct.id}`'
									v-if="$can('edit', 'DirectionController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deletePassport(direct.id)"
									v-if="$can('destroy', 'DirectionController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getDirections" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
                          <!-- Modal For USER-->
  <!--     <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{$t('Tashkilot maʼlumotlari')}}</h5>
              <button type="button" class="close" @click.prevent="closeUserModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="table-responsive table">
                <table class="table-bordered table table-hover" v-if="userItem">
                  <thead></thead>
                  <tbody>
                    <tr>
                      <th>{{$t('Tashkilot nomi')}}</th>
                      <td>{{userItem.company_name}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('F.I.Sh')}}</th>
                      <td>{{userItem.surname}}  {{userItem.name}} {{userItem.middlename}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Viloyat')}}</th>
                      <td>{{userItem.region ? userItem.region.name : ''}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Tuman/Shahar')}}</th>
                      <td>{{userItem.area ? userItem.area.name : ''}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Vakolatli shaxs')}}</th>
                      <td>{{userItem.trusted_person}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('INN')}}</th>
                      <td>{{userItem.inn}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Telefon')}}</th>
                      <td>{{userItem.phone}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Manzil')}}</th>
                      <td>{{userItem.address}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('X/raqam')}}</th>
                      <td>{{userItem.bank_number}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('MFO')}}</th>
                      <td>{{userItem.mfo}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('OKED')}}</th>
                      <td>{{userItem.oked}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Bankning manzili')}}</th>
                      <td>{{userItem.city}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Litsenziya raqami')}}</th>
                      <td>{{userItem.license_number}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Litsenziya turi')}}</th>
                      <td>{{userItem.license_type}}</td>
                    </tr>
                    <tr>
                      <th>{{$t('Litsenziya sanasi')}}</th>
                      <td>{{userItem.license_date}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click.prevent="closeUserModal">{{$t('Yopish')}}</button>
            </div>
          </div>
        </div>
      </div> -->
	  	</div>
	</div>
</template>
<script>
	import DatePicker from "vue2-datepicker";
	import { mapGetters, mapActions } from "vuex";
	import 'vue2-datepicker/index.css';
	import Loader from '../../Loader'
	export default{
		components:{
			Loader,
			DatePicker,
		},
		data(){
			return{
				filter:{
					region_id:'',
					dir_type:'',
					bustype_id:'',
					type_id:'',
					profitability:'',
                    year:'',
                    pass_number: '',
                    name: '',
				},
				filterShow:false,
				laoding: true
			}
		},
		async mounted(){
            let page = 1;
            this.filter = localStorage.getItem("dir_f") ? JSON.parse(localStorage.getItem("dir_f")) : this.filter
			await this.actionDirections({page:page,items:this.filter})
			await this.actionRegionList()
			await this.actionTypeofbusList()
			await this.actionTypeofdirectionList()
            this.laoding = false
		},
		computed:{
			...mapGetters('direction', ['getDirections','getMassage','getApiDirections']),
			...mapGetters("typeofdirection", ["getTypeofdirectionList"]),
			...mapGetters("region", ["getRegionList"]),
			...mapGetters('typeofbus', ['getTypeofbusList']),
		},
		methods:{
			...mapActions('direction',['actionDirections','actionDeleteDirection','actionApiDirection']),
			...mapActions("region", ["actionRegionList"]),
			...mapActions("typeofdirection", ["actionTypeofdirectionList"]),
			...mapActions('typeofbus',['actionTypeofbusList']),
			async getResults(page = 1){
				await this.actionDirections({page:page,items:this.filter})
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			getStatusname(item){
				if(item.status == 'active'){
					return 'Неразмещен в тендер'
				}else if(item.status == 'busy'){
					return 'Размещен в тендер'
				}
			},
			getStatusClass(item){
				if(item.status == 'active'){
					return 'alert-danger'
				}else if(item.status == 'busy'){
					return 'alert-success'
				}
			},
      openModal(item){
          $('#userModal').modal('show')
          this.userItem = item
      },
			async search(){
				let page = 1
				if(this.filter.name != '' || this.filter.pass_number != '' || this.filter.region_id != '' || this.filter.dir_type != '' || this.filter.type_id != '' || this.filter.year != '' || this.filter.profitability != '' || this.filter.bustype_id != ''){
					let data = {
						page:page,
						items:this.filter
                    }
                    localStorage.setItem("dir_f",  JSON.stringify(this.filter))
					this.laoding = true
					await this.actionDirections(data)
					this.laoding = false
				}
			},
			async clear(){
				// if(this.filter.pass_number != '' ||   this.filter.region_id != '' || this.filter.dir_type != '' || this.filter.type_id != '' || this.filter.year != '' || this.filter.profitability != '' || this.filter.bustype_id != ''){
					this.filter.region_id = ''
					this.filter.dir_type = ''
					this.filter.type_id = ''
					this.filter.year = ''
					this.filter.profitability = ''
					this.filter.bustype_id = ''
					this.filter.pass_number = ''
					this.filter.name = ''
                    let page  = 1
                    this.laoding = true
                    localStorage.setItem("dir_f",  JSON.stringify(this.filter))
                    await this.actionDirections({page: page,items:this.filter})
                    this.laoding = false
				// }

			},
			async deletePassport(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
					this.laoding = true
					await this.actionDeleteDirection(id)
					await this.actionDirections({page: page,items:this.filter})
					this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: this.$t('Oʼchirildi'),
				    })
				}
			},
            checkApprove(item){
                if(
                    item.xronom_status == 'completed' &&
                    item.xjadval_status == 'completed' &&
                    item.titul_status == 'completed' &&
                    item.sxema_status == 'completed'
                ){
                    return 'да'
                }else{
                    return 'нет'
                }
            }
		}
	}
</script>
<style scoped>
	.toggleFilter{
		margin-right:15px;
	}
</style>
