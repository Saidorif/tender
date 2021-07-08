<template>
	<div class="add_region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    {{$t('Arizani yuborish')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/application"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}} </router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveApplication" >
					<div class="row">
						<div class="form-group col-md-7">
							<div class="row">
								<div
									class="form-group"
									:class="direction_ids && Object.keys(direction_ids).length > 0 ? ' col-md-10' : ' col-md-12'"
								>
								    <label for="marshrut">{{$t('Marshrut')}}</label>
								    <multiselect
										:value="direction_ids"
										:options="findList"
										@search-change="value => findDirection(value)"
										v-model="direction_ids"
				                        :searchable="true"
				                        track-by="id"
				                        label="name"
				                        :max="3"
										:loading="isLoading"
										:selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
										:deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
										:option="[{name: 'Otash', id: 1}]"
										@select="dispatchAction"
										@remove="removeDirectionFromList"
										>
										<span slot="noResult">{{$t('Sizning qidirgan maʼlumot topilmadi.')}}</span>
										<span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
									</multiselect>
								</div>
							  	<div class="form-group col-md-2 btn_show" v-if="direction_ids && Object.keys(direction_ids).length > 0">
								  	<button
								  		type="button"
								  		class="btn btn-outline-info"
							  		>
							  			<i class="fas fa-eye"></i>
							  			{{$t('Koʼrish')}}
							  		</button>
						  	  	</div>
							</div>
					  	</div>
					  	<div class="form-group col-md-3">
						    <label for="tarif">{{$t('Tarif')}}</label>
						    <input
						    	type="number"
						    	class="form-control input_style"
						    	id="tarif"
						    	v-model="form.tarif"
						    	:class="isRequired(form.tarif) ? 'isRequired' : ''"
					    	>
				  	  	</div>
				  	  	<div class="form-group col-md-2 btn_save d-flex justify-content-end">
						  	  <button type="button" class="btn btn-secondary mr-3" @click.prevent="addCar">
							  		<i class="fas fa-plus"></i>
								  	{{$t('Avtomobil qoʼshish')}}
						      </button>
				      	</div>
					</div>
					<div class="row">
					  <div class="form-group col-md-3">
					    <label for="auto_number">{{$t('Avtomobil raqami')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="auto_number"
					    	v-model="form.car.auto_number"
					    	:class="isRequired(form.car.auto_number) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="bustype_id">{{$t('Avtomobil turi')}}</label>
					    <select
						    class="form-control input_style"
					    	id="bustype_id"
					    	v-model="form.car.bustype_id"
					    	:class="isRequired(form.car.bustype_id) ? 'isRequired' : ''"
					    	@change="selectClass(form.car.bustype_id, form.car.busmodel_id)"
					    >
					    	<option value="" selected disabled>{{$t('Avtomobil turini tanlang')}}!</option>
					    	<option :value="busType.id" v-for="(busType,index) in getTypeofbusList">{{busType.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="busmodel_id">{{$t('Avtomobil rusumi')}}</label>
					    <select
						    class="form-control input_style"
					    	id="busmodel_id"
					    	v-model="form.car.busmodel_id"
					    	:class="isRequired(form.car.busmodel_id) ? 'isRequired' : ''"
					    	@change="selectClass(form.car.bustype_id, form.car.busmodel_id)"
					    >
					    	<option value="" selected disabled>{{$t('Avtomobil rusumini tanlang')}}!</option>
					    	<option :value="busmodel.id" v-for="(busmodel,index) in getBusmodelList">{{busmodel.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="tclass_id">{{$t('Avtomobil sinfi')}}</label>
					    <select
						    class="form-control input_style"
					    	id="tclass_id"
					    	v-model="form.car.tclass_id"
					    	:class="isRequired(form.car.tclass_id) ? 'isRequired' : ''"

					    >
					    	<option value="" selected disabled>{{$t('Avtomobil sinfini tanlang')}}!</option>
					    	<option :value="busClass.id" v-for="(busClass,index) in form.car.tclasses">{{busClass.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="date">{{$t('Ishlab chiqarilgan sana')}}</label>
					    <input
					    	type="date"
					    	class="form-control input_style"
					    	id="date"
					    	v-model="form.car.date"
					    	:class="isRequired(form.car.date) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="capacity">{{$t('capacity')}}</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="capacity"
					    	v-model="form.car.capacity"
					    	:class="isRequired(form.car.capacity) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="seat_qty">{{$t('Oʼrindiqlar soni')}}</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="seat_qty"
					    	v-model="form.car.seat_qty"
					    	:class="isRequired(form.car.seat_qty) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="qty_reys">{{$t('Reyslar (qatnovlar) soni')}}</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="qty_reys"
					    	v-model="form.car.qty_reys"
					    	:class="isRequired(form.car.qty_reys) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-12 table table-responsive">
					  	<table class="table table-bordered">
					  		<thead>
					  			<tr>
					  				<th width="1%">1</th>
					  				<th width="50%">{{$t('Sovutgich (iqlim-nazorati tizimi)')}}</th>
					  				<th>
					  					<input type="checkbox" value="1" v-model="form.car.conditioner">
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>2</th>
					  				<th width="50%">{{$t('Internet')}}</th>
					  				<th>
					  					<input type="checkbox" value="1" v-model="form.car.internet">
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>3</th>
					  				<th width="50%">{{$t('Bioxojatxona')}}</th>
					  				<th>
					  					<input type="checkbox" value="1" v-model="form.car.bio_toilet">
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>4</th>
					  				<th width="50%">
                                        {{$t('Аvtobusning nogironlarga va aholining boshqa xarakatlanishi cheklangan guruxlariga moslashganligi')}}
					  				</th>
					  				<th>
					  					<input type="checkbox" value="1" v-model="form.car.bus_adapted">
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>5</th>
					  				<th width="50%">
					  					{{$t('Telefon quvvatlagichlari')}}
					  				</th>
					  				<th>
					  					<input type="checkbox" value="1" v-model="form.car.telephone_power">
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>6</th>
					  				<th width="50%">
                                        {{$t('Xar bir oʼrindiqda monitor (planshet)')}}
					  				</th>
					  				<th>
					  					<input type="checkbox" value="1" v-model="form.car.monitor">
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>7</th>
					  				<th width="50%">
                                        {{$t('Bekatlarni eʼlon qilish')}}
					  				</th>
					  				<th>
					  					<input type="checkbox" value="1" v-model="form.car.station_announce">
					  				</th>
					  			</tr>
					  		</thead>
					  	</table>
					  </div>
					  <hr>
					  	<div class="form-group col-md-12 table table-responsive">
						  	<h4>{{$t('Tadbirlar rejasi')}}</h4>
						  	<table class="table table-bordered">
						  		<thead>
						  			<tr>
						  				<th width="1%">1</th>
						  				<th width="50%">
                                            {{$t('Аvtotransport vositalarini xar kuni reysdan oldingi texnik koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
						  				</th>
						  				<th>
						  					<input type="checkbox" name="" value="1" v-model="form.daily_technical_job">
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>2</th>
						  				<th width="50%">
                                            {{$t('Haydovchilarni har kungi tibbiy koʼrikdan oʼtkazish uchun barcha sharoitlar yaratilgan')}}
						  				</th>
						  				<th>
						  					<input type="checkbox" name="" value="1" v-model="form.daily_medical_job">
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>3</th>
						  				<th width="50%">
                                            {{$t('Taklif etilgan avtotransport vositalari sonidan kelib chiqib barcha haydovchilariga 30 soatlik dastur boʼyicha yoʼl harakati qoidalarini oʼrgatilgan')}}
						  				</th>
						  				<th>
						  					<input type="checkbox" name="" value="1" v-model="form.hours_rule">
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>4</th>
						  				<th width="50%">
                                            {{$t('Taklif etilgan barcha avtotransport vositalarining old oynalariga videoregistrator oʼrnatilgan')}}
						  				</th>
						  				<th>
						  					<input type="checkbox" name="" value="1" v-model="form.videoregistrator">
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>5</th>
						  				<th width="50%">
                                            {{$t('Taklif etilgan barcha avtotransport vositalarini GPS rejimida masofadan kuzatish tizimiga ulangan')}}
						  				</th>
						  				<th>
						  					<input type="checkbox" name="" value="1" v-model="form.gps">
						  				</th>
						  			</tr>
						  		</thead>
						  	</table>
					  	</div>
						<div class="form-group col-md-12 table table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>№</th>
										<th>{{$t('Avtomobil raqami')}}</th>
										<th>{{$t('Avtomobil turi')}}</th>
										<th>{{$t('Avtomobil rusumi')}}</th>
										<th>{{$t('Avtomobil sinfi')}}</th>
										<th>{{$t('Ishlab chiqarilgan sana')}}</th>
										<th>{{$t('capacity')}}</th>
										<th>{{$t('Oʼrindiqlar soni')}}</th>
										<th>{{$t('Reyslar soni')}}</th>
										<th>{{$t('Tahrirlash')}}</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>data</td>
										<td>data</td>
										<td>data</td>
										<td>data</td>
										<td>data</td>
										<td>data</td>
										<td>data</td>
										<td>data</td>
										<td>
											<button type="button" class="btn_transparent">
												<i class="pe_icon pe-7s-edit editColor"></i>
											</button>
											<button type="button" class="btn_transparent" @click="deleteCar">
												<i class="pe_icon pe-7s-trash trashColor"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					  	<div class="form-group col-lg-12 d-flex justify-content-end">
						  	<button type="button" class="btn btn-secondary mr-3" @click.prevent="saveData">
						  		<i class="fas fa-save"></i>
							  	{{$t('Saqlash')}}
							</button>
						  	<button type="button" class="btn btn-primary btn_save_category">
						  		<i class="far fa-share-square"></i>
							  	{{$t('Yuborish')}}
							</button>
				  	  	</div>
					</div>
				</form>
		  	</div>
	  	</div>
	</div>
</template>
<script>
    import { mapGetters , mapActions } from 'vuex'
    import Loader from '../../Loader'
	import Multiselect from 'vue-multiselect';
	export default{
		components:{
            Multiselect,
            Loader
		},
		data(){
			return{
                laoding: true,
				form:{
					car:{
						auto_number:'',
						bustype_id:'',
						busmodel_id:'',
						tclass_id:'',
						qty_reys:'',
						capacity:'',
						seat_qty:'',
						date:'',
						conditioner:'',
						internet:'',
						bio_toilet:'',
						bus_adapted:'',
						telephone_power:'',
						monitor:'',
						tclasses:[]
					},
					direction_ids:[],
					tarif:'',
					direction_id:'',
					daily_medical_job:'',
					daily_technical_job:'',
					videoregistrator:'',
					gps:'',
					hours_rule:'',
				},
				cars_with:[
					{
						auto_number:'',
						bustype_id:'',
						busmodel_id:'',
						tclass_id:'',
						qty_reys:'',
						capacity:'',
						seat_qty:'',
						date:'',
						conditioner:'',
						internet:'',
						bio_toilet:'',
						bus_adapted:'',
						telephone_power:'',
						monitor:'',
						tclasses:[]
					}
				],
				findList:[],
				direction_ids:{},
				requiredInput:false,
				isLoading:false,
				newItems:[]
			}
		},
		computed:{
			...mapGetters('direction',['getDirectionFindList']),
			...mapGetters('application',['getMassage','getApplication']),
			...mapGetters('typeofbus',['getTypeofbusList']),
			...mapGetters('busmodel',['getBusmodelList']),
			...mapGetters('busclass',['getBusclassFindList']),
		    checkCars(){
		    	this.form.cars.forEach((item,index)=>{
	    			if (item.auto_number != '' && item.bustype_id != '' && item.busmodel_id != '' && item.tclass_id != '') {
	    				return true
	    			}else{
	    				return false
	    			}
		    	})
		    },
		},
		async mounted(){
			await this.actionEditApplication(this.$route.params.applicationId)
			await this.actionTypeofbusList()
            await this.actionBusmodelList()
            this.laoding = false
			this.form = this.getApplication
			Vue.set(this.form,'direction_ids',[])
			Vue.set(this.form,'car',
				{
					auto_number:'',
					bustype_id:'',
					busmodel_id:'',
					tclass_id:'',
					qty_reys:'',
					capacity:'',
					seat_qty:'',
					date:'',
					conditioner:'',
					internet:'',
					bio_toilet:'',
					bus_adapted:'',
					telephone_power:'',
					monitor:'',
					tclasses:[]
				})
		},
		methods:{
			...mapActions('application',['actionEditApplication','actionUpdateApplication']),
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList']),
			...mapActions('direction',['actionDirectionFind']),
			...mapActions('busclass',['actionBusclassFind']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    saveData(){

		    },
		    removeDirectionFromList(data){
		    	this.direction_ids = {}
		    	this.findList = []
		    },
		    dispatchAction(data){
			  	this.form.direction_ids.push(data.id);
			  	this.form.direction_id = data.id
		    },
	     	async findDirection(value){
		      if(value != ''){
                this.laoding = true
		        this.isLoading = true
		        await setTimeout(async ()=>{
					await this.actionDirectionFind({name: value})
			        this.findList = this.getDirectionFindList
		        this.isLoading = false
		        },1000)
                this.laoding = false
		      }
		    },
		    async selectClass(bustype_id,busmodel_id){
		    	this.form.car.tclass_id = ''
		    	if (bustype_id && busmodel_id) {
		    		let data = {
		    			'bustype_id':bustype_id,
		    			'busmodel_id':busmodel_id
		    		}
                    this.laoding = true
			    	await this.actionBusclassFind(data)
                    this.laoding = false
		    		this.form.car.tclasses = this.getBusclassFindList
		    	}
		    },
		    addCar(){
		   //  	let item = {
		   //  		auto_number:'',
					// bustype_id:'',
					// busmodel_id:'',
					// tclass_id:'',
					// qty_reys:'',
					// capacity:'',
					// seat_qty:'',
					// date:'',
					// conditioner:'',
					// internet:'',
					// bio_toilet:'',
					// bus_adapted:'',
					// telephone_power:'',
					// monitor:'',
					// tclasses:[],
		   //  	}
		   //  	this.form.cars.push(item)
		    },
		    deleteCar(index){
		    	// this.form.cars.splice(index, 1);
		    },
			async saveApplication(){
		    	if (this.form.seat != '' && this.form.tarif != '' && this.requiredInput){
                    this.laoding = true
					await this.actionAddApplication(this.form)
                    this.laoding = false
					this.$router.push("/crm/application");
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
	.btn_show{
	    display: flex;
	    align-items: center;
	    margin-top: 30px;
	}
	.btn_save{
	    display: flex;
	    align-items: center;
	    margin-top: 15px;
	}
</style>
