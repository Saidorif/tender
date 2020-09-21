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
					<template>						
					  <div class="form-group col-md-3">
					    <label for="auto_number">Номер Авто</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="auto_number" 
					    	placeholder="Номер Авто"
					    	v-model="form.auto_number"
					    	:class="isRequired(form.auto_number) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="bustype_id">Тип Авто</label>
					    <select 
						    class="form-control input_style" 
					    	id="bustype_id" 
					    	placeholder="Номер Авто"
					    	v-model="form.bustype_id"
					    	:class="isRequired(form.bustype_id) ? 'isRequired' : ''" 

					    >
					    	<option value="">Выберите тип авто!</option>
					    	<option :value="busType.id" v-for="(busType,index) in getTypeofbusList">{{busType.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="busmodel_id">Модель Авто</label>
					    <select 
						    class="form-control input_style" 
					    	id="busmodel_id" 
					    	placeholder="Номер Авто"
					    	v-model="form.busmodel_id"
					    	:class="isRequired(form.busmodel_id) ? 'isRequired' : ''" 

					    >
					    	<option value="">Выберите модель авто!</option>
					    	<option :value="busmodel.id" v-for="(busmodel,index) in getBusmodelList">{{busmodel.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="tclass_id">Класс Авто</label>
					    <select 
						    class="form-control input_style" 
					    	id="tclass_id" 
					    	placeholder="Номер Авто"
					    	v-model="form.tclass_id"
					    	:class="isRequired(form.tclass_id) ? 'isRequired' : ''" 

					    >
					    	<option value="" v-for="(busType,index) in getTypeofbusList">{{busType.name}}</option>
					    </select>
					  </div>
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
					  	<button type="button" class="btn btn-secondary mr-3">
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
					auto_number:'',
					bustype_id:'',
					busmodel_id:'',
					tclass_id:'',
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
			async saveApplication(){
		    	if (this.form.name != ''){
					await this.actionAddApplication(this.form)
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
	
</style>