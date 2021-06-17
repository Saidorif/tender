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
		  		<div>
		  			O‘ZBEKISTON RESPUBLIKASI TRANSPORT VAZIRLIGI 
		  		</div>
		  		<div>
					{{form.seria}}{{form.number}}-son {{form.direction ? form.direction.name : ''}}-nomli
					yo‘nalishda qatnovlarni amalga oshirish huquqini tasdiqlovchi 
		  		</div>
		  		<div>
		  			GUVOHNOMA
		  		</div>
		  		<div>
					Ushbu guvohnoma {{form.company_name}} ga 
	          		(tashuvchining nomi)
		  		</div>
		  		<div>
					guvohnoma egasi____________________________dagi_________-sonli 
					                                                           hartnoma sanasi va raqami)
					shartnomaga asosan
		  		</div>
				<div>
					guvohnoma raqami __________________ davlat raqami________________________
		            (avtotransport vositasi ro‘yxatdan o‘tkazilganligi to‘g‘risidagi ma’lumotlar)
				</div>				
				<div>
					rusumi____________________________________________________bo‘lgan
					(yo‘nalishda qatnovchi avtotransport vositasiga tegishli ma’lumotlar)
				</div>
				<div>
					avtotransport vositasida
					____- sonli_______________________________________yo‘nalishda
                 	(yo‘nalish raqami va nomi)
				</div>
				<div>
					__________________________________________________sanasigacha 
	                          (guvohnomaning amal qilish muddati)
				</div>
				<div>
					qatnovlarni amalga oshirish huquqiga egaligini tasdiqlaydi.
				</div>
				<div>
				    <img :src='"/"+form.qr_code' alt="">          	
              	</div>              
              	<div>
					{{form.seria}} {{form.number}}
              	</div>


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
