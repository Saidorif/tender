<template>
	<div class="edit_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file-alt"></i>
<<<<<<< HEAD
				    Mening shartnomam
=======
				    {{$t('Tahrirlash')}}
>>>>>>> 97ac85b0e2544873572f4d2667f8ce2f0cf47fa6
				</h4>
                <div class="d-flex">
                    <!-- <button type="button" class="btn btn-success mr-2" @click="activeContract">
                    	Активировать
                    </button> -->
                    <router-link class="btn btn-primary back_btn" to="/crm/mycontract">
                        <span class="peIcon pe-7s-back"></span>
                        {{$t('Orqaga')}}
                    </router-link>
                </div>
		  	</div>
		  	<div class="card-body">
<<<<<<< HEAD
		  		<div class="row">
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Номер контракта</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.number}}
		  				</div>
		  			</div>
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Статус</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.status}}
		  				</div>
		  			</div>
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Контракт тузилган санаси</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.date}}
		  				</div>
		  			</div>
		  			<div class="col-md-3">
		  				<label for="number" class="form-control-label">Контракт тугаш санаси</label>
		  				<div class="form-control">
		  					{{getUserMycontracts.exp_date}}
		  				</div>
		  			</div>
		  		</div>
	  		</div>
		  	<div class="card-body">
		  		<div class="table table-responsive">
		  			<h2>Направления</h2>
			  		<table class="tab table-bordered table-hover" v-if="getUserMycontracts">
			  			<thead>
			  				<tr>
			  					<th>№</th>
			  					<th>Номер направления</th>
			  					<th>Название направления</th>
			  				</tr>
			  			</thead>
			  			<tbody>
			  				<tr v-for="(item,index) in getUserMycontracts.direction_ids" v-if="getUserMycontracts.direction_ids">
			  					<td width="5%">{{index+1}}</td>
			  					<td width="10%">{{item.pass_number}}</td>
			  					<td width="85%">{{item.name}}</td>
			  				</tr>
			  			</tbody>
			  		</table>
		  		</div>
		  	</div>
		  	<div class="card-body">
		  		<div class="table table-responsive">
		  			<h2>Мои авто</h2>
			  		<table class="tab table-bordered table-hover" v-if="getUserMycontracts">
			  			<thead>
			  				<tr>
			  					<th>Номер авто</th>
			  					<th>Категория авто</th>
			  					<th>Марка авто</th>
			  					<th>Модел авто</th>
			  					<th>Класс авто</th>
			  				</tr>
			  			</thead>
			  			<tbody>
			  				<tr v-for="(item,index) in getUserMycontracts.cars" v-if="getUserMycontracts.cars">
			  					<td>{{item.auto_number}}</td>
			  					<td>{{item.bustype ? item.bustype.name : ''}}</td>
			  					<td>{{item.busmarka ? item.busmarka.name : ''}}</td>
			  					<td>{{item.busmodel ? item.busmodel.name : ''}}</td>
			  					<td>{{item.tclass ? item.tclass.name : ''}}</td>
			  				</tr>
			  			</tbody>
			  		</table>
		  		</div>
