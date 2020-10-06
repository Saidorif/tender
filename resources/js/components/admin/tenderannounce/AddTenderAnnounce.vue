<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    Добавить объявление тендера
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/tenderannounce">
					<span class="peIcon pe-7s-back"></span> 
					Назад
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveTender" >
					<div class="row">
					  <div class="form-group col-md-3">
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
					  <div class="form-group col-md-5">
					    <label for="address">Адрес</label>
					    <input type="text" class="form-control input_style" v-model="form.address" id="address">	
					  </div>
					  <div class="form-group col-md-2">
					    <label for="checked">Пакет</label>
					    <input 
					    	type="checkbox" 
					    	class="form-control input_style" 
					    	v-model="checked" 
					    	id="checked"
				    	>	
					  </div>
					  <div class="form-group col-md-4">
					    <label for="checked">Маршрут</label>
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
							selectLabel="Нажмите Enter, чтобы выбрать"
							deselectLabel="Нажмите Enter, чтобы удалить"
							:option="[{name: 'Otash', id: 1}]"
							@select="dispatchAction"
							>
							<span slot="noResult">По вашему запросу ничего не найдено</span>
							<span slot="noOptions">Cписок пустой</span>
						</multiselect>	
					  </div>
					  <div class="form-group col-md-2">
					    <label for="checkedGrafik">График</label>
					    <input 
					    	type="checkbox" 
					    	class="form-control input_style" 
					    	v-model="checkedGrafik" 
					    	id="checkedGrafik"
				    	>	
					  </div>
					  <div class="form-group col-md-2 form_btn" v-if="checked">
						<button type="button" class="btn btn-secondary" @click="addToAllItems">
							<i class="fas fa-plus"></i>
							Добавить
						</button>
				  	  </div>
					  <div class="form-group col-lg-4 form_btn d-flex justify-content-end">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	Сохранить
						</button>	
				  	  </div>
					</div>
				</form>
				<!-- From Name -->
				<div v-if="checkedGrafik">
				  	<div class="table-responsive" v-if="fromItems.length">
				  		<div class="d-flex justify-content-center">
				  			<h4>{{fromName}}</h4>
				  		</div>
					  	<table class="table table-bordered table-hover">
					  		<thead>
					  			<tr>
					  				<th>№</th>
					  				<th v-for="(item,index) in fromFirstItems.reys_times" colspan="2">{{item.where.name}}</th>
					  			</tr>
					  		</thead>
					  		<tbody>
					  			<tr 
					  				v-for="(items,index) in fromItems" 
					  				@click.prevent="chooseFromItem(items,index)"
					  				:class="activeClass(items) ? 'active' : ''"
				  				>
					  				<td>
					  					<label>
				  							{{index+1}}
				  						</label>
					  				</td>
					  				<template v-for="(item,key) in items.reys_times">
						  				<td>{{item.start}}</td>
						  				<td>{{item.end}}</td>
					  				</template>
					  			</tr>
					  		</tbody>
					  	</table>
				  	</div>
				  	<!-- To Name -->
				  	<div class="table-responsive" v-if="fromItems.length">
				  		<div class="d-flex justify-content-center">
				  			<h4>{{toName}}</h4>
				  		</div>
					  	<table class="table table-bordered table-hover">
					  		<thead>
					  			<tr>
					  				<th>№</th>
					  				<th v-for="(item,index) in  toFirstItems.reys_times" colspan="2">{{item.where.name}}</th>
					  			</tr>
					  		</thead>
					  		<tbody>
					  			<tr v-for="(items,index) in  toItems">
					  				<td>
					  					<label>
				  							{{index+1}}
				  						</label>
					  				</td>
					  				<template v-for="(item,key) in items.reys_times">
						  				<td>{{item.start}}</td>
						  				<td>{{item.end}}</td>
					  				</template>
					  			</tr>
					  		</tbody>
					  	</table>
				  	</div>
				</div>
			  	<!-- All choosen tables -->
	<!-- 		  	<div class="table-responsive">
			  		<div class="d-flex justify-content-center">
			  			<h4>Выбранные маршруты</h4>
			  		</div>
				  	<div class="choosenItemsTable">
				  		<ul v-for="(item,index) in choosenFromItems">
				  		    <li>
				  		    	<h4>{{index+1}}</h4>
				  		    	<button class="btn btn-outline-success" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index" aria-expanded="false" :aria-controls="'collapseExample'+index">
								    {{item.reys_times[0].where.name}}-{{item.where.name}}
							  	</button>
							  	<div class="collapse" :id="'collapseExample'+index">
								  <table class="table table-bordered table-hover">
								  		<tbody>
								  			<tr>
								  				<template v-for="(val,key) in item.reys_times">
									  				<td>{{val.start}}</td>
									  				<td>{{val.end}}</td>
								  				</template>
								  			</tr>
								  		</tbody>
								  	</table>
								</div>
				  			</li>
				  		</ul>
				  	</div>
			  	</div> -->
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import DatePicker from "vue2-datepicker";
	import Multiselect from 'vue-multiselect';
	import { mapGetters , mapActions } from 'vuex'
	export default{
		components: {
	    	DatePicker,
	    	Multiselect,
	  	},
		data(){
			return{
				form:{
					time:'',
					direction_ids:[],
					address:'',
					type:'simple',
				},
				requiredInput:false,
				direction_ids:{},
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
						this.choosenFromItems = ''
						this.fromFirstItems = []
						this.fromItems = []
						this.choosenToItems = []
						this.toFirstItems = []
						this.toItems = []
					}
				}
			}
		},
		mounted(){

		},
		methods:{
			...mapActions('tenderannounce',['actionAddTenderAnnounce']),
			...mapActions('direction',['actionDirectionFind']),
			...mapActions("passportTab", [
		      "actionGetScheduleTable",
		    ]),
		    addToAllItems(){
		    	if(this.checkedGrafik){
		    		console.log(this.choosenFromItems)
		    		let data = {
		    			direction_id:'',
		    			reys_id:'',
		    			status:'grafik', 
		    		}
		    	}else{
		    		let data = {
		    			direction_id:'',
		    			reys_id:'',
		    			status:'grafik', 
		    		}
		    	}
		    },
		    activeClass(item){
		    	if (this.choosenFromItems.some(data => data.id === item.id)){
	    			return true
		    	}else{
		    		return false
		    	}
		    },
		    chooseFromItem(value,index){
		    	if (this.choosenFromItems.some(data => data.id === value.id)){
			    	Vue.delete(this.choosenFromItems, index)
		    	}else{
			    	this.choosenFromItems.push(value)
		    	}
		    	console.log(this.choosenFromItems)
		    },
			// removeDirection(value){
			// 	this.form.direction_ids = this.form.direction_ids.filter((item,index)=>{
			// 		if(item != value.id){
			// 			return item
			// 		}
			// 	})
			// },
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
		    async dispatchAction(data){
	      		this.form.direction_ids.push(data.id);
		      	await this.actionGetScheduleTable(data.id)
		      	console.log(this.getSchedule)
			      // From Items
				this.fromFirstItems = this.getSchedule.whereFrom[0];
				this.fromItems = this.getSchedule.whereFrom
				this.fromName = this.getSchedule ? this.getSchedule.whereFrom[0].reys_times[0].where.name : ''
				// To Items
				this.toFirstItems = this.getSchedule.whereTo[0]
				this.toItems = this.getSchedule.whereTo
				this.toName = this.getSchedule ? this.getSchedule.whereTo[0].reys_times[0].where.name : ''
		    },
			async saveTender(){
		    	if (this.form.name != ''){
					await this.actionAddTenderAnnounce(this.form)
					console.log(this.getMassage)
					// this.$router.push("/crm/tenderannounce");
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
	tr{
		cursor:pointer !important;
	}
	tr.active{
		background:#d6d6d6;
	}
</style>