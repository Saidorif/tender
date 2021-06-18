<template>
	<div class="add_region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    Редактировать объявление тендера
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
		  		<form @submit.prevent.enter="saveTender">
					<div class="row">
					  <div class="form-group col-md-4">
					    <label for="name">Дата тердера</label>
					    <date-picker
		                  id="time"
		                  lang="ru"
		                  type="datetime"
		                  placeholder="Дата тердера"
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
				<!-- All edit choosen tables -->
	  			<div class="table-responsive" v-if="tenderlots.length > 0">
			  		<div class="d-flex justify-content-center">
			  			<h4>{{$t('Lotlar')}}</h4>
			  		</div>
		            <div class="card cardtender" v-for="(t_lots,t_index) in tenderlots">
		                <div class="card-header" >
		                        <h4 class="lot_n"><em>Лот №</em> {{t_index+1}}</h4>
		                        <div>
		                        <a href="#" class="btn btn-outline-danger"  @click.prevent="removeEditLot(t_lots.id)">
		                            <i class="fas fa-trash text-danger lot_remove"></i>
		                        </a>
		                        </div>

		                </div>
		                <div class="card-body">
		                    <template v-for="(items,index) in t_lots.direction_id" >
		                        <div class="mb-2">
			                        <div class="d-flex align-items-center justify-content-between">
			                            <h4>{{index+1}}) {{items.name}} <span v-if="getLengthReys(items, t_lots) > 0">({{getLengthReys(items, t_lots)}} рейс)</span></h4>

			                            <router-link :to='`/crm/stepuser/demand-tab/${items.id}`'  class="btn btn-outline-info">
			                                <i class="fas fa-eye"></i>
			                            </router-link>
			                        </div>
			                        <div>
			                        	<template v-if="items.reys_status.from">
				                            <h3>
				                            <span>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</span>
				                            </h3>
				                            <table class="table table-bordered" >
												<thead>
													<tr>
														<th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
														<th  scope="col"  :colspan="items.reysesFrom[0].reys_times.length * 2" style="text-align: center;">{{items.reysesFrom[0].where.name}} томондан  </th>
													</tr>
	                                                <tr>
	                                                    <th colspan="2" v-for="(item, index) in items.reysesFrom[0].stations" style="text-align: center;">
	                                                        {{ item.name }}
	                                                    </th>
	                                                </tr>
	                                                <tr >
	                                                    <template v-for="(item, index) in items.reysesFrom[0].reys_times">
	                                                        <th style="text-align: center;" >Прибытие</th>
	                                                        <th style="text-align: center;">Отправление</th>
	                                                    </template>
	                                                </tr>
					  							</thead>
					                            <tbody>
					                                <tr
					                                v-for="(reys,key) in items.reysesFrom"
					                                 v-if="showTabeleReys(reys, t_lots, items)"
					                                >
					                                <td style="text-align: center;">{{key+1}}</td>
					                                <template v-for="(val,key) in reys.reys_times">
					                                    <td style="text-align: center;">{{val.end}}</td>
					                                    <td style="text-align: center;">{{val.start}}</td>
					                                </template>
					                                </tr>
					                            </tbody>
				                            </table>
			                        	</template>
			                        	<template v-if="items.reys_status.to">
				                            <h3>
				                            	<span>{{items.reysesTo[0].where.name}} - {{items.reysesTo[0].from.name}}</span>
				                            </h3>
				                            <table class="table table-bordered" >
	                                            <thead>
													<tr>
														<th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
														<th  scope="col"  :colspan="items.reysesTo[0].reys_times.length * 2" style="text-align: center;">{{items.reysesTo[0].where.name}} томондан </th>
													</tr>
	                                                <tr>
	                                                    <th colspan="2" v-for="(item, index) in items.reysesTo[0].stations" style="text-align: center;">
	                                                        {{ item.name }}
	                                                    </th>
	                                                </tr>
	                                                <tr >
	                                                    <template v-for="(item, index) in items.reysesTo[0].reys_times">
	                                                        <th style="text-align: center;" >Прибытие</th>
	                                                        <th style="text-align: center;">Отправление</th>
	                                                    </template>
	                                                </tr>
					  							</thead>
					                            <tbody>
					                                <tr
					                                v-for="(reys,key) in items.reysesTo"
	                                                v-if="showTabeleReys(reys, t_lots, items)"
					                                >
					                                <td>{{key+1}}</td>
					                                <template v-for="(val,key) in reys.reys_times">
					                                    <td>{{val.end}}</td>
					                                    <td>{{val.start}}</td>
					                                </template>
					                                </tr>
					                            </tbody>
				                            </table>
			                        	</template>
			                        </div>
		                        </div>
		                    </template>
		                </div>
		            </div>
			  	</div>
			  	<!-- all choosen lots -->
		  		<div class="table-responsive" v-if="allLotes.length > 0">
			  		<div class="d-flex justify-content-center">
			  			<h4>Добавленные лоты</h4>
			  		</div>
				  	<div class="choosenItemsTable" v-for="(lots,lot_key) in allLotes">
				  		<div class="d-flex">
					  		<h4 class="lot_n"><em>№</em> {{lot_key+1}}</h4>
					  		<i class="fas fa-trash text-danger lot_remove" @click.prevent="removeLot(lot_key)"></i>
				  		</div>
				  		<ul v-for="(item,index) in lots">
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
				  		    	</div>
							  	<div class="collapse" :id="'collapseExample'+index" v-if="item.reyses.length > 0">
								  <table class="table table-bordered table-hover">
                                        <thead>
                                                <tr>
                                                    <th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
                                                    <th  scope="col"  :colspan="item.reyses[0].reys_times.length * 2" style="text-align: center;">{{item.reyses[0].where.name}} томондан </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" v-for="(item, index) in item.reyses[0].reys_times" style="text-align: center;">
                                                        {{item.where.name}}
                                                    </th>
                                                </tr>
                                                <tr >
                                                    <template v-for="(item, index) in item.reyses[0].reys_times">
                                                        <th style="text-align: center;" >Прибытие</th>
                                                        <th style="text-align: center;">Отправление</th>
                                                    </template>
                                                </tr>
                                        </thead>
								  		<tbody>
								  			<tr v-for="(reys,key) in item.reyses" >
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
									<th  scope="col"  :colspan="fromFirstItems.reys_times.length * 2" style="text-align: center;" class="headar_th" :class="{'selected': this.choosenFromItems.length}" @click.prevent="chooseFromSide(fromItems)">{{fromName}} томондан </th>
								</tr>
                                <tr>
                                    <th colspan="2" v-for="(item, index) in fromFirstItems.reys_times" style="text-align: center;">
                                        {{item.where.name}}
                                    </th>
                                </tr>
                                <tr >
                                    <template v-for="(item, index) in fromFirstItems.reys_times">
                                        <th style="text-align: center;" >Прибытие</th>
                                        <th style="text-align: center;">Отправление</th>
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
									<th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
									<th  scope="col"  :colspan="toFirstItems.reys_times.length * 2" style="text-align: center;"  class="headar_th" :class="{'selected': this.choosenToItems.length}" @click.prevent="chooseToSide(toItems)">{{toName}} томондан </th>
								</tr>
                                <tr>
                                    <th colspan="2" v-for="(item, index) in toFirstItems.reys_times" style="text-align: center;">
                                        {{item.where.name}}
                                    </th>
                                </tr>
                                <tr >
                                    <template v-for="(item, index) in toFirstItems.reys_times">
                                        <th style="text-align: center;" >Прибытие</th>
                                        <th style="text-align: center;">Отправление</th>
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
                                                    <th  scope="col"  :colspan="item.reyses[0].reys_times.length * 2" style="text-align: center;">{{item.reyses[0].where.name}} томондан </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" v-for="(item, index) in item.reyses[0].reys_times" style="text-align: center;">
                                                        {{item.where.name}}
                                                    </th>
                                                </tr>
                                                <tr >
                                                    <template v-for="(item, index) in item.reyses[0].reys_times">
                                                        <th style="text-align: center;" >Прибытие</th>
                                                        <th style="text-align: center;">Отправление</th>
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
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-warning" data-dismiss="modal">
		        	<i class="fas fa-times"></i>
		        	Закрыть
		        </button>
		        <button type="button" class="btn btn-primary" @click.prevent="addLot">
		        	<i class="fas fa-plus"></i>
		        	{{$t('Qoʼshish')}} в список
		        </button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</template>