=======
		  		<form @submit.prevent.enter="saveMycontract" enctype="multipart/form-data">
					<div class="row">
					  	<div class="form-group col-md-3">
						    <label for="number">{{$t('Shartnoma raqami')}}</label>
						    <input
						    	type="text"
						    	class="form-control input_style"
						    	id="number"
						    	v-model="form.number"
						    	:class="isRequired(form.number) ? 'isRequired' : ''"
					    	>
					  	</div>
					  	<div class="form-group col-md-3">
			              	<label for="date">{{$t('Shartnoma tuzilgan sana')}}</label>
			              	<date-picker
				                lang="ru"
				                type="date" format="YYYY-MM-DD" valueType="format"
				                v-model="form.date"
				                class="input_style"
				                :class="isRequired(form.date) ? 'isRequired' : ''"
			              	></date-picker>
			          	</div>
					  	<div class="form-group col-md-3">
			              	<label for="exp_date">{{$t('Amal qilish muddati')}}</label>
			              	<date-picker
				                lang="ru"
				                type="date" format="YYYY-MM-DD" valueType="format"
				                v-model="form.exp_date"
				                class="input_style"
				                :class="isRequired(form.exp_date) ? 'isRequired' : ''"
			              	></date-picker>
			          	</div>
			          	<div class="form-group col-md-3">
						    <label for="protocol_id">{{$t('Tashkilot nomi')}}</label>
						    <multiselect
								:value="user_values"
								:options="findUserList"
								@search-change="value => findUser(value)"
								v-model="user_values"
		                        :searchable="true"
		                        track-by="id"
		                        label="company_name"
		                        :max="3"
								:loading="isUserLoading"
								:selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
								:deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
								:option="[{company_name: 'Otash', id: 1}]"
								@select="dispatchUser"
								@remove="removeUser"
								:class="isRequired(form.user_id) ? 'isRequired' : ''"
								>
								<span slot="noResult">{{$t('Sizning qidirgan maʼlumot topilmadi.')}}</span>
								<span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
							</multiselect>
				  	    </div>
			          	<div class="form-group col-md-3">
						    <label for="protocol_id">{{$t('Protokol raqami')}}</label>
						    <multiselect
								:value="protocol_values"
								:options="findProtocolList"
								@search-change="value => findProtocol(value)"
								v-model="protocol_values"
		                        :searchable="true"
		                        track-by="id"
		                        label="number"
		                        :max="3"
								:loading="isProtocolLoading"
								:selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
								:deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
								:option="[{number: 'Otash', id: 1}]"
								@select="dispatchProtocol"
								@remove="removeProtocol"
								:class="isRequired(form.protocol_id) ? 'isRequired' : ''"
								>
								<span slot="noResult">{{$t('Sizning qidirgan maʼlumot topilmadi.')}}</span>
								<span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
							</multiselect>
				  	    </div>
					  	<div class="form-group col-md-3">
			              	<label for="contract_period">{{$t('Shartnoma periodi')}}</label>
			              	<select class="form-control input_style" v-model="form.contract_period" :class="isRequired(form.contract_period) ? 'isRequired' : ''">
			              		<option value="" selected disabled>{{$t('Tanlang')}}!</option>
			              		<option value="1">1 {{$t('yil')}}</option>
			              		<option value="2">2 {{$t('yil')}}</option>
			              		<option value="3">3 {{$t('yil')}}</option>
			              		<option value="4">4 {{$t('yil')}}</option>
			              		<option value="5">5 {{$t('yil')}}</option>
			              	</select>
			          	</div>
					  	<div class="form-group col-md-3">
			              	<label for="date">{{$t('Fayl')}}</label>
			              	<input
			              		type="file"
			              		name="file"
			              		id="file"
			              		class="form-control input_style"
			              		:class="isRequired(form.file) ? 'isRequired' : ''"
			              		@change="changePhoto($event)"
		              		>
		              		<small>
		              			<a :href="'/'+fileName" download>
		              				<i class="fas fa-download"></i>
		              				{{$t('Faylni yuklash')}}
		              			</a>
		              		</small>
			          	</div>
			          	<div class="form-group col-md-3">
						    <label for="marshrut">{{$t('Yoʼnalish')}}</label>
						    <multiselect
								:value="directionvalues"
								:options="findDirectionList"
								@search-change="value => findDirection(value)"
								v-model="directionvalues"
		                        :searchable="true"
		                        track-by="id"
		                        label="name"
		                        :max="3"
								:loading="isDirectionLoading"
								:selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
								:deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
								:option="[{name: 'Otash', id: 1}]"
								@remove="removeDirect"
                                :multiple="true"
								>
								<span slot="noResult">{{$t('Sizning qidirgan maʼlumot topilmadi.')}}</span>
								<span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
							</multiselect>
				  		</div>
				  		<div class="ml-3 d-flex justify-content-center w-100 border pt-2 mb-4">
							<h4>{{$t('Mening avtomobillarim')}}</h4>
						</div>
					  	<div class="form-group col-lg-12">
					  		<div class="row" v-for="(car,index) in cars">
					        	<div class="item_index">
					        		{{index+1}})
				        		</div>
					        	<div class="form-group col-md-1">
								    <label for="auto_number">{{$t('Avtomobil raqami')}}</label>
								    <input
								    	type="text"
								    	class="form-control input_style"
								    	id="auto_number"
								    	v-mask="'********'"
								    	v-model="car.auto_number"
								    	:class="isRequired(car.auto_number) ? 'isRequired' : ''"
							    	>
							  	</div>
							  	<div class="form-group col-md-3">
								    <label for="bustype_id">{{$t('Avtomobil turi')}}</label>
								    <select
									    class="form-control input_style"
								    	id="bustype_id"
								    	v-model="car.bustype_id"
								    	:class="isRequired(car.bustype_id) ? 'isRequired' : ''"
			                            @change="selectClass(car)"
								    >
								    	<option value="" selected disabled>{{$t('Tanlang')}}!</option>
								    	<option
								    		:value="busType.id"
								    		v-for="(busType,index) in getTypeofbusList"
								    		data-toggle="tooltip" data-placement="right" title="Tooltip on right"
							    		>{{busType.name}}</option>
								    </select>
							  	</div>
			                    <div class="form-group col-md-2">
								    <label for="tclass_id">{{$t('Avtomobil sinfi')}}</label>
								    <select
									    class="form-control input_style"
								    	id="tclass_id"
								    	v-model="car.tclass_id"
								    	:class="isRequired(car.tclass_id) ? 'isRequired' : ''"
								    >
								    	<option value="" selected disabled>{{$t('Tanlang')}}!</option>
								    	<option :value="busClass.id" v-for="(busClass,index) in car.getBusclassFindList">{{busClass.name}}</option>
								    </select>
							  	</div>
							  	<div class="form-group col-md-2">
								    <label for="busmarka_id">{{$t('Avtobus markasi')}}</label>
								    <select
									    class="form-control input_style"
								    	id="busmarka_id"
								    	v-model="car.busmarka_id"
								    	:class="isRequired(car.busmarka_id) ? 'isRequired' : ''"
								    	@change="selectCarMarka(car)"
								    >
								    	<option value="" selected disabled>{{$t('Tanlang')}}!</option>
								    	<option :value="item.id" v-for="(item,index) in getBusBrandList">{{item.name}}</option>
								    </select>
							  	</div>
							  	<div class="form-group col-md-2">
								    <label for="busmodel_id">{{$t('Avtomobil rusumi')}} </label>
								    <select
									    class="form-control input_style"
								    	id="busmodel_id"
								    	v-model="car.busmodel_id"
								    	:class="isRequired(car.busmodel_id) ? 'isRequired' : ''"
								    >
								    	<option value="" selected disabled>{{$t('Tanlang')}}!</option>
								    	<option :value="item.id" v-for="(item,index) in car.getBusmodelFindList">{{item.name}}</option>
								    </select>
							  	</div>
							  	<template v-if="car.id">
								  	<div class="form-group col-md-1 trash_car_item" @click.prevent="removeCarFromServer(car.id)">
								  		<i class="fas fa-trash-alt"></i>
								  	</div>
							  	</template>
							  	<template v-else>
								  	<div class="form-group col-md-1 trash_car_item" @click.prevent="removeCarItem(index)" v-if="index!=0">
								  		<i class="fas fa-trash-alt"></i>
								  	</div>
							  	</template>
					        </div>
				  	  	</div>
					  	<div class="form-group col-lg-12 d-flex justify-content-end align-items-center">
						  	<button type="button" class="btn btn-info mr-3" @click.prevent="addCarItem">
						  		<i class="fas fa-plus"></i>
							  	{{$t('Avtomobil qoʼshish')}}
							</button>
						  	<button type="submit" class="btn btn-primary">
						  		<i class="fas fa-save"></i>
							  	{{$t('Saqlash')}}
							</button>
				  	  	</div>
					</div>
				</form>
