<template>
	<div class="edit_area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Изменить Area
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/area"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveArea" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="region_id">Regions</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.region_id" 
					    	:class="isRequired(form.region_id) ? 'isRequired' : ''"  
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-9">
					    <label for="name">Area</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="name" 
					    	placeholder="Area"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-lg-3 form_btn">
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
					region_id:'',
					name:'',
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('region',['getMassage','getRegionList']),
			...mapGetters('area',['getMassage','getArea']),
		},
		async mounted(){
			await this.actionRegionList()
			await this.actionEditArea(this.$route.params.areaId)
			this.form = this.getArea
		},
		methods:{
			...mapActions('region',['actionRegionList']),
			...mapActions('area',['actionUpdateArea','actionEditArea']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveArea(){
		    	if (this.form.name != '' && this.form.region_id != ''){
					await this.actionUpdateArea(this.form)
					this.$router.push("/crm/area");
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