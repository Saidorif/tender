<template>
	<div class="add_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    {{$t('Qoʼshish')}} объявление тендера
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/tenderannounce">
					<span class="peIcon pe-7s-back"></span>
					{{$t('Orqaga')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<div class="alert alert-danger" v-for="(error,index) in errors" v-if="errors.length > 0">
		  			{{error}}
		  		</div>

		  		<div class="alert alert-danger" v-if="errorMessage != ''">
		  			{{errorMessage}}
		  		</div>
		  		<form @submit.prevent.enter="saveTender" >
					<div class="row">
					  <div class="form-group col-md-4">
					    <label for="name">{{$t('Tender sanasi')}}</label>
					    <date-picker
		                  id="time"
		                  lang="ru"
		                  type="datetime"
		                  v-model="form.time"
		                  valueType="format"
		                  class="input_style"
		                  :class="isRequired(form.time) ? 'isRequired' : ''"
		                ></date-picker>
					  </div>
					  <div class="form-group col-md-4">
					    <label for="address">{{$t('Manzil')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	v-model="form.address"
					    	id="address"
					    	:class="isRequired(form.address) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-lg-4 form_btn d-flex justify-content-end">
 						<button type="button" class="btn btn-secondary mr-3" @click="openModal">
							<i class="fas fa-plus"></i>
							{{$t('Qoʼshish')}} лот
						</button>
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	{{$t('Saqlash')}}
						</button>
				  	  </div>
					</div>
				</form>
				<!-- all choosen lots -->
		  		<div class="table-responsive" v-if="allLotes.length > 0">
			  		<div class="d-flex justify-content-center">
			  			<h4>{{$t('Lotlar')}}</h4>
			  		</div>
				  	<div class="choosenItemsTable" v-for="(lots,lot_key) in allLotes">
				  		<div class="d-flex">
					  		<h4 class="lot_n"><em>Лот №</em> {{lot_key+1}}</h4>
					  		<i class="fas fa-trash text-danger lot_remove" @click.prevent="removeLot(lot_key)"></i>
				  		</div>
				  		<ul v-for="(item,index) in lots">
				  		    <li>
				  		    	<div class="d-flex align-items-center">
					  		    	<h4>{{index+1}})</h4>
					  		    	<button class="btn btn-outline-success mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index" aria-expanded="false" :aria-controls="'collapseExample'+index">
					  		    		<template v-if="item.reyses.length > 0">
										    <span>{{item.reyses[0].where.name}}дан - {{item.reyses[0].from.name}}га</span>
										    <span>({{item.reyses.length}} рейсы)</span>
					  		    		</template>
					  		    		<template v-else>
					  		    			<span>{{item.directions.name}}</span>
					  		    		</template>
								  	</button>
                                    <router-link
                                        target="_blank"
                                        class="btn btn-success mr-2"
                                        :to='`/crm/direction/edit/${item.directions.id}`'
                                        v-if="$can('edit', 'DirectionController')"
                                    >
                                        <i class="pe_icon far fa-eye"></i>
                                    </router-link>
                                    <button class="btn btn-danger" @click.prevent="removeDir(lot_key, index)">
                                        <i class="pe_icon fas fa-trash" ></i>
                                    </button>
				  		    	</div>
							  	<div class="collapse" :id="'collapseExample'+index" v-if="item.reyses.length > 0">
								  	<table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
                                                <th  scope="col"  :colspan="item.reyses[0].reys_times.length * 2" style="text-align: center;">
                                                	{{item.reyses[0].where.name}} {{$t('tomondan')}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2" v-for="(item, index) in item.reyses[0].reys_times" style="text-align: center;">
                                                    {{item.where.name}}
                                                </th>
                                            </tr>
                                            <tr >
                                                <template v-for="(item, index) in item.reyses[0].reys_times">
                                                    <th style="text-align: center;" >{{$t('Kelish')}}</th>
                                                    <th style="text-align: center;">{{$t('Chiqish')}}</th>
                                                </template>
                                            </tr>
                                        </thead>
								  		<tbody>
								  			<tr v-for="(reys,key) in item.reyses">
								  				<td>{{key+1}}</td>
								  				<template v-for="(val,key) in reys.reys_times">
									  				<td>{{val.end}}</td>
									  				<td>{{val.start}}</td>
								  				</template>
								  			</tr>
								  		</tbody>
								  	</table>
								</div>
				  			</li>
				  		</ul>
				  		<hr>
				  	</div>
                </div>
		  	</div>
	  	</div>
	  	<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Новый лот</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
	        	<div class="row">
	        		<div class="form-group col-md-2 check_box_with_label">
					    <label for="checked">Пакет</label>
					    <input
					    	type="checkbox"
					    	class="input_style"
					    	v-model="checked"
					    	id="checked"
				    	>

				  	</div>
				  	<div class="form-group col-md-5">
					    <label for="marshrut">Маршрут</label>
					    <multiselect
							:value="direction_ids"
							:options="findList"
							@search-change="value => findDirection(value)"
							v-model="direction_ids"
	                        placeholder="Выберите маршрут"
	                        :searchable="true"
	                        track-by="id"
	                        label="name"
                            :custom-label="customLabel"
	                        :max="3"
							:loading="isLoading"
							:selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
							:deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
							:option="[{name: 'Otash', id: 1}]"
							@select="dispatchAction"
							@remove="removeDirect"
							>
							<span slot="noResult">{{$t('Sizning qidirgan maʼlumot topilmadi.')}}</span>
							<span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
                            <template slot="option" slot-scope="props">
                                <table class="table table-bordered" style="margin:0;padding:0px;">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width:50px;">Рақами</th>
                                            <th scope="col" style="width:100px;">Номи</th>
                                            <!-- <th scope="col"  style="width:50px;">Очилган санаси</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width:50px;">{{props.option.pass_number}}</td>
                                            <td>{{props.option.name}}</td>
                                            <!-- <td>{{props.option.year}}</td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
						</multiselect>
				  	</div>
				  	<div class="form-group col-md-2 check_box_with_label" v-if="direction_ids && Object.keys(direction_ids).length > 0">
					    <label for="checkedGrafik">График</label>
					    <input
					    	type="checkbox"
					    	class="input_style"
					    	v-model="checkedGrafik"
					    	id="checkedGrafik"
				    	>
				  	</div>
				  	<div class="form-group col-md-3 d-flex align-items-center mt-4">
			    	 	<button type="button" class="btn btn-outline-success" @click.prevent="addToAllItems">
				        	<i class="fas fa-plus"></i>
				        	Выбрать маршрут
				        </button>
				  	</div>
	        	</div>
	        	<!-- From Name -->
				<div v-if="checkedGrafik">
				  	<div class="table-responsive" v-if="fromItems.length">
					  	<table class="table table-bordered">
                            <thead>
								<tr>
									<th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
									<th  scope="col"  class="headar_th" :colspan="fromFirstItems.reys_times.length * 2" style="text-align: center;cursor:pointer;" :class="{'selected': this.choosenFromItems.length}" @click.prevent="chooseFromSide(fromItems)">{{fromName}} {{$t('tomondan')}}  </th>
								</tr>
                                <tr>
                                    <th colspan="2" v-for="(item, index) in fromFirstItems.reys_times" style="text-align: center;">
                                        {{item.where.name}}
                                    </th>
                                </tr>
                                <tr >
                                    <template v-for="(item, index) in fromFirstItems.reys_times">
                                        <th style="text-align: center;" >{{$t('Kelish')}}</th>
                                        <th style="text-align: center;">{{$t('Chiqish')}}</th>
                                    </template>
                                </tr>
				  			</thead>
					  		<tbody>
					  			<tr
					  				v-for="(items,index) in fromItems"
					  				:class="activeFromClass(items)"
				  				>
					  				<td>
					  					<label>
				  							{{index+1}}
				  						</label>
					  				</td>
					  				<template v-for="(item,key) in items.reys_times">
						  				<td>{{item.end}}</td>
						  				<td>{{item.start}}</td>
					  				</template>
					  			</tr>
					  		</tbody>
					  	</table>
				  	</div>
				  	<!-- To Name -->
				  	<div class="table-responsive" v-if="fromItems.length">
					  	<table class="table table-bordered">
                          	<thead>
								<tr>
									<th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar ss</th>
									<th  scope="col"  :colspan="toFirstItems.reys_times.length * 2" style="text-align: center;cursor:pointer;"   class="headar_th" :class="{'selected': this.choosenToItems.length}" @click.prevent="chooseToSide(toItems)">{{toName}} {{$t('tomondan')}} </th>
								</tr>
                                <tr>
                                    <th colspan="2" v-for="(item, index) in toFirstItems.reys_times" style="text-align: center;">
                                        {{item.where.name}}
                                    </th>
                                </tr>
                                <tr >
                                    <template v-for="(item, index) in toFirstItems.reys_times">
                                        <th style="text-align: center;" >{{$t('Kelish')}}</th>
                                        <th style="text-align: center;">{{$t('Chiqish')}}</th>
                                    </template>
                                </tr>
				  			</thead>
					  		<tbody>
					  			<tr
					  				v-for="(items,index) in  toItems"
					  				:class="activeToClass(items)"
				  				>
					  				<td>
					  					<label>
				  							{{index+1}}
				  						</label>
					  				</td>
					  				<template v-for="(item,key) in items.reys_times">
						  				<td>{{item.end}}</td>
						  				<td>{{item.start}}</td>
					  				</template>
					  			</tr>
					  		</tbody>
					  	</table>
				  	</div>
				</div>
			  	<!-- All choosen tables -->
			  	<div class="table-responsive" v-if="allItems.length > 0">
			  		<div class="d-flex justify-content-center">
			  			<h4>Выбранные маршруты</h4>
			  		</div>
				  	<div class="choosenItemsTable">
				  		<ul v-for="(item,index) in allItems">
				  		    <li>
				  		    	<div class="d-flex align-items-center">
					  		    	<h4>{{index+1}})</h4>
					  		    	<button class="btn btn-outline-success mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index" aria-expanded="false" :aria-controls="'collapseExample'+index">
					  		    		<template v-if="item.reyses.length > 0">
										    <span>{{item.reyses[0].where.name}} - {{item.reyses[0].from.name}}</span>
										    <span>({{item.reyses.length}} рейсы)</span>
					  		    		</template>
					  		    		<template v-else>
					  		    			<span>{{item.directions.name}}</span>
					  		    		</template>
								  	</button>
								  	<button type="button" class="btn btn-danger" @click.prevent="removeFromAllItems(index)">
								  		<i class="fas fa-trash"></i>
								  	</button>
				  		    	</div>
							  	<div class="collapse" :id="'collapseExample'+index" v-if="item.reyses.length > 0">
								  <table class="table table-bordered table-hover">
                                        <thead>
                                                <tr>
                                                    <th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
                                                    <th  scope="col"  :colspan="item.reyses[0].reys_times.length * 2" style="text-align: center;">{{item.reyses[0].where.name}} {{$t('tomondan')}} </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" v-for="(item, index) in item.reyses[0].reys_times" style="text-align: center;">
                                                        {{item.where.name}}
                                                    </th>
                                                </tr>
                                                <tr >
                                                    <template v-for="(item, index) in item.reyses[0].reys_times">
                                                        <th style="text-align: center;" >{{$t('Kelish')}}</th>
                                                        <th style="text-align: center;">{{$t('Chiqish')}}</th>
                                                    </template>
                                                </tr>
                                        </thead>
								  		<tbody>
								  			<tr v-for="(reys,key) in item.reyses">
								  				<td>{{key+1}}</td>
								  				<template v-for="(val,key) in reys.reys_times">
									  				<td>{{val.end}}</td>
									  				<td>{{val.start}}</td>
								  				</template>
								  			</tr>
								  		</tbody>
								  	</table>
								</div>
				  			</li>
				  		</ul>
				  	</div>
			  	</div>

			  	<!-- text -->
			  	<div class="form-group" v-if="allItems.length > 0">
					<label class="form-control-label" for="text">Примечание</label>
				  	<textarea class="form-control" id="text" v-model="text"></textarea>
			  	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-warning" data-dismiss="modal">
		        	<i class="fas fa-times"></i>
		        	{{$t('Yopish')}}
		        </button>
		        <button type="button" class="btn btn-primary" @click.prevent="addLot">
		        	<i class="fas fa-plus"></i>
		        	{{$t('Qoʼshish')}} в список
		        </button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- Modal -->
	</div>
</template>
<script>
	import DatePicker from "vue2-datepicker";
	import Multiselect from 'vue-multiselect';
	import Loader from '../../Loader'
	import { mapGetters , mapActions } from 'vuex'
	export default{
		components: {
	    	DatePicker,
			Multiselect,
			Loader
	  	},
		data(){
			return{
				form:{
					direction_ids:[],
					time:'',
					address:'',
					type:'simple',
				},
				text:'',
				requiredInput:false,
				direction_ids:{},
				allLotes:[],
				checked:false,
				checkedGrafik:false,
				isLoading:false,
				allItems:[],
				fromName:'',
				fromItems:[],
				fromFirstItems:[],
				choosenFromItems:[],
				toName:'',
				toFirstItems:[],
				toItems:[],
				choosenToItems:[],
				findList:[],
				tableItems:[],
				errors:[],
				errorMessage:'',
				laoding: true
			}
		},
		computed:{
			...mapGetters('tenderannounce',['getMassage']),
			...mapGetters('direction',['getDirectionFindList']),
			...mapGetters("passportTab", ["getSchedule"]),
		},
		watch:{
			checked:{
				handler(){
					this.form.direction_ids=[]
					this.direction_ids={}
					this.findList = []
				}
			},
			direction_ids:{
				handler(){
					if (this.direction_ids != '' || this.direction_ids != null) {
						this.checkedGrafik = false
						this.fromName = ''
						this.choosenFromItems = []
						this.fromFirstItems = []
						this.fromItems = []
						this.toName = ''
						this.choosenToItems = []
						this.toFirstItems = []
						this.toItems = []
					}
				}
			}
		},
		mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('tenderannounce',['actionAddTenderAnnounce']),
			...mapActions('direction',['actionDirectionFind']),
			...mapActions("passportTab", [
		      "actionGetScheduleTable",
		    ]),
            customLabel ({ name, pass_number }) {
                if(name){
                    return `${name} – ${pass_number}`
                }
            },
		    addTextToAllItems(items){
		    	return items.map((item,index)=>{
		    		return {
		    			directions:item.directions,
		    			reyses:item.reyses,
		    			text:this.text,
		    		}
		    	})
		    },
		    addLot(){

		    	if (this.allItems.length > 0) {
			    	if (this.checked) {
			    		if (this.allItems.length > 1) {
			    			// if (this.text != '') {
			    			this.allLotes.push(this.addTextToAllItems(this.allItems))
				    		$('#myModal').modal('hide')
			    		// 	}else{
			    		// 		toast.fire({
									// type: "error",
									// icon: "error",
									// title: 'Введите примечание!'
							 	// });
			    		// 	}
			    		}else{
			    			toast.fire({
								type: "error",
								icon: "error",
								title: 'В пакете должны быть минимум 2 маршрута!'
						 	});
			    		}
			    	}else{
			    		if (this.allItems.length == 1) {
			    			// if (this.text != '') {
				    		this.allLotes.push(this.addTextToAllItems(this.allItems))
					    	$('#myModal').modal('hide')
			    		// 	}else{
			    		// 		toast.fire({
									// type: "error",
									// icon: "error",
									// title: 'Введите примечание!'
							 	// });
			    		// 	}
			    		}else{
			    			toast.fire({
								type: "error",
								icon: "error",
								title: 'Чтобы добавит болшее маршрутов откликните пакет!'
						 	});
			    		}
			    	}
		    	}
                console.log(this.allLotes)
		    },
		    defaultValuesOfCar(){
		    	this.choosenFromItems = []
	    		this.choosenToItems = []
	    		this.direction_ids = {}
	    		this.allItems = []
	    		this.form.direction_ids=[]
				this.findList = []
				this.text = ''
		    },
		    openModal(){
		    	$('#myModal').modal('show')
		    	this.defaultValuesOfCar()
		    },
		    removeLot(index){
		    	if(confirm("Вы действительно хотите удалить?")){
		    		Vue.delete(this.allLotes,index)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Удалено!',
				    })
				}
		    },
		    removeDirect(){
		    	this.form.direction_ids=[]
		    	this.direction_ids={}
				this.findList = []
		    },
            removeDir(dir_ind, ind){
                this.allLotes[dir_ind].splice(ind, 1);
            },
		    async dispatchAction(data){
				this.form.direction_ids = data.id;
				this.laoding = true
				await this.actionGetScheduleTable(data.id)
				this.laoding = false
				// From Items
				this.fromFirstItems = this.getSchedule ? this.getSchedule.whereFrom[0] : '';
				this.fromItems = this.getSchedule ? this.getSchedule.whereFrom : ''
				this.fromName = this.getSchedule ? this.getSchedule.whereFrom[0].where.name : ''
				// To Items
				this.toFirstItems = this.getSchedule ? this.getSchedule.whereTo[0] : ''
				this.toItems = this.getSchedule ? this.getSchedule.whereTo : ''
				this.toName = this.getSchedule ? this.getSchedule.whereTo[0].where.name : ''
		    },
		    readyItems(){
		    	if (this.direction_ids && Object.keys(this.direction_ids).length > 0){
			    	if(this.checkedGrafik){
			    		if (this.choosenFromItems.length > 0){
				    		let value = {
				    			directions:this.direction_ids,
				    			reyses:this.choosenFromItems,
				    		}
				    		this.allItems.push(value)
			    		}
			    		if (this.choosenToItems.length > 0){
				    		let value = {
				    			directions:this.direction_ids,
				    			reyses:this.choosenToItems,
				    		}
				    		this.allItems.push(value)
			    		}
			    		this.choosenFromItems = []
			    		this.choosenToItems = []
			    		this.direction_ids = {}
			    	}else{
			    		let value = {
			    			directions:this.direction_ids,
			    			reyses:[],
                        }
			    		let checkLot = true
			    		let checkItem = true
			    		this.allLotes.forEach((lots,index)=>{
			    			lots.forEach((lot,i)=>{
				    			if (lot.directions.id == value.directions.id && lot.reyses.length == 0 && value.reyses.length == 0) {
				    				checkLot = false
				    			}else{
				    				checkLot = true
				    			}
			    			})
			    		})
			    		this.allItems.forEach((item,index)=>{
			    			if (item.directions.id == value.directions.id && item.reyses.length == 0 && value.reyses.length == 0) {
			    				checkItem = false
			    			}else{
			    				checkItem = true
			    			}
			    		})
			    		if (!checkLot) {
			    			toast.fire({
						    	type: 'error',
						    	icon: 'error',
								title: 'В списке лот существует!',
						    })
			    		}else{
				    		if (checkItem){
			    				this.allItems.push(value)
				    		}else{
				    			toast.fire({
							    	type: 'error',
							    	icon: 'error',
									title: 'Этот маршрут уже выбрано!',
							    })
				    		}
			    		}
	    				this.choosenFromItems = []
			    		this.choosenToItems = []
			    		this.direction_ids = {}
			    	}
		    	}
		    },
		    addToAllItems(){
		    	if (this.checked) {
			    	this.readyItems()
		    	}else{
		    		if(this.allItems.length == 0){
		    			this.readyItems()
		    		}else{
		    			toast.fire({
					    	type: 'error',
					    	icon: 'error',
							title: 'Чтобы добавит болшее маршрутов откликните пакет!',
					    })
		    		}
		    	}
		    },
		    activeFromClass(item){
		    	if (item.status == 'active') {
			    	if (this.choosenFromItems.some(data => data.id === item.id)){
		    			return 'active'
			    	}else{
			    		return 'inactive'
			    	}
		    	}else{
		    		return 'pending'
		    	}
		    },
		    activeToClass(item){
		    	if (item.status == 'active') {
			    	if (this.choosenToItems.some(data => data.id === item.id)){
		    			return 'active'
			    	}
			    	else{
			    		return 'inactive'
			    	}
		    	}else{
		    		return 'pending'
		    	}
		    },
            chooseFromSide(items){
                if(this.choosenFromItems.length){
                    this.choosenFromItems = []
                }else{
                    items.forEach((item)=>{
                        this.choosenFromItems.push(item)
                    })
                }
            },
            chooseToSide(items){
                if(this.choosenToItems.length){
                    this.choosenToItems = []
                }else{
                    items.forEach((item)=>{
                        this.choosenToItems.push(item)
                    })
                }
            },
		    chooseFromItem(value,index){
		    	if (value.status == 'active') {
			    	if (this.choosenFromItems.some(data => data.id === value.id)){
				    	Vue.delete(this.choosenFromItems, index)
			    	}else{
				    	let new_arrays = [];
				    	if(this.allLotes.length > 0){
					    	this.allLotes.forEach((lots,lot_index)=>{
					    		lots.forEach((reys,reys_item)=>{
					    			reys.reyses.forEach((item,index)=>{
					    				new_arrays.push(item)
					    			})
					    		})
					    	})
					    	if (new_arrays.some(data => data.id === value.id && data.direction_id === value.direction_id)){
					    		toast.fire({
							    	type: 'error',
							    	icon: 'error',
									title: 'В списке тариф существует!',
							    })
					    	}else{
					    		this.choosenFromItems.push(value)
					    	}
				    	}else{
					    	this.choosenFromItems.push(value)
				    	}
			    	}
		    	}
		    },
		    chooseToItem(value,index){
		    	if (value.status == 'active') {
			    	if (this.choosenToItems.some(data => data.id === value.id)){
				    	Vue.delete(this.choosenToItems, index)
			    	}else{
				    	let new_arrays = [];
				    	if(this.allLotes.length > 0){
					    	this.allLotes.forEach((lots,lot_index)=>{
					    		lots.forEach((reys,reys_item)=>{
					    			reys.reyses.forEach((item,index)=>{
					    				new_arrays.push(item)
					    			})
					    		})
					    	})
					    	if (new_arrays.some(data => data.id === value.id && data.direction_id === value.direction_id)){
					    		toast.fire({
							    	type: 'error',
							    	icon: 'error',
									title: 'В списке тариф существует!',
							    })
					    	}else{
					    		this.choosenToItems.push(value)
					    	}
				    	}else{
					    	this.choosenToItems.push(value)
				    	}
			    	}
		    	}
		    },
			isRequired(input){
	    		return this.requiredInput && input === '';
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
		    removeFromAllItems(index){
		    	if(confirm("Вы действительно хотите удалить?")){
		    		Vue.delete(this.allItems,index)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Удалено!',
				    })
				}
		    },
			async saveTender(){
				let data = [];
				let lotItem = [];
				if (this.allLotes.length > 0){
					this.allLotes.forEach((lots,l)=>{
						lotItem = lots.map((item,index)=>{
							let direction_id = item.directions.id
							let reysItems = []
							if (item.reyses.length > 0){
								reysItems = item.reyses.map((i,k)=>{
									return i.id
								})
							}
							return{
								'direction_id':direction_id,
								'text':item.text,
								'reys_id':reysItems,
			    				'status':reysItems.length > 0 ? 'custom' : 'all',
							}
						})
						data.push(lotItem)
					})
				}
				let newData = {
					data:data,
					time:this.form.time,
					address:this.form.address,
				}
		    	if (this.form.time != '' && this.form.address != ''){
		    		this.laoding = true
					await this.actionAddTenderAnnounce(newData)
					this.laoding = false
					if (this.getMassage.success){
						toast.fire({
							type: "success",
							icon: "success",
							title: this.getMassage.message
					 	});
						this.requiredInput = false
						this.$router.push("/crm/tenderannounce");
					}else{
						if(this.errors.constructor.name === Array){
							this.errors = this.getMassage.message
						}else{
							this.errorMessage = this.getMassage.message
						}
					}
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
	tr.active,tr.inactive{
		cursor:pointer !important;
	}
	tr.active:hover,tr.inactive:hover{
		background:#d0d0d0 !important;
	}
	tr.active{
		background:#d6d6d6;
	}
	tr.pending{
		background:#8e8e8e;
		cursor:not-allowed !important;
	}
	.modal-xl {
	    max-width: 80%;
	}
	.modal-body{
		min-height:500px;
	}
	.lot_n{

	}
	.lot_remove{
	    margin-top: 2px;
	    margin-left: 60px;
	    cursor: pointer;
	    font-size: 20px;
	}

    .headar_th:hover,
    .selected{
        background: #c8d3f2 !important;
    }

</style>
