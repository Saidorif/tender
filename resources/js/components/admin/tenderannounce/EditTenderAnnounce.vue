<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    Редактировать объявление тендера
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/tenderannounce">
					<span class="peIcon pe-7s-back"></span> 
					Назад
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveTender" >
					<div class="row">
					  <div class="form-group col-md-2">
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
					  <div class="form-group col-md-2">
					    <label for="address">Адрес</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	v-model="form.address" 
					    	id="address"
					    	:class="isRequired(form.address) ? 'isRequired' : ''"
				    	>	
					  </div>
					  <div class="form-group col-md-1 check_box_with_label">
					    <label for="checked">Пакет</label>
					    <input 
					    	type="checkbox" 
					    	class="form-control input_style" 
					    	v-model="checked" 
					    	id="checked"
				    	>	

					  </div>
					  <div class="form-group col-md-3">
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
							selectLabel="Нажмите Enter, чтобы выбрать"
							deselectLabel="Нажмите Enter, чтобы удалить"
							:option="[{name: 'Otash', id: 1}]"
							@select="dispatchAction"
							>
							<span slot="noResult">По вашему запросу ничего не найдено</span>
							<span slot="noOptions">Cписок пустой</span>
						</multiselect>	
					  </div>
					  <div class="form-group col-md-1 check_box_with_label">
					    <label for="checkedGrafik">График</label>
					    <input 
					    	type="checkbox" 
					    	class="form-control input_style" 
					    	v-model="checkedGrafik" 
					    	id="checkedGrafik"
				    	>	
					  </div>
					  <div class="form-group col-lg-3 form_btn d-flex justify-content-end">
						<button v-if="checked" type="button" class="btn btn-secondary mr-3" @click="addToAllItems">
							<i class="fas fa-plus"></i>
							Добавить
						</button>
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
					  				:class="activeFromClass(items) ? 'active' : ''"
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
					  	<table class="table table-bordered">
					  		<thead>
					  			<tr>
					  				<th>№</th>
					  				<th v-for="(item,index) in toFirstItems.reys_times" colspan="2">{{item.where.name}}</th>
					  			</tr>
					  		</thead>
					  		<tbody>
					  			<tr 
					  				v-for="(items,index) in  toItems"
					  				@click.prevent="chooseToItem(items,index)"
					  				:class="activeToClass(items) ? 'active' : ''"
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
				</div>
				<!-- All edit choosen tables -->
			  	<div class="table-responsive" v-if="edit_direction_ids.length > 0">
			  		<div class="d-flex justify-content-center">
			  			<h4>Маршруты</h4>
			  		</div>
				  	<div class="choosenItemsTable">
				  		<ul v-for="(items,index) in edit_direction_ids">
			  		    	<!-- <h4>{{index+1}})</h4> -->
			  		    	<template>
					  		    <!-- <li class="mb-2" v-if="getLengthReys(lots[index],items.reysesTo) > 0"> -->
					  		    <li class="mb-2">
					  		    	<div class="d-flex align-items-center">
						  		    	<button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index+'from'" aria-expanded="false" :aria-controls="'collapseExample'+index+'from'">
						  		    		<template>
											    <span>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</span> 
											    <span>({{getLengthReys(lots[index],items.reysesFrom)}} рейсы)</span>
						  		    		</template>
									  	</button>
									  	<button 
									  		type="button" 
									  		class="btn btn-danger" 
									  		@click.prevent="removeFromEditItems(lots[index],items.reysesFrom)"
								  		>
									  		<i class="fas fa-trash"></i>
									  	</button>
					  		    	</div>
								  	<div class="collapse" :id="'collapseExample'+index+'from'" v-if="items.reysesFrom.length > 0">
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
									</div>
					  			</li>
					  		    <!-- <li v-if="getLengthReys(lots[index],items.reysesTo) > 0"> -->
					  		    <li>
					  		    	<div class="d-flex align-items-center">
						  		    	<button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index+'to'" aria-expanded="false" :aria-controls="'collapseExample'+index+'to'">
						  		    		<template>
											    <span>{{items.reysesTo[0].where.name}} - {{items.reysesTo[0].from.name}}</span> 
											    <span>({{getLengthReys(lots[index],items.reysesTo)}} рейсы)</span>
						  		    		</template>
									  	</button>
									  	<button 
									  		type="button" 
									  		class="btn btn-danger" 
									  		@click.prevent="removeFromEditItems(lots[index],items.reysesTo)"
								  		>
									  		<i class="fas fa-trash"></i>
									  	</button>
					  		    	</div>
								  	<div class="collapse" :id="'collapseExample'+index+'to'" v-if="items.reysesTo.length > 0">
									  <table class="table table-bordered table-hover">
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
									</div>
					  			</li>
			  		    	</template>
			  		    	<template v-if="lots[index].reys_id == 0">
			  		    		<li>
					  		    	<div class="d-flex align-items-center">
						  		    	<button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index" aria-expanded="false" :aria-controls="'collapseExample'+index">
						  		    		<template>
						  		    			<span>{{items.name}}</span>
						  		    		</template>
									  	</button>
									  	<button type="button" class="btn btn-danger" 
									  		@click.prevent="removeFromEditItems(null,items)"
								  		>
									  		<i class="fas fa-trash"></i>
									  	</button>
					  		    	</div>
				  		    	</li>
			  		    	</template>
				  		</ul>
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
								  				<th>№</th>
								  				<th v-for="(item,index) in item.reyses[0].reys_times" colspan="2">
									  				{{item.where.name}}
									  			</th>
								  			</tr>
								  		</thead>f
								  		<tbody>
								  			<tr v-for="(reys,key) in item.reyses">
								  				<td>{{key+1}}</td>
								  				<template v-for="(val,key) in reys.reys_times">
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
			  	</div>

			  	

			  	<!-- edit items -->
