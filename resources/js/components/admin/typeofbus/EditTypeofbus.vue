<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bus"></i>
				    Редактировать тип автобуса
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/typeofbus"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveType" >
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
					  <div class="form-group col-lg-3 d-flex justify-content-end saveBtn">
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
			...mapGetters('typeofbus',['getMassage','getTypeofbus'])
		},
		async mounted(){
			await this.actionEditTypeofbus(this.$route.params.typeofbusId)
			this.form = this.getTypeofbus
		},
		methods:{
			...mapActions('typeofbus',['actionEditTypeofbus','actionUpdateTypeofbus']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveType(){
		    	if (this.form.name != ''){
					await this.actionUpdateTypeofbus(this.form)
		    		if (this.getMassage.success) {
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
				          });
						this.$router.push("/crm/typeofbus");
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
	.saveBtn{
		margin-top:30px;
	}
</style>