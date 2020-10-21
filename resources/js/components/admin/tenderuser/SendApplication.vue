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
		  		<form enctype="multipart/form-data">
					<div class="row">
						<div class="form-group col-md-3 d-flex align-items-center mt-4">
							<button
						  		type="button"
						  		class="btn btn-outline-info"
						  		@click.prevent="showDirections =! showDirections"
					  		>
					  			<i class="fas fa-route"></i>
					  			Маршруты
					  			<i class="pe-7s-angle-down-circle"></i>
					  		</button>
					  	</div>
					  	<div class="form-group col-md-4">
						    <label for="tarif">Тариф</label>
						    <div class="d-flex align-items-center">
						    	<span class="road_price">Йул хаққи:</span>
						    	<input
						    	type="number"
						    	class="form-control input_style"
						    	id="tarif"
						    	placeholder="Тариф"
						    	v-model="form.tarif"
						    	:class="isRequired(form.tarif) ? 'isRequired' : ''"
					    	></div>
				  	  	</div>
				  	  	<div class="form-group col-md-3">
						    <label for="qty_reys">Количество рейсов</label>
						    <input
						    	type="number"
						    	class="form-control input_style"
						    	id="qty_reys"
						    	placeholder="Количество рейсов"
						    	v-model="form.qty_reys"
						    	:class="isRequired(form.qty_reys) ? 'isRequired' : ''"
					    	>
					  	</div>
				  	  	<div class="form-group col-md-2 btn_save d-flex justify-content-end">
					  	  	<button type="button" class="btn btn-secondary mr-3" @click.prevent="openModal">
						  		<i class="fas fa-plus"></i>
							  	Добавить авто
					      	</button>
				      	</div>
					</div>
					<div class="row" v-if="showDirections">
						<div class="col-md-12">
							<div class="table-responsive" v-if="direction_ids.length > 0">
						  		<div class="d-flex justify-content-center">
						  			<h4>Маршруты</h4>
						  		</div>
							  	<div class="choosenItemsTable">
							  		<ul v-for="(items,index) in direction_ids">
							  			<h3>{{index+1}})</h3>
						  		    	<template>
								  		    <li class="mb-2">
								  		    	<h4>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</h4>
								  		    	<table class="table table-bordered">
										  			<thead>
											  			<tr>
											  				<th>№</th>
											  				<th v-for="(item,index) in items.reysesFrom[0].reys_times" colspan="2">
												  				{{item.where.name}}
												  			</th>
											  			</tr>
											  		</thead>
											  		<tbody>
											  			<tr
											  				v-for="(reys,key) in items.reysesFrom"
											  				:class="activeEditClass(lots[index],reys.id) ? 'active' : ''"
										  				>
											  				<td>{{key+1}}</td>
											  				<template v-for="(val,key) in reys.reys_times">
												  				<td>{{val.start}}</td>
												  				<td>{{val.end}}</td>
											  				</template>
											  			</tr>
											  		</tbody>
											  	</table>
								  			</li>
								  		    <li>
								  		    	<h4>{{items.reysesTo[0].where.name}} - {{items.reysesTo[0].from.name}}</h4>
								  		    	<table class="table table-bordered">
										  			<thead>
											  			<tr>
											  				<th>№</th>
											  				<th v-for="(item,index) in items.reysesTo[0].reys_times" colspan="2">
												  				{{item.where.name}}
												  			</th>
											  			</tr>
											  		</thead>
											  		<tbody>
											  			<tr
											  				v-for="(reys,key) in items.reysesTo"
											  				:class="activeEditClass(lots[index],reys.id) ? 'active' : ''"
										  				>
											  				<td>{{key+1}}</td>
											  				<template v-for="(val,key) in reys.reys_times">
												  				<td>{{val.start}}</td>
												  				<td>{{val.end}}</td>
											  				</template>
											  			</tr>
											  		</tbody>
										  	 	</table>
								  			</li>
						  		    	</template>
							  		</ul>
							  	</div>
						  	</div>
						</div>
					</div>
					<div class="row">
					  	<div class="form-group col-md-12 table table-responsive">
					  		<div class="d-flex justify-content-center">
							  	<h4 class="app_title">
								  	Йўналишларда ишлаётганда ҳаракатланиш хавфсизлигини таъминлаш бўйича қатнашчи томонидан амалга оширилган тадбирлар режаси қуйидагича баҳоланади
							  	</h4>
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
				  		<div class="form-group col-lg-12" v-if="form.hours_rule == 1">
				  			<div class="row pl-3">
				  				<!-- <div class="form-group col-md-3">
						  			<input
					                    type="file"
					                    class="form-control"
					                    id="image"
					                    accept=".png, .jpg, .jpeg"
					                    @change="changePhoto($event)"
					                  />
				  				</div> -->
                                <div class=" input-group input_group_with_label input_file col-md-3">
                                    <input
					                    type="file"
					                    class="form-control"
					                    id="image"
					                    accept=".png, .jpg, .jpeg"
					                    @change="changePhoto($event)"
                                    />
                                    <p>{{ file ? file.name : ''}}</p>
                                    <label for="file"> {{$t('contacts_page.file_upload')}}</label>
                                </div>
				  				<div class="form-group col-md-2">
						  			<button type="button" class="btn btn-info text-white" @click.prevent="addFile">
					  					<i class="fas fa-plus"></i>
					  					Добавить файл
						  			</button>
				  				</div>
				  				<div class="form-group col-md-12" v-if="files.length > 0">
				  					<ul class="list-inline d-flex">
				  					    <li v-for="(f_name,index) in files" class="mr-4">
								  			<a :href="'/'+f_name.path+'/'+f_name.hash" title="" download="" class="btn btn-outline-dark">
								  				<i class="fas fa-download"></i>
								  				{{f_name.original_name}}
								  			</a>
								  			<button type="button" class="btn btn-danger" @click.prevent="removeFile(f_name.id)">
												<i class="pe_icon pe-7s-trash trashColor"></i>
											</button>
				  					    </li>
				  					</ul>
				  				</div>
				  			</div>
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
										<th>Категория Авто</th>
										<th>Модель Авто</th>
										<th>Класс Авто</th>
										<th>Дата выпуска</th>
										<th>Вместимость</th>
										<th>Количество сидящих</th>
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
											  				<th width="80%">Кондиционер (климат-назорати тизими)</th>
											  				<th>
											  					<i
											  						class="fas text-success"
											  						:class="car.conditioner == 1 ? ' fa-check-circle' : ''"
										  						></i>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>2</th>
											  				<th width="80%">Интернет</th>
											  				<th>
											  					<i
											  						class="fas text-success"
											  						:class="car.internet == 1 ? ' fa-check-circle' : ''"
										  						></i>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>3</th>
											  				<th width="80%">Биохожатхона</th>
											  				<th>
											  					<i
											  						class="fas text-success"
											  						:class="car.bio_toilet == 1 ? ' fa-check-circle' : ''"
										  						></i>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>4</th>
											  				<th width="80%">
											  					Автобуснинг ногиронларга ва аҳолининг бошқа харакатланиши чекланган
											  					гурухларига мослашганлиги
											  				</th>
											  				<th>
											  					<i
											  						class="fas text-success"
											  						:class="car.bus_adapted == 1 ? ' fa-check-circle' : ''"
										  						></i>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>5</th>
											  				<th width="80%">
											  					Телефон қувватлагичлари
											  				</th>
											  				<th>
											  					<i
											  						class="fas text-success"
											  						:class="car.telephone_power == 1 ? ' fa-check-circle' : ''"
										  						></i>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>6</th>
											  				<th width="80%">
											  					Хар бир ўриндиқда монитор (планшет)
											  				</th>
											  				<th>
											  					<i
											  						class="fas text-success"
											  						:class="car.monitor == 1 ? ' fa-check-circle' : ''"
										  						></i>
											  				</th>
											  			</tr>
											  			<tr>
											  				<th>7</th>
											  				<th width="80%">
											  					Бекатларни эълон қилиш аудио тизими
											  				</th>
											  				<th>
											  					<i
											  						class="fas text-success"
											  						:class="car.station_announce == 1 ? ' fa-check-circle' : ''"
										  						></i>
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
					    <label for="bustype_id">Категория Авто</label>
					    <select
						    class="form-control input_style"
					    	id="bustype_id"
					    	placeholder="Номер Авто"
					    	v-model="car.bustype_id"
					    	:class="isRequired(car.bustype_id) ? 'isRequired' : ''"
					    	@change="selectClass(car.bustype_id, car.busmodel_id)"
					    >
					    	<option value="" selected disabled>Выберите категорию авто!</option>
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
				  	<div class="form-group col-md-4">
					    <label for="date">Дата выпуска</label>
					    <input
					    	type="date"
					    	class="form-control input_style"
					    	id="date"
					    	v-model="car.date"
					    	:class="isRequired(car.date) ? 'isRequired' : ''"
				    	>
				  	</div>
				  	<div class="form-group col-md-4">
					    <label for="capacity">Вместимость</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="capacity"
					    	placeholder="Вместимость"
					    	v-model="car.capacity"
					    	max="999"
					    	:class="isRequired(car.capacity) ? 'isRequired' : ''"
				    	>
				  	</div>
				  	<div class="form-group col-md-4">
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
				  	<div class="form-group col-md-12 table table-responsive">
					  	<table class="table table-bordered">
					  		<thead>
					  			<tr>
					  				<th width="1%">1</th>
					  				<th width="80%">Кондиционер (климат-назорати тизими)</th>
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
					  				<th width="80%">Интернет</th>
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
					  				<th width="80%">Биохожатхона</th>
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
					  				<th width="80%">
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
					  				<th width="80%">
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
					  				<th width="80%">
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
					  				<th width="80%">
					  					Бекатларни эълон қилиш аудио тизими
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
					qty_reys:'',
					hours_rule:0,
				},
				car:{
					auto_number:'',
					bustype_id:'',
					busmodel_id:'',
					tclass_id:'',
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
				file:'',
				files:[],
				cars_with:[],
				findList:[],
				direction_ids:[],
				lots:[],
				requiredInput:false,
				showBtn:Number,
				isLoading:false,
				newItems:[],
				showDirections:false,
			}
		},
		computed:{
			...mapGetters('direction',['getDirectionFindList']),
			...mapGetters('application',['getMassage','getApplication']),
			...mapGetters('typeofbus',['getTypeofbusList']),
			...mapGetters('busmodel',['getBusmodelList']),
			...mapGetters('busclass',['getBusclassFindList']),
    		...mapGetters("busbrand", ["getBusBrandList"]),
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
						this.files = this.getApplication.attachment
					}
				}
			}
		},
		async mounted(){
			await this.actionEditApplication(this.$route.params.userapplicationId)
			await this.actionTypeofbusList()
			await this.actionBusmodelList()
			await this.actionBusBrandList()
			this.form = this.getApplication
			this.cars_with = this.getApplication.cars_with
			this.files = this.getApplication.attachment
			this.direction_ids = this.getApplication.tender.direction_ids
			this.lots = this.getApplication.tender.tenderlots
		},
		methods:{
			...mapActions('application',[
				'actionEditApplication',
				'actionUpdateApplication',
				'actionAddCar',
				'actionAddFile',
				'actionRemoveFile',
				'actionRemoveCar',
			]),
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList']),
			...mapActions('direction',['actionDirectionFind']),
			...mapActions('busclass',['actionBusclassFind']),
			...mapActions("busbrand", ["actionBusBrandList"]),
			activeEditClass(lots,id){
		    	let lot_list = lots.reys_id
				if (lots.status == 'all') {
					return true
				}
				else{
			    	if (lot_list.length > 0) {
			    		if (lot_list.includes(id)) {
			    			return true
			    		}
			    	}
				}
		    },
		    changePhoto(event) {
		      this.file = event.target.files[0];
		      // let file = event.target.files[0];
		      // if (
		      //   event.target.files[0]["type"] === "image/png" ||
		      //   event.target.files[0]["type"] === "image/jpeg" ||
		      //   event.target.files[0]["type"] === "image/jpg"
		      // ) {
		      //   if (file.size > 1048576) {
		      //     swal.fire({
		      //       type: "error",
		      //       title: "Ошибка",
		      //       text: "Размер изображения больше лимита"
		      //     });
		      //   } else {
		      //     let reader = new FileReader();
		      //     reader.onload = event => {
		      //       this.file = event.target.result;
		      //     };
		      //     reader.readAsDataURL(file);
		      //   }
		      // } else {
		      //   swal.fire({
		      //     type: "error",
		      //     title: "Ошибка",
		      //     text: "Картинка должна быть только png,jpg,jpeg!"
		      //   });
		      // }
		    },
		    async addFile(){
		    	let formData = new FormData();
				formData.append('file', this.file);
				formData.append('app_id', this.$route.params.userapplicationId);
				await this.actionAddFile(formData)
				if(this.getMassage.success){
					toast.fire({
			            type: "success",
			            icon: "success",
			            title: this.getMassage.message
		          	});
		          	this.file = ''
					await this.actionEditApplication(this.$route.params.userapplicationId)
				}
		    },
		    async removeFile(id){
		    	if(confirm("Вы действительно хотите удалить?")){
			    	await this.actionRemoveFile(id);
			    	if(this.getMassage.success){
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
			          	});
						await this.actionEditApplication(this.$route.params.userapplicationId)
					}
		    	}
		    },
			showTable(index){
                if(this.showBtn == index){
                    this.showBtn = Number
                }else{
                    this.showBtn = index
                }
			},
			defaultValuesOfCar(){
				this.car.auto_number = ''
		    	this.car.bustype_id = ''
		    	this.car.busmodel_id = ''
		    	this.car.tclass_id = ''
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
		    	if (this.car.auto_number != '' && this.car.bustype_id != '' && this.car.busmodel_id != '' && this.car.tclass_id != '' && this.car.capacity != '' && this.car.seat_qty != '' && this.car.date != '')
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
		    	let check = true
		    	if (this.form.hours_rule == 1) {
		    		if (this.files.length > 0) {
		    			check = true
		    		}else{
		    			check = false
		    		}
		    	}
		    	if (check) {
			    	await this.actionUpdateApplication(this.form)
			    	if(this.getMassage.success){
			    		toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
			          	});
			    		await this.actionEditApplication(this.$route.params.userapplicationId)
			    	}
		    	}else{
		    		toast.fire({
			            type: "error",
			            icon: "error",
			            title: 'Загрузите файл!'
		          	});
		    	}
		    },
		    async deleteCar(id){
		    	if(confirm("Вы действительно хотите удалить?")){
			    	await this.actionRemoveCar(id);
			    	if(this.getMassage.success){
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
			          	});
						await this.actionEditApplication(this.$route.params.userapplicationId)
					}
		    	}
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
	.road_price{
    	width: 84px;
	}
	.app_title{
		width:75%;
		text-align: center;
	}
</style>