<!-- 			  	<div v-for="(direct,i) in edit_direction_ids">
				  	<div class="table-responsive" v-if="direct.reysesFrom.length">
				  		<div class="d-flex justify-content-center">
				  			<h4>{{direct.reysesFrom[0].where.name}}-{{direct.reysesFrom[0].from.name}}</h4>
				  		</div>
					  	<table class="table table-bordered table-hover">
					  		<thead>
					  			<tr>
					  				<th>№</th>
					  				<th v-for="(item,index) in direct.reysesFrom[0].reys_times" colspan="2">{{item.where.name}}</th>
					  			</tr>
					  		</thead>
					  		<tbody>
					  			<tr 
					  				v-for="(items,index) in direct.reysesFrom" 
					  				:class="activeEditClass(lots[i],items.id) ? 'active' : ''"
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
				  	<div class="table-responsive" v-if="direct.reysesTo.length">
				  		<div class="d-flex justify-content-center">
				  			<h4>{{direct.reysesFrom[0].from.name}}-{{direct.reysesFrom[0].where.name}}</h4>
				  		</div>
					  	<table class="table table-bordered table-hover">
					  		<thead>
					  			<tr>
					  				<th>№</th>
					  				<th v-for="(item,index) in  direct.reysesTo[0].reys_times" colspan="2">{{item.where.name}}</th>
					  			</tr>
					  		</thead>
					  		<tbody>
					  			<tr 
					  				v-for="(items,index) in direct.reysesTo"
					  				:class="activeEditClass(lots[i],items.id) ? 'active' : ''"
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
				lots:[],
			}
		},
		computed:{
			...mapGetters('tenderannounce',['getMassage','getTenderAnnounce']),
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
		async mounted(){
			await this.actionEditTenderAnnounce(this.$route.params.tenderannounceId)
			this.form.time = this.getTenderAnnounce.time
			this.form.address = this.getTenderAnnounce.address
			this.edit_direction_ids= this.getTenderAnnounce.direction_ids
			this.lots= this.getTenderAnnounce.tenderlots
			// console.log(this.getTenderAnnounce)
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
		    async removeFromEditItems(lots,reys){
		    	let reys_id = []
		    	let direction_id = 0;
		    	if (lots) {
			    	let lot_list = lots.reys_id
			    	reys.forEach((item,index)=>{
				    	if (lot_list.includes(item.id)) {
				    		reys_id.push(item.id)
				    		direction_id = item.direction_id
				    	}
			    	})
		    	}else{
		    		direction_id = reys.id
		    	}
		    	let data = {
		    		id:this.$route.params.tenderannounceId,
		    		direction_id,
		    		reys_id
		    	}
		    	await this.actionDeleteTenderAnnounceItem(data)
		    	if (this.getMassage.success) {
				 	await this.actionEditTenderAnnounce(this.$route.params.tenderannounceId)
			    	toast.fire({
						type: "success",
						icon: "success",
						title: this.getMassage.message
				 	});
		    	}
		    },
		    activeEditClass(lots,id){
		    	if (lots.length > 0) {
			    	let lot_list = lots.reys_id
		    		if (lot_list.includes(id)) {
		    			return true
		    		}
		    	}
		    },
		    getLengthReys(lots,reys){
		    	console.log(reys)
		    	console.log(lots)
		    	if (lots.length > 0) {
			    	let lot_list = lots.reys_id
			    	let count = 0;
			    	reys.forEach((item,index)=>{
				    	if (lot_list.includes(item.id)) {
				    		count++
				    	}
			    	})
			    	return count
		    	}
		    },
		    addToAllItems(){
		    	if (Object.keys(this.direction_ids).length > 0) {
			    	if (this.checked) {
				    	if(this.checkedGrafik){
				    		if (this.choosenFromItems.length > 0) {
					    		let value = {
					    			directions:this.direction_ids,
					    			reyses:this.choosenFromItems
					    		}
					    		this.allItems.push(value)
				    		}
				    		if (this.choosenToItems.length > 0) {
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
				    		this.allItems.push(value)
				    		this.choosenFromItems = []
				    		this.choosenToItems = []
				    		this.direction_ids = {}
				    	}
			    	}
		    	}
		    },
		    activeFromClass(item){
		    	if (this.choosenFromItems.some(data => data.id === item.id)){
	    			return true
		    	}else{
		    		return false
		    	}
		    },
		    activeToClass(item){
		    	if (this.choosenToItems.some(data => data.id === item.id)){
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
		    },
		    chooseToItem(value,index){
		    	if (this.choosenToItems.some(data => data.id === value.id)){
			    	Vue.delete(this.choosenToItems, index)
		    	}else{
			    	this.choosenToItems.push(value)
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
		    async dispatchAction(data){
	      		this.form.direction_ids.push(data.id);
		      	await this.actionGetScheduleTable(data.id)
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
				if(this.checked){
					if (this.allItems.length > 0){
						data = this.allItems.map((item,index)=>{
							let direction_id = item.directions.id
							let reysItems = [] 
							if (item.reyses.length > 0){
								reysItems = item.reyses.map((i,k)=>{
									return i.id
								})
							}
							return{
								'direction_id':direction_id,
								'reys_id':reysItems,
			    				'status':reysItems.length > 0 ? 'custom' : 'all', 
							}
						})
					}
					// else{
					// 	let newItems = this.choosenFromItems.map((item,index)=>{
					// 		return item.id
					// 	})
					// 	data = [{
			  //   			direction_id:this.direction_ids.id,
			  //   			reys_id:newItems,
			  //   			status:'custom', 
			  //   			time:this.form.time,
					// 		address:this.form.address,
			  //   		}]
					// }
				}
				else if(this.checkedGrafik && !this.checked){
					let newFromItems = this.choosenFromItems.map((item,index)=>{
						return item.id
					})
					let newToItems = this.choosenToItems.map((item,index)=>{
						return item.id
					})
					data = [{
		    			direction_id:this.direction_ids.id,
		    			reys_id:newFromItems,
		    			status:'custom',
		    		},{
		    			direction_id:this.direction_ids.id,
		    			reys_id:newToItems,
		    			status:'custom', 
		    		}]
				}
				else if(!this.checkedGrafik && !this.checked){
					data = [{
		    			direction_id:this.direction_ids.id,
		    			reys_id:[],
		    			status:'all', 
		    		}]
				}
				let checkLengthData = true
				if (this.checked && this.allItems.length < 2) {
					checkLengthData = false
				}
				let checkLengthDataExists = true
				data.forEach((data,index)=>{
					if (data.direction_id) {
						checkLengthDataExists = true
					}else{
						checkLengthDataExists = false
					}
				})
				let newData = {
					data:data,
					time:this.form.time,
					address:this.form.address,
				}
		    	if (this.form.time != '' && this.form.address != ''){
		    		if (checkLengthDataExists) {
			    		if (checkLengthData) {
							await this.actionAddTenderAnnounce(newData)
							if (this.getMassage.success) {
								console.log(this.getMassage)
								toast.fire({
									type: "success",
									icon: "success",
									title: this.getMassage.message
							 	});
								this.requiredInput = false
								this.$router.push("/crm/tenderannounce");
							}
			    		}else{
			    			toast.fire({
								type: "error",
								icon: "error",
								title: 'В пакете должны быть минимум 2 маршрута!'
						 	});
			    		}
		    		}else{
		    			toast.fire({
							type: "error",
							icon: "error",
							title: 'Маршрут выберите!'
					 	});
		    		}
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
	.check_box_with_label{

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
</style>