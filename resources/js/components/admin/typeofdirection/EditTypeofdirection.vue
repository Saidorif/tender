<template>
	<div class="add_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-border-style"></i>
				    {{$t('Tahrirlash')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/typeofdirection"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveType" >
					<div class="row">
					  <div class="form-group col-md-6">
					    <label for="name">{{$t('Nomi')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="type">{{$t('Turi')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="type"
					    	v-model="form.type"
					    	:class="isRequired(form.type) ? 'isRequired' : ''"
				    	>
				    	<small>{{$t('Namuna')}}: <em>{{$t('VSH')}}</em></small>
					  </div>
					  <div class="form-group col-lg-12 d-flex justify-content-end">
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
					name:'',
					type:''
				},
				requiredInput:false,
				laoding: true
			}
		},
		computed:{
			...mapGetters('typeofdirection',['getMassage','getTypeofdirection'])
		},
		async mounted(){
			await this.actionEditTypeofdirection(this.$route.params.typeofdirectionId)
			this.form = this.getTypeofdirection
			this.laoding = false
		},
		methods:{
			...mapActions('typeofdirection',['actionEditTypeofdirection','actionUpdateTypeofdirection']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveType(){
		    	if (this.form.name != '' && this.form.type != ''){
					this.laoding = true
					await this.actionUpdateTypeofdirection(this.form)
					this.laoding = false
		    		if (this.getMassage.success) {
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
				          });
						this.$router.push("/crm/typeofdirection");
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
