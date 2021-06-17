<template>
	<div class="add_comission">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    {{$t('Komissiya qoʼshish')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/comission"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveComission" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="name">{{$t('Viloyat')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-lg-3 form_btn">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	{{$t('Saqlash')}}
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
			...mapGetters('comission',['getMassage'])
		},
		mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('comission',['actionAddComission']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveComission(){
		    	if (this.form.name != ''){
					this.laoding = true
					await this.actionAddComission(this.form)
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/comission");
						this.requiredInput = false
					}
					this.laoding = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>

</style>
