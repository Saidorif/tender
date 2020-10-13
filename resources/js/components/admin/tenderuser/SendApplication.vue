<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    Отправить Заявку
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/application"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form>
					<div class="row">
						<div class="form-group col-md-7">
							<div class="row">
								<div 
									class="form-group" 
									:class="direction_ids && Object.keys(direction_ids).length > 0 ? ' col-md-10' : ' col-md-12'"
								>
								    <!-- <label for="marshrut">Маршрут</label> -->
				<!-- 				    <multiselect 
										:value="direction_ids"
										:options="findList"
										@search-change="value => findDirection(value)"
										v-model="direction_ids" 
				                        placeholder="Выберите маршрут"
				                        :searchable="true"
				                        track-by="id"
				                        label="name"
				                        :max="3"
										:loading="isLoading"
										selectLabel="Нажмите Enter, чтобы выбрать"
										deselectLabel="Нажмите Enter, чтобы удалить"
										:option="[{name: 'Otash', id: 1}]"
										@select="dispatchAction"
										@remove="removeDirectionFromList"
										>
										<span slot="noResult">По вашему запросу ничего не найдено</span>
										<span slot="noOptions">Cписок пустой</span>
									</multiselect>	 -->
								</div>	
							  	<div class="form-group col-md-2 btn_show" v-if="direction_ids && Object.keys(direction_ids).length > 0">
								  	<button 
								  		type="button" 
								  		class="btn btn-outline-info" 
							  		>
							  			<i class="fas fa-eye"></i>
							  			Посмотреть
							  		</button>
						  	  	</div>
							</div>
					  	</div>
					  	<div class="form-group col-md-3">
						    <label for="tarif">Тариф</label>
						    <input 
						    	type="number" 
						    	class="form-control input_style" 
						    	id="tarif" 
						    	placeholder="Тариф"
						    	v-model="form.tarif"
						    	:class="isRequired(form.tarif) ? 'isRequired' : ''"  
					    	>
				  	  	</div>
				  	  	<div class="form-group col-md-2 btn_save d-flex justify-content-end">
						  	  <button type="button" class="btn btn-secondary mr-3" @click.prevent="openModal">
							  		<i class="fas fa-plus"></i>
								  	Добавить авто 
						      </button>	
				      	</div>
					</div>
					<div class="row"> 	
					  	<div class="form-group col-md-12 table table-responsive">
					  		<div class="d-flex justify-content-center">
							  	<h4>Тадбирлар режаси</h4>
							</div>
						  	<table class="table table-bordered">
						  		<thead>
						  			<tr>
						  				<th width="1%">1</th>
						  				<th width="50%">
						  					Автотранспорт воситаларини хар куни рейсдан олдинги техник кўрикдан 
						  					ўтказиш учун барча шароитлар яратилган
						  				</th>
						  				<th>
						  					<input 
						  						type="checkbox" 
						  						name="daily_technical_job" 
						  						true-value="1"
												false-value="0"
						  						v-model="form.daily_technical_job"
					  						>
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>2</th>
						  				<th width="50%">
						  					Ҳайдовчиларни ҳар кунги тиббий кўрикдан ўтказиш учун барча
						  					шароитлар яратилган
						  				</th>
						  				<th>
						  					<input 
						  						type="checkbox" 
						  						name="daily_medical_job" 
						  						true-value="1"
												false-value="0"
						  						v-model="form.daily_medical_job"
					  						>
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>3</th>
						  				<th width="50%">
						  					Таклиф этилган автотранспорт воситалари сонидан келиб чиқиб барча 
						  					ҳайдовчиларига 30 соатлик дастур бўйича йўл ҳаракати қоидаларини ўргатилган
						  				</th>
						  				<th>
						  					<input 
						  						type="checkbox" 
						  						name="hours_rule" 
						  						true-value="1"
												false-value="0"
						  						v-model="form.hours_rule"
					  						>
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>4</th>
						  				<th width="50%">
						  					Таклиф этилган барча автотранспорт воситаларининг олд ойналарига видеорегистратор
						  					ўрнатилган
						  				</th>
						  				<th>
						  					<input 
						  						type="checkbox" 
						  						name="videoregistrator" 
						  						true-value="1"
												false-value="0"
						  						v-model="form.videoregistrator"
					  						>
						  				</th>
						  			</tr>
						  			<tr>
						  				<th>5</th>
						  				<th width="50%">
						  					Таклиф этилган барча автотранспорт воситаларини "GPS" режимида масофадан кузатиш
						  					тизимига уланган
						  				</th>
						  				<th>
						  					<input 
						  						type="checkbox" 
						  						name="gps" 
						  						true-value="1"
												false-value="0"
						  						v-model="form.gps"
					  						>
						  				</th>
						  			</tr>
						  		</thead>
						  	</table>
					  	</div>
						<div class="form-group col-md-12 table table-responsive" v-if="cars_with.length > 0">
							<div class="d-flex justify-content-center">
								<h4>Мои автомобили</h4>
							</div>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>№</th>
										<th>Номер Авто</th>
										<th>Тип Авто</th>
										<th>Модель Авто</th>
										<th>Класс Авто</th>
										<th>Дата выпуска</th>
										<th>Вместимость</th>
										<th>Количество сидящих</th>
										<th>Количество рейсов</th>
										<th>Действия</th>
									</tr>
								</thead>
								<tbody>
									<template v-for="(car,index) in cars_with">
										<tr>
											<td>{{index+1}}</td>
											<td>{{car.auto_number}}</td>
											<td>{{car.bustype.name}}</td>
											<td>{{car.busmodel.name}}</td>
											<td>{{car.tclass.name}}</td>
											<td>{{car.date}}</td>
											<td>{{car.capacity}}</td>
											<td>{{car.seat_qty}}</td>
											<td>{{car.qty_reys}}</td>
											<td>
												<button type="button" class="btn_transparent" @click.prevent="showTable(index)">
													<i class="pe-7s-angle-down-circle"></i>
												</button>
												<button type="button" class="btn_transparent" @click.prevent="deleteCar(car.id)">
													<i class="pe_icon pe-7s-trash trashColor"></i>
												</button>
											</td>
										</tr>
										<tr v-if="showBtn == index">
											<td colspan="10">
												<table class="table table-bordered">
											  		<thead>
											  			<tr>
											  				<th width="1%">1</th>
											  				<th width="50%">Кондиционер (климат-назорати тизими)</th>
											  				<th>
											  					<input 
											  						type="checkbox" 
											  						true-value="1"
																	false-value="0"
											  						v-model="car.conditioner"
										  						>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>2</th>
											  				<th width="50%">Интернет</th>
											  				<th> 
											  					<input 
											  						type="checkbox" 
											  						true-value="1"
																	false-value="0"
											  						v-model="car.internet"
										  						>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>3</th>
											  				<th width="50%">Биохожатхона</th>
											  				<th>
											  					<input 
											  						type="checkbox" 
											  						true-value="1"
																	false-value="0" 
											  						v-model="car.bio_toilet"
										  						>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>4</th>
											  				<th width="50%">
											  					Автобуснинг ногиронларга ва аҳолининг бошқа харакатланиши чекланган
											  					гурухларига мослашганлиги
											  				</th>
											  				<th>
											  					<input 
											  						type="checkbox" 
											  						true-value="1"
																	false-value="0"
											  						v-model="car.bus_adapted"
										  						>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>5</th>
											  				<th width="50%">
											  					Телефон қувватлагичлари
											  				</th>
											  				<th>
											  					<input 
											  						type="checkbox" 
											  						true-value="1"
																	false-value="0"
											  						v-model="car.telephone_power"
										  						>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>6</th>
											  				<th width="50%">
											  					Хар бир ўриндиқда монитор (планшет)
											  				</th>
											  				<th>
											  					<input 
											  						type="checkbox" 
											  						true-value="1"
																	false-value="0" 
											  						v-model="car.monitor"
										  						>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>7</th>
											  				<th width="50%">
											  					Бекатларни эълон қилиш
											  				</th>
											  				<th>
											  					<input 
											  						type="checkbox" 
											  						true-value="1"
																	false-value="0"
											  						v-model="car.station_announce"
										  						>
											  				</th>
											  			</tr>
											  		</thead>
											  	</table>
											</td>
										</tr>
									</template>
								</tbody>
							</table>
						</div>
					  	<div class="form-group col-lg-12 d-flex justify-content-end">
						  	<button type="button" class="btn btn-secondary mr-3" @click.prevent="saveData">
						  		<i class="fas fa-save"></i>
							  	Сохранить
							</button>
						  	<button type="button" class="btn btn-primary btn_save_category">
						  		<i class="far fa-share-square"></i>
							  	Отправить
							</button>	
				  	  	</div>
					</div>
				</form>
		  	</div>
	  	</div>
	  	<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Новое авто</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="row">
		        	<div class="form-group col-md-3">
					    <label for="auto_number">Номер Авто</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="auto_number" 
					    	placeholder="Номер Авто"
					    	v-model="car.auto_number"
					    	:class="isRequired(car.auto_number) ? 'isRequired' : ''"  
				    	>
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="bustype_id">Тип Авто</label> 
					    <select 
						    class="form-control input_style" 
					    	id="bustype_id" 
					    	placeholder="Номер Авто"
					    	v-model="car.bustype_id"
					    	:class="isRequired(car.bustype_id) ? 'isRequired' : ''" 
					    	@change="selectClass(car.bustype_id, car.busmodel_id)"
					    >
					    	<option value="" selected disabled>Выберите тип авто!</option>
					    	<option :value="busType.id" v-for="(busType,index) in getTypeofbusList">{{busType.name}}</option>
					    </select>
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="busmodel_id">Модель Авто</label>
					    <select 
						    class="form-control input_style" 
					    	id="busmodel_id" 
					    	placeholder="Номер Авто"
					    	v-model="car.busmodel_id"
					    	:class="isRequired(car.busmodel_id) ? 'isRequired' : ''" 
					    	@change="selectClass(car.bustype_id, car.busmodel_id)"
					    >
					    	<option value="" selected disabled>Выберите модель авто!</option>
					    	<option :value="busmodel.id" v-for="(busmodel,index) in getBusmodelList">{{busmodel.name}}</option>
					    </select>
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="tclass_id">Класс Авто</label>
					    <select 
						    class="form-control input_style" 
					    	id="tclass_id" 
					    	placeholder="Номер Авто"
					    	v-model="car.tclass_id"
					    	:class="isRequired(car.tclass_id) ? 'isRequired' : ''" 

					    >
					    	<option value="" selected disabled>Выберите класс авто!</option>
					    	<option :value="busClass.id" v-for="(busClass,index) in car.tclasses">{{busClass.name}}</option>
					    </select>
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="date">Дата выпуска</label>
					    <input 
					    	type="date" 
					    	class="form-control input_style" 
					    	id="date" 
					    	v-model="car.date"
					    	:class="isRequired(car.date) ? 'isRequired' : ''"  
				    	>
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="capacity">Вместимость</label>
					    <input 
					    	type="number" 
					    	class="form-control input_style" 
					    	id="capacity" 
					    	placeholder="Вместимость"
					    	v-model="car.capacity"
					    	:class="isRequired(car.capacity) ? 'isRequired' : ''"  
				    	>
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="seat_qty">Количество сидящих</label>
					    <input 
					    	type="number" 
					    	class="form-control input_style" 
					    	id="seat_qty" 
					    	placeholder="Количество сидящих"
					    	v-model="car.seat_qty"
					    	:class="isRequired(car.seat_qty) ? 'isRequired' : ''"  
				    	>
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="qty_reys">Количество рейсов</label>
					    <input 
					    	type="number" 
					    	class="form-control input_style" 
					    	id="qty_reys" 
					    	placeholder="Количество рейсов"
					    	v-model="car.qty_reys"
					    	:class="isRequired(car.qty_reys) ? 'isRequired' : ''"  
				    	>
				  	</div>
				  	<div class="form-group col-md-12 table table-responsive">
					  	<table class="table table-bordered">
					  		<thead>
					  			<tr>
					  				<th width="1%">1</th>
					  				<th width="50%">Кондиционер (климат-назорати тизими)</th>
					  				<th>
					  					<input 
					  						type="checkbox" 
					  						true-value="1"
											false-value="0"
					  						v-model="car.conditioner"
				  						>
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>2</th>
					  				<th width="50%">Интернет</th>
					  				<th> 
					  					<input 
					  						type="checkbox" 
					  						true-value="1"
											false-value="0"
					  						v-model="car.internet"
				  						>
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>3</th>
					  				<th width="50%">Биохожатхона</th>
					  				<th>
					  					<input 
					  						type="checkbox" 
					  						true-value="1"
											false-value="0" 
					  						v-model="car.bio_toilet"
				  						>
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>4</th>
					  				<th width="50%">
					  					Автобуснинг ногиронларга ва аҳолининг бошқа харакатланиши чекланган
					  					гурухларига мослашганлиги
					  				</th>
					  				<th>
					  					<input 
					  						type="checkbox" 
					  						true-value="1"
											false-value="0"
					  						v-model="car.bus_adapted"
				  						>
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>5</th>
					  				<th width="50%">
					  					Телефон қувватлагичлари
					  				</th>
					  				<th>
					  					<input 
					  						type="checkbox" 
					  						true-value="1"
											false-value="0"
					  						v-model="car.telephone_power"
				  						>
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>6</th>
					  				<th width="50%">
					  					Хар бир ўриндиқда монитор (планшет)
					  				</th>
					  				<th>
					  					<input 
					  						type="checkbox" 
					  						true-value="1"
											false-value="0" 
					  						v-model="car.monitor"
				  						>
					  				</th>
					  			</tr>
					  			<tr>
					  				<th>7</th>
					  				<th width="50%">
					  					Бекатларни эълон қилиш
					  				</th>
					  				<th>
					  					<input 
					  						type="checkbox" 
					  						true-value="1"
											false-value="0"
					  						v-model="car.station_announce"
				  						>
					  				</th>
					  			</tr>
					  		</thead>
					  	</table>
				    </div>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-warning" data-dismiss="modal">
		        	<i class="fas fa-times"></i>
		        	Закрыть
		        </button>
		        <button type="button" class="btn btn-primary" @click.prevent="addCar">
		        	<i class="fas fa-save"></i>
		        	Сохранить
		        </button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- Modal -->
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Multiselect from 'vue-multiselect';
	export default{
		components:{
			Multiselect
		},
		data(){
			return{
				form:{
					direction_ids:[],
					tarif:'',
					direction_id:'',
					daily_medical_job:0,
					daily_technical_job:0,
					videoregistrator:0,
					gps:0,
					hours_rule:0,
				},
				car:{
					auto_number:'',
					bustype_id:'',
					busmodel_id:'',
					tclass_id:'',
					qty_reys:'',
					capacity:'',
					seat_qty:'',
					date:'',
					conditioner:0,
					internet:0,
					bio_toilet:0,
					bus_adapted:0,
					telephone_power:0,
					monitor:0,
					tclasses:[]
				},
				cars_with:[],
				findList:[],
				direction_ids:{},
				requiredInput:false,
				showBtn:Number,
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
		watch:{
			getApplication:{
				handler(){
					if (this.getApplication) {
			    		this.cars_with = this.getApplication.cars_with
					}
				}
			}
		},
		async mounted(){
			await this.actionEditApplication(this.$route.params.userapplicationId)
			await this.actionTypeofbusList()
			await this.actionBusmodelList()
			this.form = this.getApplication
			this.cars_with = this.getApplication.cars_with
			Vue.set(this.form,'direction_ids',[])
		},
		methods:{
			...mapActions('application',['actionEditApplication','actionUpdateApplication','actionAddCar']),
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList']),
			...mapActions('direction',['actionDirectionFind']),
			...mapActions('busclass',['actionBusclassFind']),
			showTable(index){ 
				this.showBtn = index 
			},
			defaultValuesOfCar(){
				this.car.auto_number = ''
		    	this.car.bustype_id = ''
		    	this.car.busmodel_id = ''
		    	this.car.tclass_id = ''
		    	this.car.qty_reys = ''
		    	this.car.capacity = ''
		    	this.car.seat_qty = ''
		    	this.car.date = ''
		    	this.car.conditioner = 0
		    	this.car.internet = 0
		    	this.car.bio_toilet = 0
		    	this.car.bus_adapted = 0
		    	this.car.telephone_power = 0
		    	this.car.monitor = 0
		    	this.car.tclasses = []
		    },
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    openModal(){
		    	$('#myModal').modal('show')
		    	this.defaultValuesOfCar()
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
		        this.isLoading = true
		        await setTimeout(async ()=>{
					await this.actionDirectionFind({name: value})
			        this.findList = this.getDirectionFindList
		        this.isLoading = false
		        },1000)
		      }
		    },
		    async selectClass(bustype_id,busmodel_id){
		    	this.car.tclass_id = ''
		    	if (bustype_id && busmodel_id) {
		    		let data = {
		    			'bustype_id':bustype_id,
		    			'busmodel_id':busmodel_id
		    		}
			    	await this.actionBusclassFind(data)
		    		this.car.tclasses = this.getBusclassFindList
		    	}
		    },
		    async addCar(){
		    	if (this.car.auto_number != '' && this.car.bustype_id != '' && this.car.busmodel_id != '' && this.car.tclass_id != '' && 
			    	this.car.qty_reys != '' && this.car.capacity != '' && this.car.seat_qty != '' && this.car.date != '') 
		    	{
					this.car['app_id'] = this.$route.params.userapplicationId
			    	await this.actionAddCar(this.car)
			    	if(this.getMassage.success){
				    	await this.actionEditApplication(this.$route.params.userapplicationId)
				    	$('#myModal').modal('hide')
				    	// this.defaultValuesOfCar()
			    	}
		    		this.requiredInput = false
		    	}else{
		    		this.requiredInput = true
		    	}

		    },
		    async saveData(){
		    	await this.actionUpdateApplication(this.form)
		    	if(this.getMassage.success){
		    		toast.fire({
			            type: "success",
			            icon: "success",
			            title: this.getMassage.message
		          	});
		    		await this.actionEditApplication(this.$route.params.userapplicationId)
		    	}
		    },
		    deleteCar(index){
		    	// this.form.cars.splice(index, 1);
		    },
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