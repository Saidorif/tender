<template>
	<div class="edit_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Изменить Область
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/region"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveRegion" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="name">Область</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="name" 
					    	placeholder="Область"
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
					name:''
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('region',['getMassage','getRegion'])
		},
		async mounted(){
			await this.actionEditRegion(this.$route.params.regionId)
		},
		methods:{
			...mapActions('region',['actionUpdateRegion','actionEditRegion']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveRegion(){
		    	if (this.form.name != ''){
					await this.actionUpdateRegion(this.form)
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