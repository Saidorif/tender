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
			...mapGetters('tenderannounce',['getMassage'])
		},
		mounted(){

		},
		methods:{
			...mapActions('tenderannounce',['actionEditTenderAnnounce','actionUpdateTenderAnnounce']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveRegion(){
		    	if (this.form.name != ''){
					await this.actionAddTenderAnnounce(this.form)
					this.$router.push("/crm/tenderannounce");
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>