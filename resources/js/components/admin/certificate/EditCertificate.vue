<template>
	<div class="edit_certificate">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				     {{$t('Guvoxnomani tahrirlash')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/certificate">
					<span class="peIcon pe-7s-back"></span>
						{{$t('Orqaga')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveCertificate" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="name">{{$t('Nomi')}}</label>
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
			...mapGetters('certificate',['getMassage','getCertificate'])
		},
		async mounted(){
			await this.actionEditCertificate(this.$route.params.certificateId)
			this.laoding = false
			this.form = this.getCertificate
		},
		methods:{
			...mapActions('certificate',['actionUpdateCertificate','actionEditCertificate']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveCertificate(){
		    	if (this.form.name != ''){
					this.laoding = true
					await this.actionUpdateCertificate(this.form)
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/certificate");
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
