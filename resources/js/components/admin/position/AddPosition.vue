<template>
	<div class="add_role">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Добавить Должность
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/position"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="savePosition" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="roleName">Название должность</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="roleName" 
					    	placeholder="Должность"
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
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				form:{
					name:'',
				},
				requiredInput:false,
				laoding: true
			}
		},
		mounted(){
			this.laoding = false
		},
		computed:{
			...mapGetters('position',['getMassage'])
		},
		methods:{
			...mapActions('position',['actionAddPosition']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async savePosition(){
		    	if (this.form.name != ''){
					this.laoding = true
					await this.actionAddPosition(this.form)
					this.laoding = false
					this.$router.push("/crm/position");
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