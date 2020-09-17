<template>
	<div class="add_cont">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    Добавить вариант жалобы
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/complaint"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveComplt" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="name">Заголовок</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="name" 
					    	placeholder="Заголовок"
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
	import {mapActions, mapGetters} from 'vuex'
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
			...mapGetters('complaint',['getMassage','getComplaint'])
		},
		async mounted(){
			await this.actionEditComplaint(this.$route.params.complaintId)
			this.form = this.getComplaint
		},
		methods:{
			...mapActions('complaint',['actionUpdateComplaint','actionEditComplaint']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async saveCont(){
		    	if (this.form.name != ''){
					await this.actionUpdateComplaint(this.form)
					this.$router.push("/crm/complaint");
					this.requiredInput =false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Жалоба изменена!',
				    })
				}else{
					this.requiredInput =true
				}
		    }
		}
	}
</script>
<style scoped>
	
</style>