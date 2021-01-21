<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    Отправить заявку
				</h4>
                <h4 class="title_user">{{ form.tender ?  form.tender.direction_ids[0].name : '' }}</h4>
				<div class="d-flex">
					<span class="qr_code" @click.prevent="openQrcode" v-if="makeDisabled">
						<i class="fas fa-qrcode"></i>
					</span>
					<router-link class="btn btn-primary back_btn" to="/crm/application">
						<span class="peIcon pe-7s-back"></span>
						Назад
					</router-link>
				</div>
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
						    	:disabled="makeDisabled"
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
						    	:disabled="makeDisabled"
					    	>
					  	</div>
				  	  	<div class="form-group col-md-2 btn_save d-flex justify-content-end" v-if="!makeDisabled">
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
							  			<h3><em>{{index+1}})</em> <strong>Маршрут</strong>: <em>{{items.name}}</em></h3>
						  		    	<template>
								  		    <li class="mb-2">
								  		    	<h4><em>Со стороны:</em>  <b>{{items.reysesFrom[0].where.name}}</b></h4>
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
											  				:class="activeEditClass(reys) ? 'active' : ''"
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
								  		    	<h4><em>Со стороны:</em>  <b>{{items.reysesTo[0].where.name}}</b></h4>
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
											  				:class="activeEditClass(reys) ? 'active' : ''"
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
						  		    	<hr>
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
						  						:disabled="makeDisabled"
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
						  						:disabled="makeDisabled"
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
						  						:disabled="makeDisabled"
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
						  						:disabled="makeDisabled"
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
						  						:disabled="makeDisabled"
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
										<th>Класс Авто</th>
										<th>Марка Авто</th>
										<th>Модель Авто</th>
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
											<td>{{car.tclass.name}}</td>
											<td>{{car.busmarka ? car.busmarka.name : ''}}</td>
											<td>{{car.busmodel ? car.busmodel.name : '' }}</td>
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
					  	<div class="form-group col-lg-12 d-flex justify-content-end align-items-end" v-if="!makeDisabled">
                            <div class="form-group col-md-3 mb-0">
                                <label>Muddat</label>
                                <select  class="form-control"  v-model="form.time" >
                                    <option selected value="1">1 йил</option>
                                    <option value="2">2 йил</option>
                                    <option value="3">3 йил</option>
                                    <option value="4">4 йил</option>
                                    <option value="5">5 йил</option>
                                </select>
                            </div>
						  	<button type="button" class="btn btn-secondary mr-3" @click.prevent="saveData">
						  		<i class="fas fa-save"></i>
							  	Сохранить
							</button>
						  	<button type="button" class="btn btn-primary btn_save_category" @click.prevent="activate">
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
					    	v-mask="'********'"
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
					    >
					    	<option value="" selected disabled>Выберите категорию авто!</option>
					    	<option
					    		:value="busType.id"
					    		v-for="(busType,index) in getTypeofbusList"
					    		data-toggle="tooltip" data-placement="right" title="Tooltip on right"
				    		>{{busType.name}}</option>
					    </select>
					    <!-- @change="selectClass(car.bustype_id)" -->
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="busmarka_id">Марка Авто</label>
					    <select
						    class="form-control input_style"
					    	id="busmarka_id"
					    	placeholder="Номер Авто"
					    	v-model="car.busmarka_id"
					    	:class="isRequired(car.busmarka_id) ? 'isRequired' : ''"
					    	@change="selectCarMarka()"
					    >
					    	<option value="" selected disabled>Выберите марку авто!</option>
					    	<!-- <option :value="item.marka.id" v-for="(item,index) in getBusBrandList">{{item.marka.name}}</option> -->
					    	<option :value="item.id" v-for="(item,index) in getBusBrandList">{{item.name}}</option>
					    </select>
                        <!-- @change="selectModel(car.busmarka_id)" -->
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="busmodel_id">Модель Авто</label>
					    <select
						    class="form-control input_style"
					    	id="busmodel_id"
					    	placeholder="Номер Авто"
					    	v-model="car.busmodel_id"
					    	:class="isRequired(car.busmodel_id) ? 'isRequired' : ''"
					    >
					    	<option value="" selected disabled>Выберите модель авто!</option>
					    	<!-- <option :value="item.model.id" v-for="(item,index) in bus_models">{{item.model.name}}</option> -->
					    	<option :value="item.id" v-for="(item,index) in getBusmodelList">{{item.name}}</option>
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
					    	<option :value="busClass.id" v-for="(busClass,index) in tclasses">{{busClass.name}}</option>
					    </select>
					    	<!-- @change="selectMarka(car.tclass_id)" -->
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="date">Дата выпуска</label>
					    <date-picker
		                  lang="ru"
		                  type="year"
		                  placeholder="Дата выпуска"
		                  v-model="car.date"
		                  valueType="format"
		                  class="input_style"
		                  :class="isRequired(car.date) ? 'isRequired' : ''"
		                ></date-picker>
				  	</div>
				  	<div class="form-group col-md-3">
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
				    <div class="col-md-12">
			    		<div class="row">
			    			<div class="form-group col-md-2">
			    				<label for="owner">Хозяин</label>
		    					<input
			  						type="radio"
			  						name="gps"
			  						value="owner"
			  						id="owner"
			  						v-model="car.owner_type"
		  						>
			    			</div>
			    			<div class="form-group col-md-2">
			    				<label for="rent">Аренда</label>
		    					<input
			  						type="radio"
			  						name="gps"
			  						value="rent"
			  						id="rent"
			  						v-model="car.owner_type"
		  						>
			    			</div>
			    		</div>
				    </div>
				    <div class="col-md-12" v-if="car.owner_type == 'owner'">
				    	<div class="row">
				    		<div class="form-group col-md-6">
							    <label for="pTexpassportSery">Серия техпаспорта</label>
							    <input
							    	type="text"
							    	class="form-control input_style"
							    	id="pTexpassportSery"
							    	placeholder="Серия техпаспорта"
							    	v-model="car.pTexpassportSery"
							    	:class="isRequired(car.pTexpassportSery) ? 'isRequired' : ''"
						    	>
						  	</div>
				    		<div class="form-group col-md-6">
							    <label for="pTexpassportNumber">Номер техпаспорта</label>
							    <input
							    	type="number"
							    	class="form-control input_style"
							    	id="pTexpassportNumber"
							    	placeholder="Номер техпаспорта"
							    	v-model="car.pTexpassportNumber"
							    	:class="isRequired(car.pTexpassportNumber) ? 'isRequired' : ''"
						    	>
						  	</div>
					  	</div>
			    	</div>
				    <div class="col-md-12" v-if="car.owner_type == 'rent'">
				    	<div class="row">
				    		<div class="form-group col-md-6">
							    <label for="pNumberNatarius">Номер реестра нотариального действия</label>
							    <input
							    	type="text"
							    	class="form-control input_style"
							    	id="pNumberNatarius"
							    	placeholder="Номер реестра..."
							    	v-model="car.pNumberNatarius"
							    	:class="isRequired(car.pNumberNatarius) ? 'isRequired' : ''"
						    	>
						  	</div>
				    		<div class="form-group col-md-6">
							    <label for="pDateNatarius">Дата нотариального действия</label>
							    <date-picker
				                  lang="ru"
				                  type="date"
				                  placeholder="Дата выпуска"
				                  v-model="car.pDateNatarius"
				                  valueType="format"
				                  class="input_style"
				                  :class="isRequired(car.pDateNatarius) ? 'isRequired' : ''"
				                ></date-picker>
						  	</div>
				    	</div>
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
		<!-- QRCODE Modal -->
		<div class="modal fade" id="qrcodeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-dialog-centered">
			    <div class="modal-content">
		      		<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
		      		</div>
		      		<div class="modal-body d-flex justify-content-center">
		      		 	<div class="qr_code_modal">
			      		 	<h4><b>Ваша заявка принята!</b></h4>
			      		 	<div>
			      		 		<b>Номер заявки №</b> {{form.id}}
			      		 	</div>
			      		 	<div>
			      		 		<b>Дата тендера:</b> {{form.tender ? $g.getDate(form.tender.time) : ''}}
			      		 	</div>
			      		 	<div>
			      		 		<b>Адрес:</b> {{form.tender ? form.tender.address : ''}}
			      		 	</div>
			      		 	<div>
			      		 		<b>Время тендера:</b> {{form.tender ? $g.getTime(form.tender.time) : ''}}
			      		 	</div>
			      		 	<img :src="'/'+form.qr_code" alt="">
	      		 		</div>
	      	  		</div>
	      	  	</div>
	  	  	</div>
  	  	</div>
	</div>