<script>
	import DatePicker from "vue2-datepicker";
	import Multiselect from 'vue-multiselect';
    import { mapGetters , mapActions } from 'vuex'
    import Loader from '../../Loader'
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
				requiredInput:false,
				direction_ids:{},
				checked:false,
				checkedGrafik:false,
				isLoading:false,
				allLotes:[],
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
				edit_direction_ids:[],
				tenderlots:[],
                lots:[],
                errors:[],
                errorMessage:'',
                laoding: true,
			}
		},
		computed:{
			...mapGetters('tenderannounce',['getMassage','getTenderAnnounce']),
			...mapGetters('direction',['getDirectionFindList']),
			...mapGetters("passportTab", ["getSchedule"]),
		},
		watch:{
			getTenderAnnounce:{
				handler(){
					this.form.time = this.getTenderAnnounce.time
					this.form.address = this.getTenderAnnounce.address
					this.edit_direction_ids= this.getTenderAnnounce.direction_ids
					this.lots= this.getTenderAnnounce.tenderlots
					this.tenderlots= this.getTenderAnnounce.tenderlots
				}
			},
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
		async mounted(){
			await this.actionEditTenderAnnounce(this.$route.params.tenderannounceId)
			this.form.time = this.getTenderAnnounce.time
			this.form.address = this.getTenderAnnounce.address
			this.edit_direction_ids = this.getTenderAnnounce.direction_ids
			this.lots = this.getTenderAnnounce.tenderlots
            this.tenderlots = this.getTenderAnnounce.tenderlots
            this.laoding = false
		},
		methods:{
			...mapActions('tenderannounce',[
	 			'actionAddTenderAnnounce',
				'actionEditTenderAnnounce',
				'actionUpdateTenderAnnounce',
				'actionDeleteTenderAnnounceItem'
			]),
			...mapActions('direction',['actionDirectionFind']),
			...mapActions("passportTab", [
		      "actionGetScheduleTable",
		    ]),
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
								title: 'Чтобы добавить болшее маршрутов откликните пакет!'
						 	});
			    		}
			    	}
		    	}
		    },
		    async removeEditLot(id){
		    	if(confirm("Вы действительно хотите удалить?")){
		    		let data ={
		    			id :this.$route.params.tenderannounceId,
		    			lot_id:id
                    }
                    this.laoding = true
                    await this.actionDeleteTenderAnnounceItem(data)
		    		if(this.getMassage.success){
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
					    await this.actionEditTenderAnnounce(this.$route.params.tenderannounceId)
                    }
                    this.laoding = false
				}
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
		    removeDirect(){
		    	this.form.direction_ids=[]
		    	this.direction_ids={}
				this.findList = []
		    },
		    showTabeleReys(item, elem, parentItem){
                if(elem != undefined){
                    if(elem.reys_id.includes(item.id)){
                        parentItem['byreys'] = true
                        return true
                    }else{
                        return false
                    }
                }
            },
		    getLengthReys(reys, elem){
                let count = 0;
                if(reys.reys_status){
                    reys.reysesFrom.forEach((item,index)=>{
                        if(elem.reys_id.includes(item.id)){
                            count++
                        }
		    		})
		    		reys.reysesTo.forEach((item,index)=>{
                        if(elem.reys_id.includes(item.id)){
                            count++
                        }
		    		})
                }else{
		    		reys.reysesFrom.forEach((item,index)=>{
		    				count++
		    		})
		    		reys.reysesTo.forEach((item,index)=>{
		    				count++
		    		})
                }
		    	return count;
		    },
		    readyItems(){
		    	if (Object.keys(this.direction_ids).length > 0) {
			    	// if (this.checked) {
				    	if(this.checkedGrafik){
				    		if (this.choosenFromItems.length > 0){
					    		let value = {
					    			directions:this.direction_ids,
					    			reyses:this.choosenFromItems
					    		}
					    		this.allItems.push(value)
				    		}
				    		if (this.choosenToItems.length > 0){
					    		let value = {
					    			directions:this.direction_ids,
					    			reyses:this.choosenToItems
					    		}
					    		this.allItems.push(value)
				    		}
				    		this.choosenFromItems = []
				    		this.choosenToItems = []
				    		this.direction_ids = {}
				    	}else{
				    		let value = {
				    			directions:this.direction_ids,
				    			reyses:[]
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
			    	// }
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
							title: 'Чтобы добавить болшее маршрутов откликните пакет!',
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
			    	}else{
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
		    checkData(items){
		    	let new_arr = []
		    	items.forEach((item,index)=>{
					if (item.direction_id) {
			    		new_arr.push(item)
					}
				})
				return new_arr
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
		    async dispatchAction(data){
				this.form.direction_ids.push(data.id);
				this.laoding = true
				await this.actionGetScheduleTable(data.id)
				this.laoding = false
				// From Items
				this.fromFirstItems = this.getSchedule.whereFrom[0];
				this.fromItems = this.getSchedule.whereFrom
				this.fromName = this.getSchedule ? this.getSchedule.whereFrom[0].where.name : ''
				// To Items
				this.toFirstItems = this.getSchedule.whereTo[0]
				this.toItems = this.getSchedule.whereTo
				this.toName = this.getSchedule ? this.getSchedule.whereTo[0].where.name : ''
		    },
		    removeFromAllItems(index){
		    	Vue.delete(this.allItems,index)
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
				let newData = {}
				if (data.length > 0) {
					newData = {
						id:this.$route.params.tenderannounceId,
						data:data,
						time:this.form.time,
						address:this.form.address,
					}
				}else{
					newData = {
						id:this.$route.params.tenderannounceId,
						time:this.form.time,
						address:this.form.address,
					}
				}
		    	if (this.form.time != '' && this.form.address != ''){
		    		this.laoding = true
					await this.actionUpdateTenderAnnounce(newData)
					this.laoding = false
					if (this.getMassage.success) {
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
	    margin-right: 0;
	    cursor: pointer;
	    font-size: 16px;
	}
	tr.active,tr.inactive{
		cursor:pointer !important;
	}
	tr.active:hover,tr.inactive:hover{
		background:#d0d0d0 !important;
	}
	tr.active,tr.edit-pending{
		background:#d6d6d6;
	}
	tr.pending{
		background:#8e8e8e;
		cursor:not-allowed !important;
	}
	.check_box_with_label input{
		--active: #275EFE;
		--active-inner: #fff;
		--focus: 2px rgba(39, 94, 254, .3);
		--border: #BBC1E1;
		--border-hover: #275EFE;
		--background: #fff;
		--disabled: #F6F8FF;
		--disabled-inner: #E1E6F9;
		-webkit-appearance: none;
		-moz-appearance: none;
		height: 21px;
		outline: none;
		display: inline-block;
		vertical-align: top;
		position: relative;
		margin: 0;
		cursor: pointer;
		border: 1px solid var(--bc, var(--border));
		background: var(--b, var(--background));
		-webkit-transition: background .3s, border-color .3s, box-shadow .2s;
		transition: background .3s, border-color .3s, box-shadow .2s;
		width: 38px;
    	border-radius: 11px;
		min-height: unset;
	}
	.check_box_with_label input::after{
		content: '';
		display: block;
		position: absolute;
		-webkit-transition: opacity var(--d-o, 0.2s), -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
		transition: opacity var(--d-o, 0.2s), -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
		transition: transform var(--d-t, 0.3s) var(--d-t-e, ease), opacity var(--d-o, 0.2s);
		transition: transform var(--d-t, 0.3s) var(--d-t-e, ease), opacity var(--d-o, 0.2s), -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
		left: 2px;
		top: 2px;
		border-radius: 50%;
		width: 15px;
		height: 15px;
		background: var(--ab, var(--border));
		-webkit-transform: translateX(var(--x, 0));
		transform: translateX(var(--x, 0));
	}
	.check_box_with_label label{
		display: block;
		cursor: pointer;
		margin-bottom: 15px;
	}
	.check_box_with_label input[type='checkbox']:checked {
		--ab: var(--active-inner);
		--x: 17px;
		--b: var(--active);
		--bc: var(--active);
		--d-o: .3s;
		--d-t: .6s;
		--d-t-e: cubic-bezier(.2, .85, .32, 1.2);
	}
	input.disabled {
	  cursor: not-allowed;
    }
    .cardtender{
    padding: 0;
    box-shadow: none;
    background-color: rgba(0,0,0,.03);
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}
.cardtender .card-header{
    background: #f3f3f4;
}
.hide_reys{
    display: none !important;
}
    .headar_th:hover,
    .selected{
        background: #c8d3f2 !important;
    }
        .headar_th{
        cursor: pointer;
    }
</style>