>>>>>>> 97ac85b0e2544873572f4d2667f8ce2f0cf47fa6
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Loader from '../../Loader'
	import Multiselect from 'vue-multiselect';
	import DatePicker from "vue2-datepicker";
	export default{
		components:{
			Loader,
			DatePicker,
			Multiselect,
		},
		data(){
			return{
				requiredInput:false,
				laoding: true,
			}
		},
		computed:{
			...mapGetters('typeofbus',['getTypeofbusList']),
            ...mapGetters('busmodel',['getBusmodelList', 'getBusmodelFindList']),
			...mapGetters('busclass',['getBusclassFindList']),
            ...mapGetters("busbrand", ["getBusBrandList"]),
			...mapGetters('mycontract',[
				'getMassage',
				'getMycontractFind',
				'getUserMycontracts',
			]),
			...mapGetters('myprotocol',[
				'getMyprotocolFind',
			]),
			...mapGetters('user',[
				'getUserfindList',
			]),
			...mapGetters('direction',[
				'getDirectionFindList',
			]),
		},
		async mounted(){
			await this.actionEditMycontract(this.$route.params.mycontractId)
			console.log(this.getUserMycontracts)
			this.laoding = false
		},
		methods:{
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList', 'actionBusmodelListByBrand', 'actionBusmodelFindList']),
			...mapActions('busclass',['actionBusclassFind']),
            ...mapActions("busbrand",["actionBusBrandList"]),
			...mapActions('mycontract',[
				'actionEditMycontract',
				'actionUpdateMycontract',
				'actionMyprotocolFind',
				'actionDeleteMycontractCar',
                'actionContractActivate',
			]),
			...mapActions('oldprotocol',[
				'actionOldprotocolFind',
			]),
			...mapActions('user',[
				'ActionUserFind',
			]),
			...mapActions('direction',['actionDirectionFind']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		}
	}
</script>
<style scoped>
	.btn_save{
		margin-top: 40px;
	}
	.item_index{
	    margin: 30px 0 0 30px;
    	font-size: 23px;
	}
	.trash_car_item{
		margin: 30px 0 0 30px;
    	font-size: 23px;
    	color:#c73838;
    	cursor:pointer;
	}
</style>