</template>
<script>
	import DatePicker from "vue2-datepicker";
	import { mapGetters , mapActions } from 'vuex'
	import Multiselect from 'vue-multiselect';
	export default{
		components:{
			Multiselect,
			DatePicker,
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
                    time:'',
				},
				car:{
                    app_id: null,
					bustype_id:'',
					busmarka_id:'',
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
					station_announce:0,
					owner_type:'owner',
					pNumberNatarius:'',
					pDateNatarius:'',
					pTexpassportSery:'',
				  	pTexpassportNumber:'',
				   	auto_number:'',
				},
				tclasses:[],
				bus_marks:[],
				bus_models:[],
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
				makeDisabled:false
			}
		},
		computed:{
			...mapGetters('direction',['getDirectionFindList']),
			...mapGetters('application',[
				'getMassage',
				'getApplication',
				'getGaiVehicle',
				'getAdliya',
				'getActivate',
			]),
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
						this.form = this.getApplication
						this.direction_ids = this.getApplication.tender.direction_ids
						this.lots = this.getApplication.tender.tenderlots
						if (this.getApplication.qr_code){
				          this.makeDisabled = true
						}else{
				          this.makeDisabled = false
						}
					}
				}
			},
			getBusclassFindList:{
				handler(){
					this.tclasses = this.getBusclassFindList
				}
			},
			'car.owner_type':{
				handler(){
					if (this.car.owner_type == 'owner') {
						this.car.pNumberNatarius=''
						this.car.pDateNatarius=''
					}else if(this.car.owner_type == 'rent'){
						this.car.pTexpassportSery=''
						this.car.pTexpassportNumber=''
					}
				}
			},deep:true,
			'car.auto_number':{
				handler(){
					if (this.car.auto_number.length > 8) {
			          this.car.auto_number = this.car.auto_number.slice(0,8)
			        }
				}
			},deep:true,
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
            this.car.app_id = this.$route.params.userapplicationId;
		},
		methods:{
			...mapActions('application',[
				'actionEditApplication',
				'actionUpdateApplication',
				'actionAddCar',
				'actionAddFile',
				'actionRemoveFile',
				'actionRemoveCar',
				'actionGaiVehicle',
				'actionAdliya',
				'actionActivate',
			]),
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList', 'actionBusmodelListByBrand']),
			...mapActions('direction',['actionDirectionFind']),
			...mapActions('busclass',['actionBusclassFind']),
			...mapActions("busbrand",["actionBusBrandList"]),
			openQrcode(){
				$('#qrcodeModal').modal('show')
			},
			async activate(){
				await this.actionActivate(this.$route.params.userapplicationId)
				if (this.getActivate.success){
					await this.actionEditApplication(this.$route.params.userapplicationId)
					await this.openQrcode()
				}
			},
			activeEditClass(item){
		    	if (item.status == 'active'){
	    			return 'edit-active'
		    	}else{
		    		return 'edit-pending'
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
				this.car.app_id = this.$route.params.userapplicationId
		    	this.car.bustype_id = ''
		    	this.car.tclass_id = ''
		    	this.car.busmarka_id = ''
		    	this.car.busmodel_id = ''
		    	this.car.date = ''
		    	this.car.capacity = ''
		    	this.car.seat_qty = ''
		    	this.car.conditioner = 0
		    	this.car.internet = 0
		    	this.car.bio_toilet = 0
		    	this.car.bus_adapted = 0
		    	this.car.telephone_power = 0
		    	this.car.monitor = 0
		    	this.car.station_announce = 0
		    	this.car.owner_type='owner'
				this.car.pNumberNatarius=''
				this.car.pDateNatarius=''
				this.car.pTexpassportSery=''
				this.car.pTexpassportNumber=''
				this.car.auto_number=''
		    	this.requiredInput = false
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
		    async selectClass(bustype_id){
		    	this.car.tclass_id = ''
		    	this.car.busmarka_id = ''
		    	this.car.busmodel_id = ''
		    	if (bustype_id) {
		    		let data = {
		    			'bustype_id':bustype_id,
		    		}
			    	await this.actionBusclassFind(data)
			    	this.tclasses = this.getBusclassFindList
		    	}
		    },
		    async selectMarka(tclass_id){
		    	this.car.busmarka_id = ''
		    	this.car.busmodel_id = ''
		    	this.bus_marks = this.tclasses.filter((item,index)=>{
		    		if (item.id == tclass_id) {
		    			return item
		    		}
		    	})
		    },
		    async selectModel(marka_id){
		    	this.car.busmodel_id = ''
		    	this.bus_models = this.bus_marks.filter((item,index)=>{
		    		if (item.marka.id == marka_id) {
		    			return item
		    		}
		    	})
		    },
		    async addCar(){
		    	if (
	    			this.car.bustype_id != '' &&
	    			this.car.tclass_id != '' &&
	    			this.car.busmarka_id != '' &&
	    			this.car.busmodel_id != '' &&
	    			this.car.date != '' &&
	    			this.car.capacity != '' &&
	    			this.car.seat_qty != ''
    			)
		    	{
		    		if (this.car.owner_type == 'owner'){
                        this.car.app_id = this.$route.params.userapplicationId
			    		await this.actionGaiVehicle(this.car)
		    		}else if(this.car.owner_type == 'rent'){
		    			if (this.car.pDateNatarius != '' && this.car.pNumberNatarius != '') {
			    			let car = {
			    				'pDateNatarius':this.car.pDateNatarius,
			    				'pNumberNatarius':this.car.pNumberNatarius,
			    				'auto_number':this.car.auto_number,
			    			}
			    			let data = {
			    				'cars':car,
			    				'app_id':this.$route.params.userapplicationId,
			    			}
				    		await this.actionAdliya(data)
				    		this.requiredInput = false
		    			}else{
		    				this.requiredInput = true
		    			}
		    		}
		    		if (this.getMassage.success){
						this.car['app_id'] = this.$route.params.userapplicationId
				    	await this.actionAddCar(this.car)
				    	if(this.getMassage.success){
					    	await this.actionEditApplication(this.$route.params.userapplicationId)
				    		toast.fire({
					            type: "success",
					            icon: "success",
					            title: this.getMassage.message
				          	});
					    	$('#myModal').modal('hide')
				    	}else{
				    		toast.fire({
					            type: "success",
					            icon: "success",
					            title: this.getMassage.message
				          	});
				    	}
			    		this.requiredInput = false
		    		}else{
		    			toast.fire({
				            type: "error",
				            icon: "error",
				            title: this.getMassage.message
			          	});
			          	this.requiredInput = true
		    		}
		    	}else{
		    		this.requiredInput = true
		    	}
		    },
		    async saveData(){
		    	let check = true
		    	if (this.form.hours_rule == 1){
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
		    async selectCarMarka(){
                await this.actionBusmodelListByBrand({busbrand_id: this.car.busmarka_id});
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
	.qr_code{
		font-size: 25px;
	    color: black;
	    border: 1px solid black;
	    margin-right: 30px;
	    padding: 0px 9px;
	    cursor: pointer;
	}
	.qr_code_modal{
		border: 1px solid black;
	    width: 100%;
	    padding: 20px;
	    text-align:center;
	}
</style>
