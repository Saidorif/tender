<template>
	<div class="add_area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-route"></i>
				    Добавить направление
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/direction"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveDirection" enctype="multipart/form-data">
					<div class="row">
					  <div class="form-group col-md-6">
					    <label for="seria">Серия направления</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.seria" 
					    	:class="isRequired(form.seria) ? 'isRequired' : ''"  
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.key" v-for="(item,index) in serias">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="number">Номер направления</label>
					    <input 
					    	class="form-control input_style" 
					    	v-model="form.number" 
					    	:class="isRequired(form.number) ? 'isRequired' : ''"  
					    	placeholder="Номер направления..." 
				    	/>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="region_from_id">Regions (From)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.region_from_id" 
					    	:class="isRequired(form.region_from_id) ? 'isRequired' : ''"  
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="region_to_id">Regions (To)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.region_to_id" 
					    	:class="isRequired(form.region_to_id) ? 'isRequired' : ''"  
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="area_from_id">Area (From)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.area_from_id" 
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="area_to_id">Area (To)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.area_to_id" 
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
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
					region_from_id:'',
					region_to_id:'',
					area_from_id:'',
					area_to_id:'',
					seria:'',
					number:'',
				},
				serias:[
					{key:1,name:"ШЧ"},
					{key:2,name:"ШЧЙТ"}
				],
				requiredInput:false,
			}
		},
		computed:{
			...mapGetters('region',['getMassage','getRegionList']),
			...mapGetters('area',['getMassage']),
		},
		async mounted(){
			await this.actionRegionList()
		},
		methods:{
			...mapActions('region',['actionRegionList']),
			...mapActions('area',['actionAddArea']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			saveDirection(){
				if (this.form.region_from_id != '' && this.form.region_to_id != '' && this.form.seria != '' && this.form.number != ''){
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
		    },
		}
	}
</script>
<style scoped>
	
</style>