<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-sign"></i>
				    Редактировать условный символ 
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/conditionalsign"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveSign" >
					<div class="row">
					  <div class="form-group col-md-9">
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
					name:'',
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('conditionalsign',['getMassage'])
		},
		async mounted(){
			await this.actionEditConditionalSign(this.$route.params.conditionalsignId)
		},
		methods:{
			...mapActions('conditionalsign',['actionEditConditionalSign','actionUpdateConditionalSign']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveSign(){
		    	if (this.form.name != ''){
		    		let data = {
		    			id: this.$route.params.conditionalsignId,
		    			items:this.form
		    		}
					await this.actionUpdateConditionalSign(data)
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/conditionalsign");
						this.requiredInput = false
					}
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
	
</style>