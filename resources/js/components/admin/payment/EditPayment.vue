<template>
	<div class="edit_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-money-bill-alt"></i>
				    Изменить Платеж
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/payment">
					<span class="peIcon pe-7s-back"></span> 
					Назад
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="savePayment" >
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
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				form:{
					name:''
				},
				requiredInput:false,
				laoding: true
			}
		},
		computed:{
			...mapGetters('payment',['getMassage','getPayment'])
		},
		async mounted(){
			await this.actionEditPayment(this.$route.params.regionId)
			this.laoding = false
			this.form = this.getRegion
		},
		methods:{
			...mapActions('payment',['actionUpdatePayment','actionEditPayment']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async savePayment(){
		    	if (this.form.name != ''){
					this.laoding = true
					await this.actionUpdatePayment(this.form)
					this.laoding = false

					this.$router.push("/crm/payment");
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