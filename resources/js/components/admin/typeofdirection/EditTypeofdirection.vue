<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-border-style"></i>
				    Редактировать тип направления
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/region"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveType" >
					<div class="row">
					  <div class="form-group col-md-6">
					    <label for="name">Название</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="name" 
					    	placeholder="Название"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="type">Тип</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="type" 
					    	placeholder="Тип"
					    	v-model="form.type"
					    	:class="isRequired(form.type) ? 'isRequired' : ''"  
				    	>
				    	<small>Например: <em>ВШ</em></small>
					  </div>
					  <div class="form-group col-lg-12 d-flex justify-content-end">
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
					name:'',
					type:''
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('region',['getMassage'])
		},
		mounted(){

		},
		methods:{
			...mapActions('region',['actionAddRegion']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveType(){
		    	if (this.form.name != ''){
					await this.actionAddRegion(this.form)
					this.$router.push("/crm/region");
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