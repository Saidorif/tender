<template>
	<div class="add_cont">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-cog"></i>
				    Настройка системы
				</h4>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveSetting" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="salary">Стоимость заявки</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="salary" 
					    	placeholder="Стоимость заявки..."
					    	v-model="form.salary"
					    	:class="isRequired(form.salary) ? 'isRequired' : ''"  
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
	import Loader from '../../Loader'
	import {mapActions, mapGetters} from 'vuex'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				form:{
					salary:'',
				},
				requiredInput:false,
				laoding: true
			}
		},
		async mounted(){
			await this.actionSetting()
			console.log(this.getSetting)
			this.laoding = false
		},
		computed:{
			...mapGetters('setting',['getMassage','getSetting'])
		},
		methods:{
			...mapActions('setting',['actionSetting','actionUpdateSetting']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async saveSetting(){
		    	if (this.form.salary != ''){
					this.laoding = true
					await this.actionUpdateSetting(this.form)
					this.laoding = false
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.requiredInput =false
					}else{
						toast.fire({
					    	type: 'error',
					    	icon: 'error',
							title: this.getMassage.message,
					    })
					}
				}else{
					this.requiredInput =true
				}
		    }
		}
	}
</script>
<style scoped>
	
</style>