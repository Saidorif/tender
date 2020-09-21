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
		  		<form @submit.prevent.enter="saveApplication" >
					<div class="row">
					<template v-for="(item,key) in form.cars">	
					  <div class="col-md-12">
					  	<h5>
					  		<b>{{key+1}} )</b>
					  		<button 
					  			type="button" 
					  			class="btn btn-danger mr-3" 
					  			@click.prevent="deleteCar(key)" 
					  			v-if="form.cars.length > 1"
				  			>
						  		<i class="fas fa-trash"></i>
							  	Удалить авто
							</button>
					  	</h5>	 					
	  	 			  </div>	 				
					  <div class="form-group col-md-3">
					    <label for="auto_number">Номер Авто</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="auto_number" 
					    	placeholder="Номер Авто"
					    	v-model="item.auto_number"
					    	:class="isRequired(item.auto_number) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="bustype_id">Тип Авто</label>
					    <select 
						    class="form-control input_style" 
					    	id="bustype_id" 
					    	placeholder="Номер Авто"
					    	v-model="item.bustype_id"
					    	:class="isRequired(item.bustype_id) ? 'isRequired' : ''" 
					    	@change="selectClass(item, key)"
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
					    	v-model="item.busmodel_id"
					    	:class="isRequired(item.busmodel_id) ? 'isRequired' : ''" 
					    	@change="selectClass(item, key)"
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
					    	v-model="item.tclass_id"
					    	:class="isRequired(item.tclass_id) ? 'isRequired' : ''" 

					    >
					    	<option value="" selected disabled>Выберите класс авто!</option>
					    	<option :value="busClass.id" v-for="(busClass,index) in item.tclasses">{{busClass.name}}</option>
					    </select>
					  </div>
					  <hr>
					</template>	
				  	  <div class="form-group col-md-4">
					    <label for="seat">Вместимость</label>
					    <input 
					    	type="number" 
					    	class="form-control input_style" 
					    	id="seat" 
					    	placeholder="Вместимость"
					    	v-model="form.seat"
					    	:class="isRequired(form.seat) ? 'isRequired' : ''"  
				    	>
					  </div>
				  	  <div class="form-group col-md-4">
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
					  <div class="form-group col-lg-4 form_btn">
					  	<button type="button" class="btn btn-secondary mr-3" @click.prevent="addCar">
					  		<i class="fas fa-plus"></i>
						  	Добавить авто 
						</button>
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	Сохранить
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
	export default{
		data(){
			return{
				form:{
					cars:[
						{
							auto_number:'',
							bustype_id:'',
							busmodel_id:'',
							tclass_id:'',
							tclasses:[]
						}
					],
					seat:'',
					tarif:''
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('application',['getMassage']),
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
			await this.actionTypeofbusList()
			await this.actionBusmodelList()
		},
		methods:{
			...mapActions('application',['actionAddApplication']),
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList']),
			...mapActions('busclass',['actionBusclassFind']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async selectClass(item, key){
		    	if (item.bustype_id && item.busmodel_id) {
		    		let data = {
		    			'bustype_id':item.bustype_id,
		    			'busmodel_id':item.busmodel_id
		    		}
			    	await this.actionBusclassFind(data)
		    		item.tclasses = this.getBusclassFindList
		    	}
		    },
		    addCar(){
		    	let item = {
		    		auto_number:'',
					bustype_id:'',
					busmodel_id:'',
					tclass_id:'',
					tclasses:[],
		    	}
		    	this.form.cars.push(item)
		    },
		    deleteCar(index){
		    	this.form.cars.splice(index, 1);
		    },
			async saveApplication(){
		    	if (this.form.seat != '' && this.form.tarif != ''){
					await this.actionAddApplication(this.form)
					// this.$router.push("/crm/application");
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
	
</style>